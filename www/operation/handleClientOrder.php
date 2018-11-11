<?php 
	require_once("../../php/mainLibrary.php");

	if (!isset($jsfree)) {
		$jsfree = 0;
	}

	if (!isset($_POST["outputAddresses"]) or !isset($_POST["delay"]) or !isset($_POST["distribution"]) or !isset($_POST["commission"]) or !isset($_POST["minerRate"])) {
		echo "";
		exit();
	}
	
	$distributionArray = validateDistribution($_POST["distribution"]);
	$addressesArray    = validateAddresses($_POST["outputAddresses"]);
	$delaysArray       = validateDelay($_POST["delay"]);
	$minerRate         = validateMinerRate($_POST["minerRate"]);
	if (!$minerRate) {
		$minerRate = getMinerFeeRate();
	}

	$response = "Incorrect order";
	if (!$addressesArray or !$delaysArray or !$distributionArray) {
		finalEcho($response);
		exit();
	}

	if (count($addressesArray) != count($delaysArray) or count($addressesArray) != count($distributionArray)) {
		finalEcho($response);
		exit();
	}

	if (!isset($_POST["code"])) {
		$minCommission = 0.5;
	} else {
		$code = validateCode($_POST["code"]);
		if (!$code) {
			finalEcho($response);
			exit();
		}
		$discount = defineDiscount($code);
		$minCommission = 0.5 - $discount;
	}

	$commission = validateCommission($_POST["commission"], $minCommission);
	if (!$commission) {
		finalEcho($response);
		exit();
	}

	$request = array("outputAddresses" => $addressesArray,
					 "distribution"    => $distributionArray,
					 "commission"      => $commission,
					 "minerRate"       => $minerRate,
					 "delay"           => $delaysArray);
	if (isset($code)) {
		$request["code"] = $code;
	}
	$response =	makeOrder($request, $jsfree);
	finalEcho($response);

	function finalEcho($response) {
		global 	$jsfree, 
		 		$outputsNumber;
		
		if (gettype($response) == "array") {
			if ($jsfree) {
				session_name("jsf");
				session_set_cookie_params(1, "/jsfree/order");
				session_start(); 
				$_SESSION["isRedirected"] = "yes";
				$_SESSION["origin"] = "order";
				$_SESSION["orderStatus"] = $response["orderStatus"];
				if ($response["orderStatus"] == "noAvailableCoins" or $response["orderStatus"] == "somethingWrong") {
					header("Location: /jsfree/error");
					return;
				}
				$_SESSION["minimum"] = number_format($response["minimumIncome"], 8, '.', '');
				$_SESSION["maximum"] = number_format($response["balance"], 8, '.', '');
				if ($response["orderStatus"] == "tooHighMinIncome") {
					header("Location: /jsfree/error");
					return;
				}
				$_SESSION["letter"] = $response["letter"];
				$_SESSION["newAddress"] = $response["newAddress"];
				$_SESSION["code"] = $response["code"];
				header("Location: /jsfree/order");
			} else {
				echo json_encode($response);
			}
		} else {
			if ($jsfree) {
				session_name("jsf");
				session_set_cookie_params(1, "/jsfree/error");
				session_start(); 
				$_SESSION["isRedirected"]  = "yes";
				$_SESSION["origin"]		   = "order";
				$_SESSION["orderStatus"]   = "wrongRequest";
				$_SESSION["outputsNumber"] = $outputsNumber;
				header("Location: /jsfree/error");
			} else {
				echo $response;
			}
		}
	}
?>