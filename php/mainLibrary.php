<?php
    date_default_timezone_set("UTC");
    if (!isset($apiUsage)) {
        $apiUsage = 0;
    }

    require_once(__DIR__."/config/dev_configs.php");

    //=============================================================================================================\\
    //-------------------------------------------- Database work --------------------------------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Orders handling \\
    function controlOpenOrders() {
        global $_RPC_USER,         
               $_RPC_PASSWORD,
               $_SERVERNAME,         
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER,
               $_TRUSTED_CONFIRMS;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);    
        if (!$connToMixer) {            
            $errorMessage = mysqli_connect_error();
            writeLog_unableToConnectToOrdersDatabase($errorMessage);            
            return;
        }

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        $check   = $bitcoin -> getnetworkinfo();
        if ($check === false) {
            mysqli_close($connToMixer);
            $errorMessage = $bitcoin -> error;
            writeLog_unableToConnectToBitcoinServer($errorMessage);
            return;
        }

        $openOrders    = mysqli_query($connToMixer, query_selectOpenOrders());
        $numOpenOrders = mysqli_num_rows($openOrders);

        for ($i = 0; $i < $numOpenOrders; $i++) {
            $openOrder = mysqli_fetch_assoc($openOrders);
            $newIncome = $bitcoin -> getreceivedbyaddress($openOrder["incomingAddress"], $_TRUSTED_CONFIRMS) -
                         $openOrder["incomingAmount"];

            if ($newIncome > $openOrder["minimumIncome"] and defineMaximumIncome($openOrder["code"], $connToMixer, $bitcoin) >= 0) {
                $profit = $newIncome*$openOrder["commission"]*0.01;
                $toSend = $newIncome - $profit;
                $profit = round($profit, 8);

                $check = mysqli_query($connToMixer, query_updateIncomingAmount($openOrder["incomingAddress"],  $openOrder["incomingAmount"]+$newIncome));
                if ($check) {
                    $check = mysqli_query($connToMixer, query_insertProcessingOrder($openOrder, $toSend, $profit));  
                    if ($check) {
                        writeLog_addedProcOrder($openOrder['incomingAddress'], $newIncome);
                    } else {
                        $orderInfo = var_export($openOrder, true);
                        writeLog_failedToAddProcOrder($orderInfo);
                    }         
                    $check = mysqli_query($connToMixer, query_insertCodeWithSumOnDuplicateUpdate($openOrder["code"], $newIncome));
                    if ($check) {
                        writeLog_refreshedCodeWithSum($openOrder['code'], $newIncome);
                    } else {
                        writeLog_failedToRefreshCodeWithSum($openOrder['code'], $openOrder['incomingAddress'], $newIncome);
                    } 
                } else {
                    $orderInfo = var_export($openOrder, true);
                    writeLog_failedToRefreshIncomingAmnt($newIncome, $orderInfo);
                }           
            }
        }
        mysqli_close($connToMixer);
    }

    function controlProcessingOrders() {
        global $_RPC_USER,         
               $_RPC_PASSWORD,
               $_SERVERNAME,
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER,      
               $_TRUSTED_CONFIRMS;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {
            $errorMessage = mysqli_connect_error();
            writeLog_unableToConnectToOrdersDatabase($errorMessage);            
            return;
        }

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);   
        $check   = $bitcoin -> getnetworkinfo();
        if ($check === false) {
            mysqli_close($connToMixer);
            $errorMessage = $bitcoin -> error;
            writeLog_unableToConnectToBitcoinServer($errorMessage);
            return;
        }

        $procOrders    = mysqli_query($connToMixer, query_selectPendingProcOrders());
        $numProcOrders = mysqli_num_rows($procOrders);

        for ($i = 0; $i < $numProcOrders; $i++) {
            $procOrder   = mysqli_fetch_assoc($procOrders);
            $totalToSend = 0;
            for ($h=0; $h<$procOrder["outputsNumber"];$h++) {
                $totalToSend += $procOrder["amountToSend{$h}"];
            }
            $totalReceived = $bitcoin -> getreceivedbyaddress($procOrder["incomingAddress"], $_TRUSTED_CONFIRMS);
            if ($totalToSend < $totalReceived) {
                $orderStatus = checkAndResend($procOrder, $connToMixer, $bitcoin);
                if ($orderStatus["unsent outputs"]) {
                    $outputInfo  = defineTransactionOutputs($procOrder);
                    if ($outputInfo["amountToSend"] > 0) {
                        $tempDelayed = array();
                        while (count($outputInfo["addressesAndAmounts"]) > 0) {
                            $inputInfo = defineTransactionInputs($outputInfo["amountToSend"],
                                                                 $procOrder["code"],
                                                                 $connToMixer,
                                                                 $bitcoin);
                            if ($inputInfo != "Unsufficient funds") {
                                $txid = sendTransaction($inputInfo, 
                                                        $outputInfo, 
                                                        $procOrder["minerRate"], 
                                                        $connToMixer, 
                                                        $bitcoin);
                                if (gettype($txid) == "string") {
                                    $check = refreshProcOrderInformation_firstSend($procOrder,
                                                                                   $outputInfo["addressesAndAmounts"],
                                                                                   $txid,
                                                                                   $connToMixer);
                                    if ($check) {
                                        writeLog_successfulFirstSend($procOrder['incomingAddress'], $procOrder['processingTime'], $txid);
                                    } else {
                                        writeLog_successfulFirstSend_errorUpdatingDB($procOrder['incomingAddress'], $procOrder['processingTime'], $txid);
                                    }
                                } else {
                                    $errorMessage = var_export($txid, true);
                                    writeLog_failedFirstSend($procOrder['incomingAddress'], $procOrder['processingTime'], $errorMessage);
                                    $check = putErrorStatus($procOrder["incomingAddress"], $procOrder["processingTime"], $connToMixer);
                                    if ($check) {
                                        writeLog_putProcOrderOnHold($procOrder["incomingAddress"], $procOrder["processingTime"]);
                                    } else {
                                        writeLog_failedToPutProcOrderOnHold($procOrder["incomingAddress"], $procOrder["processingTime"]);                                        
                                    }
                                }
                                break 1;
                            } else {
                                $addressToDelete = array_rand($outputInfo["addressesAndAmounts"], 1);
                                $outputInfo["amountToSend"] -= $outputInfo["addressesAndAmounts"][$addressToDelete];
                                unset($outputInfo["addressesAndAmounts"][$addressToDelete]);
                                $index = substr(array_search($addressToDelete, $procOrder), -1);
                                if ($procOrder["tempDelayed{$index}"] == "no") {
                                    array_push($tempDelayed, $addressToDelete);
                                }
                            }
                        }
                        if (count($tempDelayed) > 0) {
                            $check = markTempDelayedAddresses($procOrder, $tempDelayed, $connToMixer);
                            if ($check) {
                                writeLog_markedTempDelay($procOrder["incomingAddress"], $procOrder["processingTime"], $tempDelayed);
                            } else {
                                writeLog_failedToMarkTempDelay($procOrder["incomingAddress"], $procOrder["processingTime"], $tempDelayed);
                            }
                        }
                    }
                } else {
                    if (!$orderStatus["unconfirmed outputs"]) {
                        $check = mysqli_query($connToMixer, query_updateProcOrder_done($procOrder["incomingAddress"], $procOrder["processingTime"]));
                        if ($check) {
                            writeLog_procOrderDone($procOrder['incomingAddress'], $procOrder['processingTime']);
                            $stamp = time();
                            $check1 = writeStatistics($stamp, 
                                                      $procOrder["outputsNumber"], 
                                                      $procOrder["profit"],
                                                      $procOrder["commission"]);
                            if ($check1) {
                                writeLog_updatedStats($procOrder['profit']);
                            } else {
                                writeLog_failedToUpdateStats($stamp, $procOrder['outputsNumber'], $procOrder['profit']);
                            }
                        } else {
                            writeLog_procOrderDone_failedToUpdateDB($procOrder["incomingAddress"], $procOrder["processingTime"]);
                        }                                    
                    }
                }
            } else {
                $date = date("j F Y, H:i:s", time()+10800);
                $orderInfo = var_export($procOrder, true);
                writeLog_maliciousProcOrder($orderInfo);
                $check = putErrorStatus($procOrder["incomingAddress"], $procOrder["processingTime"], $connToMixer);
                if ($check) {
                    writeLog_maliciousProcOrder_putOnHold($procOrder['incomingAddress'], $procOrder['processingTime']);
                } else {
                    writeLog_maliciousProcOrder_failedToPutOnHold($procOrder['incomingAddress'], $procOrder['processingTime']);
                }
            }
        }
        mysqli_close($connToMixer);
    }

    function putErrorStatus($incomingAddress, $processingTime, $connToMixer) {
        $update = mysqli_query($connToMixer, query_updateProcOrder_error($incomingAddress, $processingTime));
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    function markTempDelayedAddresses($procOrder, $delayedAddresses, $connToMixer) {
        $update = mysqli_query($connToMixer, query_updateProcOrder_tempDelayed($procOrder, $delayedAddresses));
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    function refreshProcOrderInformation_firstSend($procOrder, $outputInfo, $TXID, $connToMixer) {
        $update = mysqli_query($connToMixer, query_updateProcOrder_firstSend($procOrder, $outputInfo, $TXID));
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    function refreshProcOrderInformation_resend($procOrder, $oldTXID, $newTXID, $connToMixer) {
        $update = mysqli_query($connToMixer, query_updateProcOrder_resend($procOrder, $oldTXID, $newTXID));
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    function checkAndResend($procOrder, $connToMixer, $bitcoin) {
        global $_A_WALLET_PASSPHRASE,
               $_MAX_UNCONF_BLOCKS;

        $TXIDs = array();
        $sentAddresses = 0;

        for ($i = 0; $i < $procOrder["outputsNumber"]; $i++) {
            if ($procOrder["amountToSend{$i}"] == 0 and !array_key_exists($procOrder["TXID{$i}"], $TXIDs)) {
                $TXIDs[$procOrder["TXID{$i}"]] = array("addresses"  => array($procOrder["address{$i}"]), 
                                                       "blockCount" => $procOrder["blockCount{$i}"]);
                $sentAddresses += 1;
            } elseif ($procOrder["amountToSend{$i}"] == 0 and array_key_exists($procOrder["TXID{$i}"], $TXIDs)) {
                array_push($TXIDs[$procOrder["TXID{$i}"]]["addresses"], $procOrder["address{$i}"]);
                $sentAddresses += 1;
            }
        }     
      
        $errors  = array();

        $existsUnconfirmedTX = false;

        foreach ($TXIDs as $TXID => $TXinfo) {
            $info   = $bitcoin -> gettransaction($TXID);
            $height = $bitcoin -> getblockcount();

            if ($info["confirmations"] === 0) {
                $existsUnconfirmedTX = true;

                if ($height - $TXinfo["blockCount"] > $_MAX_UNCONF_BLOCKS and existsTempDelayed($connToMixer)) {
                    $decode = $bitcoin -> decoderawtransaction($info["hex"]);
                    $input  = array();
                    for ($i = 0; $i < count($decode["vin"]); $i++) {
                        $input[$i] = array("txid" => $decode["vin"][$i]["txid"],
                                           "vout" => $decode["vin"][$i]["vout"]);
                    }
                    $currentRate = calculateCommission($TXID);
                    $optimalRate = getMinerFeeRate();
                    if ($optimalRate > $currentRate + 20) {
                        $additionalCommission = ($optimalRate-$currentRate)*((4*$decode["vsize"] - $decode["size"])/3)*0.00000001;
                    } else {
                        $additionalCommission = 0.2*$currentRate*((4*$decode["vsize"] - $decode["size"])/3)*0.00000001;
                    }                    
                    $inputAmount = 0;
                    $output = array();
                    for ($i = 0; $i < count($decode["vout"]); $i++) {
                        if ( in_array($decode["vout"][$i]["scriptPubKey"]["addresses"][0], $TXinfo["addresses"]) ) {
                            $inputAmount += $decode["vout"][$i]["value"];                        
                        }
                        $output[$decode["vout"][$i]["scriptPubKey"]["addresses"][0]] = $decode["vout"][$i]["value"];
                    }    
                    foreach ($output as $address => $value) {
                        if ( in_array($address, $TXinfo["addresses"]) ) {
                            $output[$address] -= $additionalCommission*$value/$inputAmount;
                            if ($output[$address] <= 0) {
                                $output[$address] = round(5*$value/6, 8);
                            } else {
                                $output[$address] = round($output[$address], 8);
                            }
                        }                    
                    }
                    $rawHash = $bitcoin -> createrawtransaction($input, $output, 0, true);

                    if (gettype($rawHash) == "string") {
                        $bitcoin -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
                        $signedTx = $bitcoin -> signrawtransaction($rawHash);
                        if (gettype($signedTx) == "array" and $signedTx["complete"] === true) {
                            $newTXID = $bitcoin -> sendrawtransaction($signedTx["hex"]);
                            if (gettype($newTXID) == "string") {
                                $check = refreshProcOrderInformation_resend($procOrder, $TXID, $newTXID, $connToMixer);
                                if ($check) {
                                    writeLog_successfulResend($procOrder['incomingAddress'], 
                                                              $procOrder['processingTime'],
                                                              $newTXID,
                                                              $TXID);
                                } else {
                                    writeLog_successfulResend_failedToUpdateDB($procOrder['incomingAddress'], 
                                                                               $procOrder['processingTime'], 
                                                                               $newTXID, 
                                                                               $TXID);
                                }
                            } else {
                                $clientMessage = $bitcoin -> error;
                                $currentData   = array("TXinfo" => $TXinfo,
                                                       "input"  => $input,
                                                       "output" => $output);
                                $currentData   = var_export($currentData, true);
                                $errors[$TXID] = array("Error class"    => "send",
                                                       "Current data"   => $currentData,
                                                       "Client message" => $clientMessage);
                            }
                        } elseif (gettype($signedTx) != "array") {
                            $clientMessage = $bitcoin -> error;
                            $currentData   = array("TXinfo" => $TXinfo,
                                                   "input"  => $input,
                                                   "output" => $output);
                            $currentData   = var_export($currentData, true);
                            $errors[$TXID] = array("Error class"    => "sign",
                                                   "Current data"   => $currentData,
                                                   "Client message" => $clientMessage);
                        }
                    } else {
                        $clientMessage = $bitcoin -> error;
                        $currentData   = array("TXinfo" => $TXinfo,
                                               "input"  => $input,
                                               "output" => $output);
                        $currentData   = var_export($currentData, true);
                        $errors[$TXID] = array("Error class"    => "create",
                                               "Current data"   => $currentData,
                                               "Client message" => $clientMessage);
                    }   
                }
            }            
        }

        if (count($errors) > 0) {
            $errorMessage = var_export($errors, true);
            writeLog_failedResending($errorMessage);
            $check = putErrorStatus($procOrder["incomingAddress"], $procOrder["processingTime"], $connToMixer); 
            if ($check) {
                writeLog_failedResending_putOnHold($procOrder['incomingAddress'], $procOrder['processingTime']);
            } else {
                writeLog_failedResending_failedToPutOnHold($procOrder['incomingAddress'], $procOrder['processingTime']);
            }
        }
        return array("unsent outputs"      => $sentAddresses < $procOrder["outputsNumber"], 
                     "unconfirmed outputs" => $existsUnconfirmedTX);
    }

    function existsTempDelayed($connToMixer) {
        $select = mysqli_query($connToMixer, query_selectTempDelayed());
        $num    = mysqli_num_rows($select);
        return ($num > 0);   
    }

    function sendTransaction($inputInfo, $outputInfo, $minerRate, $connToMixer, $bitcoin) {
        global $_A_WALLET_PASSPHRASE; 

        $numberOfInputs  = count($inputInfo["txidsAndVouts"]);
        $changeAddress   = false;

        if ($inputInfo["inputAmount"] > $outputInfo["amountToSend"] + 0.0000543) {
            $changeAmount     = round($inputInfo["inputAmount"] - $outputInfo["amountToSend"], 8);
            $changeAddress    = $bitcoin -> getnewaddress();
            $outputInfo["addressesAndAmounts"][$changeAddress] = $changeAmount;
        }

        $strippedSize = 64*count($inputInfo["txidsAndVouts"]) + 34*count($outputInfo["addressesAndAmounts"]) + 10;

        $futureRawHash  = $bitcoin -> createrawtransaction($inputInfo["txidsAndVouts"], 
                                                           $outputInfo["addressesAndAmounts"], 
                                                           0,
                                                           true);
        $bitcoin        -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
        $futureSignedTx = $bitcoin -> signrawtransaction($futureRawHash);
        $futureTxInfo   = $bitcoin -> decoderawtransaction($futureSignedTx["hex"]);
        if (gettype($futureTxInfo) == "array") {
            $size           = $futureTxInfo["size"];
            $vsize          = $futureTxInfo["vsize"];
            $strippedSize   = floor(($vsize*4 - $size)/3);
        }

        minRelayFeeNotMet:
        $optCommission = $strippedSize*$minerRate*0.00000001;
        $optCommission = min($optCommission, $outputInfo["amountToSend"]/2);

        foreach ($outputInfo["addressesAndAmounts"] as $address => $amountToThisAddress) {
            if ($address !== $changeAddress) {
                $outputInfo["addressesAndAmounts"][$address] = round($amountToThisAddress*(1 - $optCommission/$outputInfo["amountToSend"]), 8);
            }
        }

        shuffle($inputInfo["txidsAndVouts"]);
        $outputInfo["addressesAndAmounts"] = shuffle_assoc($outputInfo["addressesAndAmounts"]);

        $rawHash = $bitcoin -> createrawtransaction($inputInfo["txidsAndVouts"], 
                                                    $outputInfo["addressesAndAmounts"], 
                                                    0,
                                                    true);
        if (gettype($rawHash) != "string") {
            $clientMessage = $bitcoin -> error; 
            $currentData   = array("input"  => $inputInfo,
                                   "output" => $outputInfo);
            $currentData   = var_export($currentData, true);
            return array("Error class"    => "create",
                         "Current data"   => $currentData,
                         "Client message" => $clientMessage);
        }

        $bitcoin  -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
        $signedTx = $bitcoin -> signrawtransaction($rawHash);

        if (gettype($signedTx) != "array") {
            $clientMessage = $bitcoin -> error; 
            $currentData   = array("input"  => $inputInfo,
                                   "output" => $outputInfo);
            $currentData   = var_export($currentData, true);
            return array("Error class"    => "sign",
                         "Current data"   => $currentData,
                         "Client message" => $clientMessage);
        }

        $txid = $bitcoin -> sendrawtransaction($signedTx["hex"]);

        if (gettype($txid) == "string" and $changeAddress !== false) {
            markChangeAddress($changeAddress, $inputInfo["usedAddresses"], $connToMixer);
            return $txid;
        } elseif (gettype($txid) == "string" and $changeAddress === false) {
            return $txid;
        } else {
            $clientMessage = $bitcoin -> error;

            if ($clientMessage == "66: min relay fee not met") {
                $minerRate = 1;
                goto minRelayFeeNotMet;
            }

            $currentData   = array("input"  => $inputInfo,
                                   "output" => $outputInfo);
            $currentData = var_export($currentData, true);
            return array("Error class"    => "send",
                         "Current data"   => $currentData,
                         "Client message" => $clientMessage);
        }       
    }
    
    function shuffle_assoc($array) {
        $keys = array_keys($array);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }
        return $new;
    }

    function defineTransactionInputs($amountToSend, $code, $connToMixer, $bitcoin) {
        global $_TRUSTED_CONFIRMS,
               $_MAIN_ACCOUNT;

        $wholeUnspent    = $bitcoin -> listunspent(1, 9999999);
        $possibleUnspent = array();
        $index           = 0;
        $confirmedAmount = 0;

        foreach ($wholeUnspent as $UTXO) {
            if ($UTXO["address"] != $_MAIN_ACCOUNT) {
                if ($UTXO["confirmations"] < $_TRUSTED_CONFIRMS    and 
                    !isAddressOpen($UTXO["address"], $connToMixer) and 
                    !isAddressMarked($UTXO["address"], $code, $connToMixer)) {
                    $confirmedAmount         += $UTXO["amount"];
                    $possibleUnspent[$index]  = $UTXO;
                    $index                   += 1;
                } elseif ($UTXO["confirmations"] >= $_TRUSTED_CONFIRMS and 
                          !isAddressMarked($UTXO["address"], $code, $connToMixer)) {
                    $confirmedAmount         += $UTXO["amount"];
                    $possibleUnspent[$index]  = $UTXO;
                    $index                   += 1;                  
                }
            }            
        }

        $tempAmountToSend = $amountToSend;

        if ($confirmedAmount > $tempAmountToSend) {
            usort($possibleUnspent, function(array $a, array $b) {
            if     ($a["amount"] > $b["amount"]) {return -1;} 
            elseif ($a["amount"] < $b["amount"]) {return  1;} 
            else                                 {return  0;}});

            $index         = 0;
            $inputAmount   = 0;

            while ($inputAmount < $tempAmountToSend) {
                $inputAmount += $possibleUnspent[$index]["amount"];
                $index       += 1;
                if ($index == count($possibleUnspent)) {break 1;}
            }

            $txidsAndVouts = array();
            $usedAddresses = array();
            $start         = 1;
            $finalInputAmt = 0;
            while ($index > 0) {
                $inputAmount = 0;
                if ($start < count($possibleUnspent)) {
                    for ($j = $start; $j < min($index+$start, count($possibleUnspent)); $j++) {
                        $inputAmount += $possibleUnspent[$j]["amount"];
                    }
                }                
                if ($inputAmount >= $tempAmountToSend) {
                    $start += 1;
                } else {
                    $index -= 1;
                    $tempAmountToSend -= $possibleUnspent[$start-1]["amount"];
                    array_push($txidsAndVouts, array("txid" => $possibleUnspent[$start-1]["txid"],
                                                     "vout" => $possibleUnspent[$start-1]["vout"]));
                    if (!in_array($possibleUnspent[$start-1]["address"], $usedAddresses)) {
                        array_push($usedAddresses, $possibleUnspent[$start-1]["address"]);
                    }
                    $finalInputAmt += $possibleUnspent[$start-1]["amount"];
                    $start += 1;
                }
            }

            return array("txidsAndVouts" => $txidsAndVouts, 
                         "usedAddresses" => $usedAddresses, 
                         "inputAmount"   => $finalInputAmt);
        } else {
            return "Unsufficient funds";
        }       
    }

    function isAddressOpen($address, $connToMixer) {
        if (mysqli_num_rows(mysqli_query($connToMixer, query_selectGivenIncomingAddress($address))) == 1) {
            return true;
        } else {
            return false;
        }
    }

    function defineTransactionOutputs($procOrder) {
        $addressesAndAmounts = array();
        $amountToSend        = 0;
        $time                = time();
        for ($i = 0; $i < $procOrder["outputsNumber"]; $i++) {
            if ($procOrder["amountToSend{$i}"] > 0 and $procOrder["timeToSend{$i}"] < $time) {                
                $addressesAndAmounts[$procOrder["address{$i}"]] = $procOrder["amountToSend{$i}"];
                $amountToSend                                  += $procOrder["amountToSend{$i}"];
            }
        }
        return array("addressesAndAmounts" => $addressesAndAmounts, 
                     "amountToSend"        => $amountToSend);
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Addresses handling \\
    function isAddressMarked($address, $code, $connToMixer) {
        if (mysqli_num_rows(mysqli_query($connToMixer, query_selectGivenAddressWithGivenCode($address, $code))) == 1) {
            return true;
        } else {
            return false;
        }
    }

    function markChangeAddress($changeAddress, $usedAddresses, $connToMixer) {
        $allCodes    = mysqli_query($connToMixer, query_selectAllCodes($usedAddresses));
        $num         = mysqli_num_rows($allCodes);
        $uniqueCodes = "";

        for ($i = 0; $i < $num; $i++) {
            $row         = mysqli_fetch_assoc($allCodes);
            $codes       = $row["codes"];
            $currentCode = "";
            
            for ($j = 0; $j < strlen($codes); $j++) {
                if ($codes[$j] != ";") {
                    $currentCode .= $codes[$j];
                } else {
                    if (strpos($uniqueCodes, $currentCode) === false) {
                        $uniqueCodes .= $currentCode.";";
                    }
                    $currentCode = "";
                }
            }
        }
        
        if ($uniqueCodes != "") {
            $uniqueCodes = substr($uniqueCodes, 0, -1);
            if (mysqli_query($connToMixer, query_insertNewAddressWithCode($changeAddress, $uniqueCodes))) {
                writeLog_markedChangeAddress($changeAddress, $uniqueCodes);
            } else {
                writeLog_failedToMarkChangeAddress($changeAddress, $uniqueCodes);
            }
        }
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Codes handling \\
    function isUsed($code, $connToMixer) {
        $result = mysqli_query($connToMixer, query_selectGivenCode($code));
        if (mysqli_num_rows($result) == 1) {
            return true;                
        } else {
            return false;
        }        
    }

    function defineDiscount($code) {
        global $_SERVERNAME, 
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {return 0;}

        $result = mysqli_query($connToMixer, query_selectGivenCode($code));
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $sum = $row["sum"];
            mysqli_free_result($result);
            mysqli_close($connToMixer);            
        } else {
            mysqli_free_result($result);
            mysqli_close($connToMixer);
            $sum = 0;
        }
        if ($sum < 1) {
            return 0;
        }
        if ($sum < 4) {
            return 0.05;
        }
        if ($sum < 8) {
            return 0.1;
        }
        if ($sum < 16) {
            return 0.15;
        }
        if ($sum < 32) {
            return 0.2;
        }
        return 0.25;
    }

    function defineMaximumIncome($code, $connToMixer, $bitcoin) {
        global $_MAIN_ACCOUNT,
               $_TRUSTED_CONFIRMS;

        $balance = $bitcoin -> getbalance("*", 0);
        if ($balance === false) {return false;}

        $unspentMainAcc = $bitcoin->listunspent(0, 9999999, array($_MAIN_ACCOUNT));
        for ($j = 0; $j < count($unspentMainAcc); $j++) {
            $balance -= $unspentMainAcc[$j]["amount"];
        }
        
        $openCredits = mysqli_query($connToMixer, query_selectCreditInfo_open());
        $num         = mysqli_num_rows($openCredits);
        for ($i = 0; $i < $num; $i++) {
            $current             = mysqli_fetch_assoc($openCredits);
            $waitingTransactions = $bitcoin->listunspent(0, $_TRUSTED_CONFIRMS-1, array($current["incomingAddress"]));
            
            for ($j = 0; $j < count($waitingTransactions); $j++) {
                $balance -= $waitingTransactions[$j]["amount"];
            }

            $unhandledAmount = $bitcoin->getreceivedbyaddress($current["incomingAddress"], $_TRUSTED_CONFIRMS) -
                               $current["incomingAmount"];

            $balance -= $unhandledAmount;
        }

        $procCredits = mysqli_query($connToMixer, query_selectCreditInfo_processing());
        $num         = mysqli_num_rows($procCredits);
        for ($i = 0; $i < $num; $i++) {
            $current = mysqli_fetch_assoc($procCredits);
            for ($j = 0; $j < $current["outputsNumber"]; $j++) {
                $balance -= $current["amountToSend{$j}"];
            }           
        }

        $codeAddresses = mysqli_query($connToMixer, query_selectAddressesWithGivenCode($code));
        $num           = mysqli_num_rows($codeAddresses);
        for ($i = 0; $i < $num; $i++) {
            $current             = mysqli_fetch_assoc($codeAddresses);
            $unspentTransactions = $bitcoin->listunspent(0, 9999999, array($current["address"]));
            for ($j = 0; $j < count($unspentTransactions); $j++) {
                $balance -= $unspentTransactions[$j]["amount"];
            }
        }
        return $balance;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Garbage cleaners \\
    function garbageCleaner_unusedCodesAndAddresses() {
        global $_SERVERNAME,
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connToMixer) {
            $date = date("j F Y, H:i:s", time()+10800);
            $errorMessage = mysqli_connect_error();
            echo "{$date} [error] - There occurred an error while connecting to one of databases. MySQL thrown: {$errorMessage}.".PHP_EOL;
            return;
        }

        $suspiciousCodes = mysqli_query($connToMixer, query_selectZeroSumCodes());
        $numOfSuspCodes  = mysqli_num_rows($suspiciousCodes);
        
        $numOfDeletedCodes     = 0;
        $numOfDeletedAddresses = 0;

        for ($i = 0; $i < $numOfSuspCodes; $i++) {
            $row                = mysqli_fetch_assoc($suspiciousCodes);
            $code               = $row["code"];
            $openOrdersWithCode = mysqli_query($connToMixer, query_selectOpenOrdersWith($code)); 
            if (mysqli_num_rows($openOrdersWithCode) == 0) {
                $check1 = mysqli_query($connToMixer, query_deleteCodeRow($code));
                if (!$check1) {
                    $date = date("j F Y, H:i:s", time()+10800);
                    echo "{$date} [error] - An error occured while deleting unused code {$code}.".PHP_EOL;
                } else {
                    $numOfDeletedCodes += 1;
                }
                $check2 = mysqli_query($connToMixer, query_deleteAddressRow($code));
                if (!$check2) {
                    $date = date("j F Y, H:i:s", time()+10800);
                    echo "{$date} [error] - An error occured while deleting unused addresses with {$code}.".PHP_EOL;
                } else {
                    $numOfDeletedAddresses += 1;
                }
            }
        }       
        mysqli_close($connToMixer); 
        if ($numOfDeletedCodes > 0) {
            $date = date("j F Y, H:i:s", time()+10800);
            if ($numOfDeletedCodes == 1) {                
                echo "{$date} [notice] - 1 code was completely deleted from codes table.".PHP_EOL;
            } else {
                echo "{$date} [notice] - {$numOfDeletedCodes} codes were completely deleted from codes table.".PHP_EOL;
            }            
        }
        if ($numOfDeletedAddresses > 0) {
            $date = date("j F Y, H:i:s", time()+10800);
            if ($numOfDeletedAddresses == 1) {                
                echo "{$date} [notice] - 1 address was completely deleted from addresses table.".PHP_EOL;
            } else {
                echo "{$date} [notice] - {$numOfDeletedAddresses} addresses were completely deleted from addresses table.".PHP_EOL;
            }            
        }
    }   

    function garbageCleaner_usedAddresses() {
        global $_SERVERNAME,
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER,
               $_RPC_USER,
               $_RPC_PASSWORD;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connToMixer) {
            $date = date("j F Y, H:i:s", time()+10800);
            $errorMessage = mysqli_connect_error();
            echo "{$date} [error] - There occurred an error while connecting to addresses database. MySQL thrown: {$errorMessage}.".PHP_EOL;
            return;
        }

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);   
        $check   = $bitcoin -> getnetworkinfo();
        if ($check === false) {mysqli_close($connToMixer); return;}

        $allAddresses   = mysqli_query($connToMixer, query_selectAllAddresses());
        $numOfAddresses = mysqli_num_rows($allAddresses);
        $numOfDeleted   = 0;

        for ($i = 0; $i < $numOfAddresses; $i++) {
            $row     = mysqli_fetch_assoc($allAddresses);
            $address = $row["address"];
            $unspent = $bitcoin -> listunspent(0, 9999999, array($address));
            if (count($unspent) == 0 and !isAddressOpen($address, $connToMixer)) {
                $check = mysqli_query($connToMixer, query_deleteAddress($address));
                if (!$check) {
                    $date = date("j F Y, H:i:s", time()+10800);
                    echo "{$date} [error] - An error occured while deleting the following address {$address} from addresses table.".PHP_EOL;
                } else {
                    $numOfDeleted += 1;
                }
            }            
        }  
        mysqli_close($connToMixer); 
        if ($numOfDeleted > 0) {
            $date = date("j F Y, H:i:s", time()+10800);
            if ($numOfDeleted == 1) {
                echo "{$date} [notice] - 1 address was successfully deleted from database.".PHP_EOL;
            } else {
                echo "{$date} [notice] - {$numOfDeleted} addresses were successfully deleted from database.".PHP_EOL;
            }            
        }      
    }   

    function garbageCleaner_completedOrders() {
        global $_SERVERNAME,
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connToMixer) {
            $date = date("j F Y, H:i:s", time()+10800);
            $errorMessage = mysqli_connect_error();
            echo "{$date} [error] - There occurred an error while connecting to orders database. MySQL thrown: {$errorMessage}.".PHP_EOL;
            return;
        }

        $oldOpenOrders      = mysqli_query($connToMixer, query_selectOldOpenOrders());
        $numOfOldOpenOrders = mysqli_num_rows($oldOpenOrders);
        $numberOfDeleted    = 0;

        for ($i = 0; $i < $numOfOldOpenOrders; $i++) {
            $oldOpenOrder = mysqli_fetch_assoc($oldOpenOrders);
            $correspondingProcOrders = mysqli_query($connToMixer, query_selectProcOrdersWithIncomingAddress($oldOpenOrder["incomingAddress"]));
            $numOfCorrespondingProcOrders = mysqli_num_rows($correspondingProcOrders);
            $toDelete = true;
            for ($j = 0; $j < $numOfCorrespondingProcOrders; $j++) {
                $correspondingProcOrder = mysqli_fetch_assoc($correspondingProcOrders);
                if ($correspondingProcOrder["status"] !== "done") {
                    $toDelete = false;
                    break 1;
                }
            }
            if ($toDelete) {
                $check1 = mysqli_query($connToMixer, query_deleteOpenOrder($oldOpenOrder["incomingAddress"]));
                if (!$check1) {
                    $date = date("j F Y, H:i:s", time()+10800);
                    echo "{$date} [error] - An error occured while deleting an open order with the following incoming address {$oldOpenOrder['incomingAddress']}.".PHP_EOL;
                } 
                $check2 = mysqli_query($connToMixer, query_deleteProcOrders($oldOpenOrder["incomingAddress"]));
                if (!$check2) {
                    $date = date("j F Y, H:i:s", time()+10800);
                    echo "{$date} [error] - An error occured while deleting processing orders with the following incoming address {$oldOpenOrder['incomingAddress']}.".PHP_EOL;
                }
                if ($check1 and $check2) {
                    $numberOfDeleted += 1;
                }
            }
        }
        mysqli_close($connToMixer);
        if ($numberOfDeleted > 0) {
            $date = date("j F Y, H:i:s", time()+10800);
            if ($numberOfDeleted == 1) {                
                echo "{$date} [notice] - 1 order was completely deleted from database.".PHP_EOL;
            } else {
                echo "{$date} [notice] - {$numberOfDeleted} orders were completely deleted from database.".PHP_EOL;
            }            
        }        
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Info handling \\
    function defineMinimumIncome($distribution, $commission, $minerRate) {
        $minClient = round((3*140*0.00000001*$minerRate*100/min($distribution))/(1-$commission*0.01), 8);
        $minOfMin  = round((3*140*0.00000001*getMinerFeeRate()*100/min($distribution))/(1-$commission*0.01), 8);
        return max($minClient, $minOfMin);
    }

    function getMinerFeeRate() {
        global $_SERVERNAME, 
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {
            return 300;
        }

        $row = mysqli_query($connToMixer, query_selectOptimalRate());

        if ($row) {
            $row = mysqli_fetch_assoc($row);
            mysqli_close($connToMixer);            
            return $row["optimalRate"];
        } else {
            mysqli_close($connToMixer);
            return 300;
        }
    }

    function getExchangePrice() {
        global $_SERVERNAME, 
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {
            return 10000;
        }

        $row = mysqli_query($connToMixer, query_selectExchangePrice());

        if ($row) {
            $row = mysqli_fetch_assoc($row);
            mysqli_close($connToMixer);            
            return $row["btcPrice"];
        } else {
            mysqli_close($connToMixer);
            return 10000;
        }
    }

    function refreshMinerFeeRate($newRate) {
        global $_SERVERNAME, 
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {
            return false;
        }
        $result = mysqli_query($connToMixer, query_updateOptimalRate($newRate));

        if ($result) {
            mysqli_close($connToMixer);
            return true;
        } else {
            mysqli_close($connToMixer);
            return false;
        }
    }

    function refreshExchangePrice($price) {
        global $_SERVERNAME, 
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;

        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {
            return false;
        }
        $result = mysqli_query($connToMixer, query_updateExchangePrice($price));

        if ($result) {
            mysqli_close($connToMixer);
            return true;
        } else {
            mysqli_close($connToMixer);
            return false;
        }
    }

    function calculateCommission($txid) {
        global $_RPC_USER, $_RPC_PASSWORD;

        $bitcoin          = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        $rawTransaction   = $bitcoin -> getrawtransaction($txid);
        $humanTransaction = $bitcoin -> decoderawtransaction($rawTransaction);
        $vin              = $humanTransaction["vin"];
        $vout             = $humanTransaction["vout"];
        $size             = $humanTransaction["size"];
        $vsize            = $humanTransaction["vsize"];
        $inputAmount      = 0;
        $outputAmount     = 0;
        for ($i = 0; $i < count($vin); $i++) {
            $rawInputTransaction    = $bitcoin -> getrawtransaction($vin[$i]["txid"]);
            $humanInputTransaction  = $bitcoin -> decoderawtransaction($rawInputTransaction);
            $inputAmount           += $humanInputTransaction["vout"][$vin[$i]["vout"]]["value"];
            
        }
        for ($i = 0; $i < count($vout); $i++) {
            $outputAmount += $vout[$i]["value"];
        }
        $strippedSize = round((4*$vsize - $size)/3);
        return round(($inputAmount-$outputAmount)*100000000/$strippedSize);
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Statistics \\
    function writeStatistics($stamp, $outputsNumber, $profit, $commission) {
        global $_SERVERNAME,
               $_MIXER_USERNAME, 
               $_MIXER_PASSWORD, 
               $_DB_MIXER;
        
        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connToMixer) {
            return false;
        }

        if (mysqli_query($connToMixer, query_insertStatistics($stamp, $outputsNumber, $profit, $commission))) {
            mysqli_close($connToMixer);
            return true;
        } else {
            mysqli_close($connToMixer);
            return false;
        } 
    }

    //=============================================================================================================\\
    //----------------------------------------------- Logging -----------------------------------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Connection errors \\
    function writeLog_unableToConnectToOrdersDatabase($errorMessage) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occurred an error while connecting to orders database. MySQL thrown: {$errorMessage}.".PHP_EOL;
    }

    function writeLog_unableToConnectToAddressesDatabase($errorMessage) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occurred an error while connecting to addresses database. MySQL thrown: {$errorMessage}.".PHP_EOL;
    }

    function writeLog_unableToConnectToCodesDatabase($errorMessage) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occurred an error while connecting to codes database. MySQL thrown: {$errorMessage}.".PHP_EOL;
    }

    function writeLog_unableToConnectToBitcoinServer($errorMessage) {
        $date = date("j F Y, H:i:s", time()+10800);            
        echo "{$date} [error] - There occurred an error while connecting to Bitcoin server. Detailed overview: {$errorMessage}.".PHP_EOL;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Open orders logs \\
    function writeLog_addedProcOrder($incomingAddress, $newIncome) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Successfully added the processing order: {$incomingAddress}, new income: {$newIncome}.".PHP_EOL;
    }

    function writeLog_failedToRefreshIncomingAmnt($newIncome, $orderInfo) {
        $date = date("j F Y, H:i:s", time()+10800);                    
        echo "{$date} [error] - There occurred an error while refreshing incomingAmount field with {$newIncome} BTC. Order information: {$orderInfo}.".PHP_EOL;
    }

    function writeLog_failedToAddProcOrder($orderInfo) {
        $date = date("j F Y, H:i:s", time()+10800);                        
        echo "{$date} [error] - There occurred an error while adding processing order. Order information: {$orderInfo}.".PHP_EOL;
    }

    function writeLog_refreshedCodeWithSum($code, $newIncome) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Successfully updated code {$code} with new income of {$newIncome} BTC.".PHP_EOL;
    }

    function writeLog_failedToRefreshCodeWithSum($code, $incomingAddress, $newIncome) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occurred an error while refreshing the code {$code} for open order {$incomingAddress} with {$newIncome} BTC.".PHP_EOL;
    }    

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Processing orders logs \\
    function writeLog_successfulFirstSend($incomingAddress, $processingTime, $txid) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Processing order ({$incomingAddress}, {$processingTime}): successfully sent the transaction for first time and updated the database, txid: {$txid}".PHP_EOL;
    }

    function writeLog_successfulFirstSend_errorUpdatingDB($incomingAddress, $processingTime, $txid) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Processing order ({$incomingAddress}, {$processingTime}): successfully sent the transaction for first time, txid: {$txid}.".PHP_EOL;
        echo "{$date} [error] - Processing order ({$incomingAddress}, {$processingTime}): database update for first sending has failed for some reason.".PHP_EOL;
    }

    function writeLog_failedFirstSend($incomingAddress, $processingTime, $errorMessage) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occurred an error while first sending. Order key: ({$incomingAddress}, {$processingTime}). Detailed overview: {$errorMessage}".PHP_EOL;
    }

    function writeLog_putProcOrderOnHold($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - The processing order with key ({$incomingAddress}, {$processingTime}) has been put on hold. First sending failed.".PHP_EOL;
    }

    function writeLog_failedToPutProcOrderOnHold($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - The processing order with key ({$incomingAddress}, {$processingTime}) has not been put on hold because of some MySQL error. First sending failed.".PHP_EOL;
    }

    function writeLog_markedTempDelay($incomingAddress, $processingTime, $tempDelayed) {
        $date = date("j F Y, H:i:s", time()+10800);
        $tempDelayed = var_export($tempDelayed, true);
        echo "{$date} [warning] - Payment to the following addresses: {$tempDelayed} is delayed due to unconfirmed change. Order key: ({$incomingAddress}, {$processingTime}).".PHP_EOL;
        echo "{$date} [notice] - Delayed status was successfully added to the DB.".PHP_EOL;
    }

    function writeLog_failedToMarkTempDelay($incomingAddress, $processingTime, $tempDelayed) {
        $date = date("j F Y, H:i:s", time()+10800);
        $tempDelayed = var_export($tempDelayed, true);
        echo "{$date} [warning] - Payment to the following addresses: {$tempDelayed} is delayed due to unconfirmed change. Order key: ({$incomingAddress}, {$processingTime}).".PHP_EOL;
        echo "{$date} [error] - There occured an error while updating temporary delay status in DB.".PHP_EOL;
    }

    function writeLog_procOrderDone($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Successfully processed the order with key: ({$incomingAddress}, {$processingTime}) and updated the DB.".PHP_EOL;
    }

    function writeLog_procOrderDone_failedToUpdateDB($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Successfully processed the order with key: ({$incomingAddress}, {$processingTime}).".PHP_EOL;
        echo "{$date} [error] - There occured an error while marking the order with key: ({$incomingAddress}, {$processingTime}) as done".PHP_EOL;
    }

    function writeLog_updatedStats($profit){
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - The following profit {$profit} was written in statistics database.".PHP_EOL;
    }

    function writeLog_failedToUpdateStats($stamp, $outputsNumber, $profit) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - The following statistics was NOT submitted; stampUTC: {$stamp}, outputsNumber: {$outputsNumber} profit: {$profit}.".PHP_EOL;
    }

    function writeLog_maliciousProcOrder($orderInfo) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - Attention! Somebody is trying to insert a malicious processing order. Detailed overview: {$orderInfo}".PHP_EOL;
    }

    function writeLog_maliciousProcOrder_putOnHold($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - The processing order with key ({$incomingAddress}, {$processingTime}) has been put on hold. Amount to send is greater than incoming amount!".PHP_EOL;
    }

    function writeLog_maliciousProcOrder_failedToPutOnHold($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - The processing order with key ({$incomingAddress}, {$processingTime}) has not been put on hold because of some MySQL error. Amount to send is greater than incoming amount!".PHP_EOL;
    }

    function writeLog_successfulResend($incomingAddress, $processingTime, $newTXID, $TXID) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Successfully resent the transaction with higher fee and updated the database; order key: ({$incomingAddress}, {$processingTime}). New txid: {$newTXID}, old txid: {$TXID}.".PHP_EOL;
    }

    function writeLog_successfulResend_failedToUpdateDB($incomingAddress, $processingTime, $newTXID, $TXID) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Successfully resent the transaction with higher fee; order key: ({$incomingAddress}, {$processingTime}). New txid: {$newTXID}, old txid: {$TXID}.".PHP_EOL;
        echo "{$date} [error] - Database update for resending has failed for some reason.".PHP_EOL;
    }

    function writeLog_failedResending($errorMessage) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occurred an error while resending. Detailed overview: {$errorMessage}".PHP_EOL;
    }

    function writeLog_failedResending_putOnHold($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - The processing order with key ({$incomingAddress}, {$processingTime}) has been successfully put on hold because of resending error.".PHP_EOL;
    }

    function writeLog_failedResending_failedToPutOnHold($incomingAddress, $processingTime) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occured an error while putting processing order with key ({$incomingAddress}, {$processingTime}) on hold.".PHP_EOL;
    }

    function writeLog_markedChangeAddress($changeAddress, $uniqueCodes) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [notice] - Marked change address {$changeAddress} with the following code(s): {$uniqueCodes}.".PHP_EOL;
    }

    function writeLog_failedToMarkChangeAddress($changeAddress, $uniqueCodes) {
        $date = date("j F Y, H:i:s", time()+10800);
        echo "{$date} [error] - There occured an error while marking change address {$changeAddress} with the following code(s): {$uniqueCodes}.".PHP_EOL;
    }

    //=============================================================================================================\\
    //---------------------------------------- Construction of queries --------------------------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Order \\
    function query_insertOpenOrder($order) {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        $outputsNumber = count($order["outputAddresses"]);
        
        $queryText = "INSERT INTO {$_DB_MIXER_TABLE_OPEN_ORDERS} (outputsNumber,";
        for ($i = 0; $i<$outputsNumber; $i++) {
            $queryText .= "address{$i}, 
                           delay{$i}, 
                           distribution{$i},";
        }
        $queryText .= "commission, 
                       code, 
                       incomingAddress,
                       incomingAmount,
                       minimumIncome,
                       creationTime,
                       hCreationTime,
                       minerRate) "; 

        $queryText .=  "VALUES ('{$outputsNumber}',";
        for ($i = 0; $i<$outputsNumber; $i++) {
            $queryText .= "'{$order['outputAddresses'][$i]}', 
                           '{$order['delay'][$i]}', 
                           '{$order['distribution'][$i]}',";
        }  
        $hTime = date("j F, H:i:s", $order['creationTime']+10800);      
        $queryText .= "'{$order['commission']}', 
                       '{$order['code']}', 
                       '{$order['incomingAddress']}',
                       '0', 
                       '{$order['minimumIncome']}', 
                       '{$order['creationTime']}',
                       '{$hTime}',
                       '{$order['minerRate']}')";

        return $queryText;
    }

    function query_insertProcessingOrder($openOrder, $toSend, $profit) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        $time = time();
        $hTime = date("j F, H:i:s", $time+10800);

        $queryText = "INSERT INTO {$_DB_MIXER_TABLE_PROC_ORDERS} (  outputsNumber, 
                                                                    code, 
                                                                    incomingAddress, 
                                                                    processingTime,
                                                                    hProcessingTime, 
                                                                    profit, 
                                                                    commission,
                                                                    minerRate,
                                                                    status,";       

        for ($i = 0; $i<$openOrder["outputsNumber"]; $i++) {
            if ($i+1 < $openOrder["outputsNumber"]) {
                $queryText .= "address{$i}, 
                               amountToSend{$i}, 
                               timeToSend{$i},
                               tempDelayed{$i},";
            } else {
                $queryText .= "address{$i}, 
                               amountToSend{$i}, 
                               timeToSend{$i},
                               tempDelayed{$i}) ";
            }
        }

        $queryText .= "VALUES ('{$openOrder["outputsNumber"]}', 
                               '{$openOrder["code"]}', 
                               '{$openOrder["incomingAddress"]}', 
                               '{$time}',
                               '{$hTime}', 
                               '{$profit}',
                               '{$openOrder["commission"]}', 
                               '{$openOrder["minerRate"]}', 
                               'pending',";
        $nonDelayed = 0;
        for ($i = 0; $i<$openOrder["outputsNumber"]; $i++) {
            if ($openOrder["delay{$i}"] > 0) {
                $randomDelay = random_int(-600, 600);
            } else {
                $randomDelay = random_int($nonDelayed*30, ($nonDelayed+1)*30);
                $nonDelayed += 1;
            }
            if ($i+1 < $openOrder["outputsNumber"]) {
                $queryText .= "'{$openOrder["address{$i}"]}', 
                               '".round($toSend*($openOrder["distribution{$i}"])*0.01, 8)."', 
                               '".($time + 3600*($openOrder["delay{$i}"]) + $randomDelay)."',
                               'no',";
            } else {
                $queryText .= "'{$openOrder["address{$i}"]}', 
                               '".round($toSend*($openOrder["distribution{$i}"])*0.01, 8)."', 
                               '".($time + 3600*($openOrder["delay{$i}"]) + $randomDelay)."',
                               'no')";
            }
        }
        return $queryText;
    } 

    function query_selectOpenOrders() {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        $time = time()-24*3600;
        return "SELECT * FROM {$_DB_MIXER_TABLE_OPEN_ORDERS} WHERE creationTime >= {$time}";
    }

    function query_selectOpenOrdersWith($code) {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        return "SELECT * FROM {$_DB_MIXER_TABLE_OPEN_ORDERS} WHERE BINARY code = '{$code}'";
    }

    function query_selectOpenOrderWithCodeAndAddress($incomingAddress, $code) {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        return "SELECT outputsNumber,
                       incomingAmount,
                       commission,
                       minimumIncome,
                       minerRate,
                       creationTime,
                       address0,
                       distribution0,
                       address1,
                       distribution1,
                       address2,
                       distribution2,
                       address3,
                       distribution3,
                       address4,
                       distribution4,
                       address5,
                       distribution5,
                       address6,
                       distribution6,
                       address7,
                       distribution7,
                       address8,
                       distribution8,
                       address9,
                       distribution9
                FROM {$_DB_MIXER_TABLE_OPEN_ORDERS} 
                WHERE BINARY incomingAddress = '{$incomingAddress}' AND BINARY code = '{$code}'";
    }

    function query_selectOldOpenOrders() {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        $time = time()-24*3600;
        return "SELECT incomingAddress FROM {$_DB_MIXER_TABLE_OPEN_ORDERS} WHERE creationTime < {$time}";
    }

    function query_selectGivenIncomingAddress($address) {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        return "SELECT incomingAddress FROM {$_DB_MIXER_TABLE_OPEN_ORDERS} WHERE BINARY incomingAddress = '{$address}'";
    }

    function query_selectPendingProcOrders() {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "SELECT * FROM {$_DB_MIXER_TABLE_PROC_ORDERS} WHERE status = 'pending'";
    }

    function query_selectProcOrdersWithCodeAndAddress($incomingAddress, $code) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "SELECT status,
                       amountToSend0, timeToSend0, TXID0, tempDelayed0,
                       amountToSend1, timeToSend1, TXID1, tempDelayed1,
                       amountToSend2, timeToSend2, TXID2, tempDelayed2,
                       amountToSend3, timeToSend3, TXID3, tempDelayed3,
                       amountToSend4, timeToSend4, TXID4, tempDelayed4,
                       amountToSend5, timeToSend5, TXID5, tempDelayed5,
                       amountToSend6, timeToSend6, TXID6, tempDelayed6,
                       amountToSend7, timeToSend7, TXID7, tempDelayed7,
                       amountToSend8, timeToSend8, TXID8, tempDelayed8,
                       amountToSend9, timeToSend9, TXID9, tempDelayed9
                FROM {$_DB_MIXER_TABLE_PROC_ORDERS} 
                WHERE BINARY incomingAddress = '{$incomingAddress}' AND BINARY code = '{$code}'";
    }

    function query_selectProcOrdersWithIncomingAddress($incomingAddress) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "SELECT status FROM {$_DB_MIXER_TABLE_PROC_ORDERS} WHERE incomingAddress = '{$incomingAddress}'";
    }

    function query_selectTempDelayed() {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "SELECT incomingAddress FROM {$_DB_MIXER_TABLE_PROC_ORDERS} 
                WHERE status = 'pending' AND 
                ((amountToSend0 > 0 AND tempDelayed0 = 'yes') OR 
                 (amountToSend1 > 0 AND tempDelayed1 = 'yes') OR
                 (amountToSend2 > 0 AND tempDelayed2 = 'yes') OR
                 (amountToSend3 > 0 AND tempDelayed3 = 'yes') OR
                 (amountToSend4 > 0 AND tempDelayed4 = 'yes') OR
                 (amountToSend5 > 0 AND tempDelayed5 = 'yes') OR
                 (amountToSend6 > 0 AND tempDelayed6 = 'yes') OR
                 (amountToSend7 > 0 AND tempDelayed7 = 'yes') OR
                 (amountToSend8 > 0 AND tempDelayed8 = 'yes') OR
                 (amountToSend9 > 0 AND tempDelayed9 = 'yes'))";
    }

    function query_selectCreditInfo_open() {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        return "SELECT code,
                       incomingAddress,
                       incomingAmount   FROM {$_DB_MIXER_TABLE_OPEN_ORDERS}";
    }

    function query_selectCreditInfo_processing() {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "SELECT outputsNumber,
                       amountToSend0,
                       amountToSend1,
                       amountToSend2,
                       amountToSend3,
                       amountToSend4,
                       amountToSend5,
                       amountToSend6,
                       amountToSend7,
                       amountToSend8,
                       amountToSend9  FROM {$_DB_MIXER_TABLE_PROC_ORDERS}";
    }      

    function query_updateIncomingAmount($incomingAddress, $newIncomingAmount) {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        return "UPDATE {$_DB_MIXER_TABLE_OPEN_ORDERS} 
                SET    incomingAmount  = '{$newIncomingAmount}' 
                WHERE  incomingAddress = '{$incomingAddress}'";
    }  

    function query_updateProcOrder_firstSend($procOrder, $outputInfo, $txid) {
        global $_RPC_USER, 
               $_RPC_PASSWORD, 
               $_DB_MIXER_TABLE_PROC_ORDERS;

        $bitcoin       = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        $currentHeight = $bitcoin -> getblockcount();

        $queryText = "UPDATE {$_DB_MIXER_TABLE_PROC_ORDERS} SET ";
        for ($i = 0; $i < $procOrder["outputsNumber"]; $i++) {
            if (array_key_exists($procOrder["address{$i}"], $outputInfo)) {
                $queryText .= "amountToSend{$i} = '0', 
                               TXID{$i} = '{$txid}', 
                               blockCount{$i} = '{$currentHeight}', ";
            }
        }
        $queryText = substr($queryText, 0, -2)." ";
        $queryText .= " WHERE incomingAddress = '{$procOrder["incomingAddress"]}' AND 
                              processingTime  = '{$procOrder["processingTime"]}'";
        return $queryText; 
    }

    function query_updateProcOrder_resend($procOrder, $oldTXID, $newTXID) {
        global $_RPC_USER, 
               $_RPC_PASSWORD, 
               $_DB_MIXER_TABLE_PROC_ORDERS;

        $bitcoin       = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        $currentHeight = $bitcoin -> getblockcount();
        
        $queryText = "UPDATE {$_DB_MIXER_TABLE_PROC_ORDERS} SET ";
        for ($i = 0; $i < $procOrder["outputsNumber"]; $i++) {
            if ($procOrder["TXID{$i}"] == $oldTXID) {
                $queryText .= "TXID{$i} = '{$newTXID}', 
                               blockCount{$i} = '{$currentHeight}', ";
            }
        }
        $queryText = substr($queryText, 0, -2)." ";
        $queryText .= " WHERE incomingAddress = '{$procOrder["incomingAddress"]}' AND 
                              processingTime  = '{$procOrder["processingTime"]}'";
        return $queryText; 
    }

    function query_updateProcOrder_tempDelayed($procOrder, $delayedAddresses) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        $query = "UPDATE {$_DB_MIXER_TABLE_PROC_ORDERS} SET ";
        for ($i = 0; $i < $procOrder["outputsNumber"]; $i++) {
            if (in_array($procOrder["address{$i}"], $delayedAddresses)) {
                $query .= "tempDelayed{$i} = 'yes',";
            }
        }
        $query = substr($query, 0, -1)." ";
        $query .= "WHERE incomingAddress = '{$procOrder['incomingAddress']}' 
                   AND   processingTime  = '{$procOrder['processingTime']}'";
        return $query; 
    }

    function query_updateProcOrder_error($incomingAddress, $processingTime) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "UPDATE {$_DB_MIXER_TABLE_PROC_ORDERS} 
                SET    status = 'error' 
                WHERE  incomingAddress = '{$incomingAddress}' AND 
                       processingTime  = '{$processingTime}'";
    }

    function query_updateProcOrder_done($incomingAddress, $processingTime) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "UPDATE {$_DB_MIXER_TABLE_PROC_ORDERS} SET status = 'done' 
                WHERE  incomingAddress = '{$incomingAddress}' AND 
                       processingTime  = '{$processingTime}'";
    }

    function query_deleteOpenOrder($incomingAddress) {
        global $_DB_MIXER_TABLE_OPEN_ORDERS;
        return "DELETE FROM {$_DB_MIXER_TABLE_OPEN_ORDERS} 
                      WHERE incomingAddress = '{$incomingAddress}'";
    }

    function query_deleteProcOrders($incomingAddress) {
        global $_DB_MIXER_TABLE_PROC_ORDERS;
        return "DELETE FROM {$_DB_MIXER_TABLE_PROC_ORDERS} 
                      WHERE incomingAddress = '{$incomingAddress}'";
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Addresses \\
    function query_insertNewAddressWithCode($address, $code) {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        return "INSERT INTO {$_DB_MIXER_TABLE_A_ADDRESSES} VALUES ('{$address}', '{$code};')";
    }

    function query_selectAddressesWithGivenCode($code) {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        return "SELECT address FROM {$_DB_MIXER_TABLE_A_ADDRESSES} WHERE codes LIKE '%{$code}%'";
    }   
    
    function query_selectAllCodes($addresses) {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        $queryText = "SELECT codes FROM {$_DB_MIXER_TABLE_A_ADDRESSES} WHERE ";
        for ($i = 0; $i < count($addresses); $i++) {
            if ($i < count($addresses)-1) {
                $queryText .= "address = '{$addresses[$i]}' OR ";
            } else {
                $queryText .= "address = '{$addresses[$i]}'";
            }
        }
        return $queryText;
    } 

    function query_selectAllAddresses() {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        return "SELECT address FROM {$_DB_MIXER_TABLE_A_ADDRESSES}";
    }

    function query_selectGivenAddressWithGivenCode($address, $code) {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        return "SELECT address FROM {$_DB_MIXER_TABLE_A_ADDRESSES} WHERE address = '{$address}' AND codes LIKE '%{$code}%'";
    }

    function query_deleteAddressRow($code) {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        return "DELETE FROM {$_DB_MIXER_TABLE_A_ADDRESSES} WHERE codes = '{$code};'";
    }

    function query_deleteAddress($address) {
        global $_DB_MIXER_TABLE_A_ADDRESSES;
        return "DELETE FROM {$_DB_MIXER_TABLE_A_ADDRESSES} WHERE address = '{$address}'";
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Codes \\
    function query_insertCodeWithSumOnDuplicateUpdate($code, $sum) {
        global $_DB_MIXER_TABLE_CODES;
        return "INSERT INTO {$_DB_MIXER_TABLE_CODES} 
                VALUES ('{$code}', '{$sum}', 'no')
                ON DUPLICATE KEY 
                UPDATE sum=sum+{$sum}";
    }
    
    function query_selectGivenCode($code) {
        global $_DB_MIXER_TABLE_CODES;
        return "SELECT * FROM {$_DB_MIXER_TABLE_CODES} WHERE BINARY code = '{$code}'";
    }

    function query_selectZeroSumCodes() {
        global $_DB_MIXER_TABLE_CODES;
        return "SELECT code FROM {$_DB_MIXER_TABLE_CODES} WHERE sum = '0' AND accounted = 'no'";
    }

    function query_deleteCodeRow($code) {
        global $_DB_MIXER_TABLE_CODES;
        return "DELETE FROM {$_DB_MIXER_TABLE_CODES} WHERE BINARY code = '{$code}'";
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Blockchain \\
    function query_selectOptimalRate() {
        global $_DB_MIXER_TABLE_INFO;
        return "SELECT optimalRate FROM {$_DB_MIXER_TABLE_INFO}";
    }

    function query_selectExchangePrice() {
        global $_DB_MIXER_TABLE_INFO;
        return "SELECT btcPrice FROM {$_DB_MIXER_TABLE_INFO}";
    }

    function query_updateOptimalRate($newRate) {
        global $_DB_MIXER_TABLE_INFO;
        return "UPDATE {$_DB_MIXER_TABLE_INFO} SET optimalRate = '{$newRate}'";
    }

    function query_updateExchangePrice($price) {
        global $_DB_MIXER_TABLE_INFO;
        return "UPDATE {$_DB_MIXER_TABLE_INFO} SET btcPrice = '{$price}'";
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Statistics \\
    function query_insertStatistics($stamp, $outputsNumber, $profit, $commission) {
        global $_DB_MIXER_TABLE_STATS;
        return "INSERT INTO {$_DB_MIXER_TABLE_STATS} VALUES ('{$stamp}', 
                                                             '{$outputsNumber}', 
                                                             '{$profit}',
                                                             '{$commission}')";
    }

    //=============================================================================================================\\
    //-------------------------------------------- Client service -------------------------------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Order handlers \\
    function makeOrder($request, $jsfree) {
        global $_SERVERNAME,
               $_MIXER_USERNAME,
               $_MIXER_PASSWORD,
               $_DB_MIXER,
               $_MAIN_ACCOUNT, 
               $_RPC_USER, 
               $_RPC_PASSWORD, 
               $_A_WALLET_PASSPHRASE,
               $_LOG_FILE_OPERATIONS;

        global $apiUsage;
        
        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connToMixer) {
            return array("orderStatus" => "somethingWrong");
        }

        if (!isset($request["code"])) {                 
            $code = generateCode($connToMixer);
        } else {
            $code = $request["code"];
        }

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        $balance = defineMaximumIncome($code, $connToMixer, $bitcoin);

        if ($balance === false) {
            mysqli_close($connToMixer);
            return array("orderStatus" => "somethingWrong");
        }

        if ($balance <= 0) {
            mysqli_close($connToMixer);
            return array("orderStatus" => "noAvailableCoins");
        } 

        $minIncome = defineMinimumIncome($request["distribution"], 
                                         $request["commission"],
                                         $request["minerRate"]);

        if ($balance < $minIncome) {
            mysqli_close($connToMixer);
            return array("balance"       => $balance,
                         "minimumIncome" => $minIncome,
                         "orderStatus"   => "tooHighMinIncome");
        }

        $newAddress = $bitcoin->getnewaddress();
        if ($newAddress === false) {
            mysqli_close($connToMixer);
            return array("orderStatus" => "somethingWrong");
        }

        $currentTime = time();
        $message = generateMessage(array("mainAccount"  => $_MAIN_ACCOUNT,
                                         "addresses"    => $request["outputAddresses"],
                                         "delay"        => $request["delay"],
                                         "distribution" => $request["distribution"],
                                         "commission"   => $request["commission"],
                                         "minerRate"    => $request["minerRate"],
                                         "code"         => $code,
                                         "newAddress"   => $newAddress,
                                         "balance"      => $balance,
                                         "minIncome"    => $minIncome,
                                         "creationTime" => $currentTime));

        $bitcoin -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
        $sign    = $bitcoin->signmessage($_MAIN_ACCOUNT, $message);

        if ($sign === false) {
            mysqli_close($connToMixer);
            return array("orderStatus" => "somethingWrong");
        }

        $letter = generateLetter(array("mainAccount" => $_MAIN_ACCOUNT,
                                       "message"      => $message,
                                       "sign"         => $sign));

        $order = array( "outputAddresses" => $request["outputAddresses"],
                        "delay"           => $request["delay"],
                        "distribution"    => $request["distribution"],
                        "commission"      => $request["commission"],
                        "minerRate"       => $request["minerRate"],
                        "code"            => $code,
                        "incomingAddress" => $newAddress,
                        "minimumIncome"   => $minIncome,
                        "creationTime"    => $currentTime);
        
        mysqli_autocommit($connToMixer, false);
        $check1 = mysqli_query($connToMixer, query_insertNewAddressWithCode($newAddress, $code));
        $check2 = mysqli_query($connToMixer, query_insertCodeWithSumOnDuplicateUpdate($code, 0));
        $check3 = mysqli_query($connToMixer, query_insertOpenOrder($order));
        $date = date("j F Y, H:i:s", $currentTime+10800);

        if ($check1 and $check2 and $check3) {            
            file_put_contents($_LOG_FILE_OPERATIONS, "{$date} [notice] - Successfully added an open order, generated address: {$newAddress}, code: {$code}. API usage: {$apiUsage}, JSfree interface: {$jsfree}.".PHP_EOL, FILE_APPEND);
            mysqli_commit($connToMixer);
            mysqli_close($connToMixer);
            return array("balance"       => $balance, 
                         "newAddress"    => $newAddress, 
                         "letter"        => $letter, 
                         "code"          => $code,
                         "minimumIncome" => $minIncome,
                         "orderStatus"   => "OK");
        } else {
            $error = mysqli_error($connToMixer);
            $check1 = var_export($check1, true);
            $check2 = var_export($check2, true);
            $check3 = var_export($check3, true);
            file_put_contents($_LOG_FILE_OPERATIONS, "{$date} [error] - Failed to add an open order, generated address: {$newAddress}, code: {$code}. Error: {$error}. Queries: address - {$check1}, code - {$check2}, order - {$check3}".PHP_EOL, FILE_APPEND);
            mysqli_rollback($connToMixer);
            mysqli_close($connToMixer);
            return array("orderStatus" => "somethingWrong");
        }
    }

    function generateMessage($information) {
        $mAcc       = $information[ "mainAccount"];
        $adrAr      = $information[  "addresses" ];
        $delAr      = $information[    "delay"   ];
        $distrArr   = $information["distribution"];
        $commission = $information[ "commission" ];
        $minerRate  = $information[  "minerRate" ];
        $bitcode    = $information[    "code"    ];
        $newAd      = $information[ "newAddress" ];
        $balance    = number_format($information["balance"],   8, '.', '');
        $minIncome  = number_format($information["minIncome"], 8, '.', '');
        $time       = $information["creationTime"];

        $message    = "We hereby confirm that WWW.BITWHISK.IO has generated the address {$newAd} in order to transfer incoming amount (minus commission) to the following addresses: ";

        for ($i = 0; $i<count($adrAr); $i++) {
            $message = $message.$distrArr[$i]."% to ".$adrAr[$i]." after ".$delAr[$i]." hours";
            if ($i == count($adrAr)-1) {
                $message = $message.".";
            } else {
                $message = $message.", ";
            }
        }

        $now       = date("j F Y, H:i:s T", $time);
        $next_diem = date("j F Y, H:i:s T", $time + 86400);
        $message   = "{$message} This service will be only available for all bitcoins received from {$now} to {$next_diem} with minimum amount of {$minIncome} BTC per set of transactions included in one block and maximum amount of {$balance} BTC total. Our commission is {$commission}%, miner's fee rate for outcoming transactions is {$minerRate} sat/B. Your BitWhisk code is {$bitcode}, memorize it for future use. This letter is digitally signed by our main account: {$mAcc}. Stay protected and thank you for using our service.";
        return $message;
    }

    function generateLetter($information) {
        global $apiUsage;
        $mAcc = $information["mainAccount"];
        $mes  = $information[  "message"  ];
        $sgn  = $information[   "sign"    ];

        if ($apiUsage) {
            return array("signingBitcoinAddress" => $mAcc,
                         "message"               => $mes,
                         "digitalSignature"      => $sgn);
        }        

        $letter     = "-----START SIGNING BITCOIN ADDRESS-----\r\n{$mAcc}\r\n-----END SIGNING BITCOIN ADDRESS-----\r\n\r\n-----START LETTER OF GUARANTEE-----\r\n{$mes}\r\n-----END LETTER OF GUARANTEE-----\r\n\r\n-----START DIGITAL SIGNATURE-----\r\n{$sgn}\r\n-----END DIGITAL SIGNATURE-----";
        return $letter;
    }

    function checkStatus($incomingAddress, $code) {
        global $_RPC_USER, 
               $_RPC_PASSWORD, 
               $_TRUSTED_CONFIRMS,
               $_SERVERNAME, 
               $_MIXER_USERNAME,
               $_MIXER_PASSWORD,
               $_DB_MIXER; 
               
        $connToMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connToMixer) {
            return array("status" => "error");
        }

        $openOrder = mysqli_query($connToMixer, query_selectOpenOrderWithCodeAndAddress($incomingAddress, $code));
        $isOpen = mysqli_num_rows($openOrder);

        if ($isOpen == 0) {
            mysqli_close($connToMixer);
            return array("status" => "no order");
        } elseif ($isOpen == 1) {
            $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
            $check   = $bitcoin -> getnetworkinfo();
            if ($check === false) {
                mysqli_close($connToMixer);
                return array("status" => "error");
            }
            $maxIncome = defineMaximumIncome($code, $connToMixer, $bitcoin);

            $openOrder = mysqli_fetch_assoc($openOrder);
            $waitingTransactions = $bitcoin->listunspent(0, $_TRUSTED_CONFIRMS-1, array($incomingAddress));
            $waitingAmounts      = array_fill(0, $_TRUSTED_CONFIRMS, 0);
            $waitingAmount       = 0;

            for ($i = 0; $i < count($waitingTransactions); $i++) {
                $waitingAmounts[$waitingTransactions[$i]["confirmations"]] += $waitingTransactions[$i]["amount"];
                $waitingAmount += $waitingTransactions[$i]["amount"];
            }

            $receivedAmount = $bitcoin->getreceivedbyaddress($incomingAddress, $_TRUSTED_CONFIRMS);

            if ($waitingAmount == 0 and $receivedAmount == 0) {
                mysqli_close($connToMixer);
                return array("status"        => "empty order",
                             "minIncome"     => $openOrder["minimumIncome"],
                             "maxIncome"     => $maxIncome,
                             "activeUntil"   => date("j F Y, H:i:s T", $openOrder["creationTime"]+86400));
            }

            if (time() - $openOrder["creationTime"] <= 86400) {
                $addressActive = "true";
            } else {
                $addressActive = "false";
            }

            $response = array("status"         => "full order",
                              "activeUntil"    => date("j F Y, H:i:s T", $openOrder["creationTime"]+86400),
                              "waitingInfo"    => $waitingAmounts,
                              "receivedAmount" => $receivedAmount,
                              "outputsNumber"  => $openOrder["outputsNumber"],
                              "info"           => array());            

            for ($i = 0; $i<$openOrder["outputsNumber"]; $i++) {  
                $response["info"]["output{$i}"] = array("address"     => substr($openOrder["address{$i}"], 0, 4)."...".substr($openOrder["address{$i}"], -3, 3), 
                                                        "numOfPend"   => 0,
                                                        "sentAmount"  => 0);
            }

            $procOrders = mysqli_query($connToMixer, query_selectProcOrdersWithCodeAndAddress($incomingAddress, $code));
            $numProcOrders = mysqli_num_rows($procOrders);
            $anyErrors     = "no";
            $pendingOrders = "no";
            $summaryNeeded = "no";

            for ($i = 0; $i < $numProcOrders; $i++) {
                $summaryNeeded = "yes";
                $procOrder = mysqli_fetch_assoc($procOrders);
                if ($procOrder["status"] == "error") {
                    $anyErrors = "yes";
                }

                for ($j = 0; $j < $openOrder["outputsNumber"]; $j++) {
                    if ($procOrder["amountToSend{$j}"] > 0) {
                        $pendingOrders = "yes";
                        $curPendIndex = $response["info"]["output{$j}"]["numOfPend"];
                        $response["info"]["output{$j}"]["amountToSend{$curPendIndex}"] = $procOrder["amountToSend{$j}"];
                        $response["info"]["output{$j}"]["timeToSend{$curPendIndex}"]   = date("j F Y, H:i:s T", $procOrder["timeToSend{$j}"]);
                        $response["info"]["output{$j}"]["tempDelayed{$curPendIndex}"]  = $procOrder["tempDelayed{$j}"];
                        $response["info"]["output{$j}"]["numOfPend"] += 1;
                    }
                    
                    if ($procOrder["amountToSend{$j}"] == 0) {
                        $TXinfo = $bitcoin -> getrawtransaction($procOrder["TXID{$j}"], 1);
                        for ($k = 0; $k < count($TXinfo["vout"]); $k++) {
                            if ($TXinfo["vout"][$k]["scriptPubKey"]["addresses"][0] == $openOrder["address{$j}"]) {
                                $response["info"]["output{$j}"]["sentAmount"] += $TXinfo["vout"][$k]["value"];
                                break 1;
                            }
                        }
                    }
                }
            }
            mysqli_close($connToMixer);

            $unhandledAmount = $receivedAmount - $openOrder["incomingAmount"];
            $notAssigned = "no";
            if ($unhandledAmount > 0) {
                if ($unhandledAmount >= $openOrder["minimumIncome"] and $maxIncome >= 0 and $addressActive == "true") {
                    $summaryNeeded = "yes";
                    $pendingOrders = "yes";
                    $notAssigned   = "yes";
                    for ($i = 0; $i < $openOrder["outputsNumber"]; $i++) {
                        $curPendIndex = $response["info"]["output{$i}"]["numOfPend"];
                        $response["info"]["output{$i}"]["amountToSend{$curPendIndex}"] = round($unhandledAmount*(1-$openOrder["commission"]*0.01)*$openOrder["distribution{$i}"]*0.01, 8);
                        $response["info"]["output{$i}"]["timeToSend{$curPendIndex}"]   = "not assigned*";
                        $response["info"]["output{$i}"]["tempDelayed{$curPendIndex}"]  = "no";
                        $response["info"]["output{$i}"]["numOfPend"] += 1;
                    }
                    $unhandledAmount = 0;
                }
            }            

            $response["unhandledAmount"] = round($unhandledAmount,8);
            $response["maxIncome"]       = round($maxIncome,8);
            $response["minIncome"]       = $openOrder["minimumIncome"];
            $response["minerRate"]       = $openOrder["minerRate"];
            $response["addressActive"]   = $addressActive;
            $response["anyErrors"]       = $anyErrors;
            $response["summaryNeeded"]   = $summaryNeeded;
            $response["pendingOrders"]   = $pendingOrders;
            $response["notAssigned"]     = $notAssigned;

            return $response;
        }     
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Bitcode handlers \\
    function generateCode($connToMixer) {
        $alphabet = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789";
        while (true) {
            $code = randStr(6, $alphabet);
            if (!isUsed($code, $connToMixer)) {
                return $code;
            }
        }
    }

    function randStr($len, $alph) {
        $str = "";
        $max = strlen($alph)-1;
        for ($i=0; $i<$len; $i++) {
            $index = random_int(0, $max);
            $str  .= $alph[$index];
        }
        return $str;
    }

    //=============================================================================================================\\
    //---------------------------------------------- Validation ---------------------------------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Addresses validation \\
    function validateAddresses($addresses) {
        global $_RPC_USER,
               $_RPC_PASSWORD;       

        if (gettype($addresses) != "string" or $addresses === "" or strlen($addresses) > 749) {
            return false;
        }

        if ($addresses != preg_replace('/[^1234567890ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz;]/', '', $addresses)) {
            return false;
        }

        $addressesArray = explode(";", $addresses);
        if (count($addressesArray) > 10) {
            return false;
        }

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            return false;
        }

        for ($i = 0; $i < count($addressesArray); $i++) {
            $check = $bitcoin -> validateaddress($addressesArray[$i]);
            if (!$addressesArray[$i] or !$check["isvalid"]) {
                return false;
            }
        }

        return $addressesArray;
    }

    function validateIncomingAddress($address) {
        global $_RPC_USER,
               $_RPC_PASSWORD;

        if (gettype($address) != "string" or $address === "" or strlen($address) > 74) {
            return false;
        }

        if ($address != preg_replace('/[^1234567890ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/', '', $address)) {
            return false;
        }

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            return false;
        }

        $check = $bitcoin -> validateaddress($address);
        if (!$check["isvalid"]) {
            return false;
        }

        return $address;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Delay validation \\
    function validateDelay($delays) {
        if (gettype($delays) != "string" or $delays === "" or strlen($delays) > 29) {
            return false;
        }

        if ($delays != preg_replace('/[^0123456789;]/', '', $delays)) {
            return false;
        }

        $delaysArray = explode(";", $delays);
        if (count($delaysArray) > 10) {
            return false;
        }

        for ($i = 0; $i < count($delaysArray); $i++) {
            if ($delaysArray[$i] === "") {
                return false;
            }
            $temp = intval($delaysArray[$i]);
            if ($temp > 48) {
                return false;
            }
            $delaysArray[$i] = strval($temp);
        }

        return $delaysArray;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Distribution validation \\
    function validateDistribution($distribution) {
        if (gettype($distribution) != "string" or $distribution === "" or strlen($distribution) > 29) {
            return false;
        }

        if ($distribution != preg_replace('/[^0123456789;]/', '', $distribution)) {
            return false;
        }

        $distributionArray = explode(";", $distribution);
        if (count($distributionArray) > 10) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < count($distributionArray); $i++) {
            if (!$distributionArray[$i]) {
                return false;
            }
            $temp = intval($distributionArray[$i]);
            if ($temp == 0) {
                return false;
            }
            $sum += $temp;
            $distributionArray[$i] = strval($temp);
        }

        if ($sum !== 100) {
            return false;
        }

        return $distributionArray;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Commission validation \\
    function validateCommission($commission, $minFee) {
        if (gettype($commission) != "string" or $commission === "" or strlen($commission) > 6) {
            return false;
        }

        if ($commission[0] == ".") {
            return false;
        }

        if ($commission != preg_replace('/[^0123456789.]/', '', $commission)) {
            return false;
        }

        if (count(explode('.', $commission)) > 2) {
            // check that commission string contains not more than one point
            return false;
        }

        if (floatval($commission) < $minFee or floatval($commission) > 3) {
            return false;
        }       

        return $commission;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Code validation \\
    function validateCode($code) {
        if (gettype($code) != "string" or $code === "" or strlen($code) != 6) {
            return false;
        }

        if ($code != preg_replace('/[^abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789]/', '', $code)) {
            return false;
        }
        
        return $code;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Miner rate validation \\
    function validateMinerRate($minerRate) {
        if (gettype($minerRate) != "string" or $minerRate === "" or strlen($minerRate) > 3) {
            return false;
        } 

        if ($minerRate != preg_replace('/[^0123456789]/', '', $minerRate)) {
            return false;
        }

        if (intval($minerRate) > 0) {
            return strval(intval($minerRate));
        } else {
            return false;
        }
    }
?>