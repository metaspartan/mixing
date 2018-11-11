<?php 
	header("Content-Type:application/json");
	$apiUsage = 1;

	require_once("../../php/mainLibrary.php");	

	if (!isset($_GET["minerRate"])) {
		$minerRate = getMinerFeeRate();
	} else {
		$minerRate = validateMinerRate($_GET["minerRate"]);
		if (gettype($minerRate) == "boolean") {
			$minerRate = getMinerFeeRate();
		} 
	}

	$minCommission = 0.5;
	if (isset($_GET["code"])) {
		$code = validateCode($_GET["code"]);
		if (!$code) {
			$incorrectOrderResponse = array("success" => false,
											"error"   => "invalid code");
			echo json_encode($incorrectOrderResponse);
			exit();
		}
		$minCommission -= defineDiscount($code);
	}

	if (isset($_GET["commission"])) {
		$commission = validateCommission($_GET["commission"], $minCommission);
		if (!$commission) {
			$incorrectOrderResponse = array("success" => false,
											"error"   => "invalid commission");
			echo json_encode($incorrectOrderResponse);
			exit();
		}
		
	} else {
		$commission = rand(5000, 30000)/10000;
		$commission = number_format($commission, 4, '.', '');
	}

	if (!isset($_GET["address0"])) {
		$incorrectOrderResponse = array("success" => false,
									    "error"   => "address0 variable not specified");
		echo json_encode($incorrectOrderResponse);
		exit();
	}

	if (!isset($_GET["delay0"])) {
		$incorrectOrderResponse = array("success" => false,
									    "error"   => "delay0 variable not specified");
		echo json_encode($incorrectOrderResponse);
		exit();
	}

	for ($j = 0; $j < 10; $j++) {
		if (isset($_GET["address{$j}"]) and isset($_GET["delay{$j}"]) and isset($_GET["share{$j}"])) {
			$addresses    .= $_GET["address{$j}"].";";
			$delays       .= $_GET["delay{$j}"].";";
			$distribution .= $_GET["share{$j}"].";";
		} else {
			if ($j == 0) {
				$addresses    = $_GET["address0"].";";
				$delays       = $_GET["delay0"].";";
				$distribution = "100;";
				break 1;
			} else {
				break 1;
			}
		}
	}

	$addresses    = substr($addresses, 0, -1);
	$delays       = substr($delays, 0, -1);
	$distribution = substr($distribution, 0, -1);

	$ADDRESSES_ARRAY    = validateAddresses($addresses);
	$DELAY_ARRAY        = validateDelay($delays);
	$DISTRIBUTION_ARRAY = validateDistribution($distribution);

	if (!$ADDRESSES_ARRAY) {
		$incorrectOrderResponse = array("success" => false,
										"error"   => "invalid addresses setting");
		echo json_encode($incorrectOrderResponse);
		exit();
	}

	if (!$DELAY_ARRAY) {
		$incorrectOrderResponse = array("success" => false,
									 	"error"   => "invalid delay setting");
		echo json_encode($incorrectOrderResponse);
		exit();
	}

	if (!$DISTRIBUTION_ARRAY) {
		$incorrectOrderResponse = array("success" => false,
										"error"   => "invalid distribution setting");
		echo json_encode($incorrectOrderResponse);
		exit();
	}

	$request = array("outputAddresses" => $ADDRESSES_ARRAY,
			         "delay"           => $DELAY_ARRAY,
			         "distribution"    => $DISTRIBUTION_ARRAY,
			         "commission"      => $commission,
			         "minerRate"       => $minerRate);

	if (isset($code)) {
		$request["code"] = $code;
	}

	$rawResponse = makeOrder($request, 0 /*jsfree flag*/);

	if ($rawResponse["orderStatus"] == "somethingWrong") {
		$serverErrorResponse = array("success" => false,
                                     "error"   => "internal server error");
		echo json_encode($serverErrorResponse);
		exit();
	}

	if ($rawResponse["orderStatus"] == "noAvailableCoins") {
		$emptyReserveResponse = array("success" => false,
 							          "error"   => "reserve is empty for this code");
		echo json_encode($emptyReserveResponse);
		exit();
	}

	if ($rawResponse["orderStatus"] == "tooHighMinIncome") {
		$finalResponse = array("success" => false,
			                   "error"   => "high minimum income",
	                           "result"  => array("minInputAmount" => $rawResponse["minimumIncome"],
	                                              "maxInputAmount" => $rawResponse["balance"]));
		echo json_encode($finalResponse);
		exit();
	}

	if ($rawResponse["orderStatus"] == "OK") {
		$finalResponse = array("success" => true,
			                   "error"   => "",
				               "result"  => array("minInputAmount" => $rawResponse["minimumIncome"],
				                                  "maxInputAmount" => $rawResponse["balance"],
				                                  "inputAddress"   => $rawResponse["newAddress"],
				                                  "code"           => $rawResponse["code"],
				                                  "letter"         => $rawResponse["letter"],
				                                  "commission"     => $commission*1,
				                                  "minerRate"      => $minerRate*1));
		echo json_encode($finalResponse);
		exit();
	}

	echo json_encode($serverErrorResponse);
?>