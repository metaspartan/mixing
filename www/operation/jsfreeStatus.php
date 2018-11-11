<?php 
	require_once("../../php/mainLibrary.php");

	if (!isset($_POST["code"]) or !isset($_POST["incomingAddress"])) {
		echo ""; //"Unknown order format";
	}

	$code = validateCode($_POST["code"]);
	$incomingAddress = validateIncomingAddress(trim($_POST["incomingAddress"], " "));

	if ($code and $incomingAddress) {
		$response = checkStatus($incomingAddress, $code);

		session_name("jsf");
		if ($response["status"] == "error") {
			session_set_cookie_params(1, "/jsfree/error");
			session_start();
			$_SESSION["isRedirected"] = "yes";
			$_SESSION["origin"] = "status";
			$_SESSION["status"] = "error";
			header("Location: /jsfree/error");
			exit();
		}

		session_set_cookie_params(1, "/jsfree/status");
		session_start();
		$_SESSION["isRedirected"] = "yes";
		$_SESSION["origin"] = "status";

		if ($response["status"] == "no order") {
			$_SESSION["status"] = "noOrder";
			header("Location: /jsfree/status");
			exit();
		}

		$_SESSION["minimum"] = number_format($response["minIncome"], 8, '.', '');
		$_SESSION["maximum"] = number_format($response["maxIncome"], 8, '.', '');
		$_SESSION["activeUntil"] = $response["activeUntil"];

		if ($response["status"] == "empty order") {
			$_SESSION["status"] = "emptyOrder";
			header("Location: /jsfree/status");
			exit();
		}

		$_SESSION["status"] = "fullOrder";
		$_SESSION["unconfirmedAmount"] = $response["waitingInfo"][0] > 0 ? number_format($response["waitingInfo"][0], 8, '.', '') : "0";
		$_SESSION["confirmedAmount"] = $response["waitingInfo"][1] > 0 ? number_format($response["waitingInfo"][1], 8, '.', '') : "0";
		$_SESSION["receivedAmount"] = $response["receivedAmount"] > 0 ?  number_format($response["receivedAmount"], 8, '.', '') : "0";

		if ($response["maxIncome"] > 0) {
			$_SESSION["max_ok_display"]     = "block";
			$_SESSION["max_not_ok_display"] = "none";
		} else {
			$_SESSION["max_ok_display"]     = "none";
			$_SESSION["max_not_ok_display"] = "block";
		}

		if ($response["anyErrors"] == "yes") {
			$_SESSION["block1"] = "block";
			$_SESSION["block2"] = "none";
			$_SESSION["block3"] = "none";
			$_SESSION["block4"] = "none";
		} else {
			if ($response["addressActive"] == "true") {
				$_SESSION["block1"] = "none";
				$_SESSION["block2"] = "block";
				$_SESSION["block3"] = "none";
				$_SESSION["block4"] = "none";
			} else {
				if ($response["pendingOrders"] == "yes") {
					$_SESSION["block1"] = "none";
					$_SESSION["block2"] = "none";
					$_SESSION["block3"] = "block";
					$_SESSION["block4"] = "none";
				} else {
					$_SESSION["block1"] = "none";
					$_SESSION["block2"] = "none";
					$_SESSION["block3"] = "none";
					$_SESSION["block4"] = "block";
				}
			}
		}

		$_SESSION["minerRate"] = $response["minerRate"];
    	$_SESSION["summaryNeeded"] = $response["summaryNeeded"];
    	$_SESSION["outputsNumber"] = $response["outputsNumber"];
    	$_SESSION["info"] = $response["info"];
    	$_SESSION["notAssigned"] = $response["notAssigned"];
    	$_SESSION["unhandledAmount"] = $response["unhandledAmount"];
    	header("Location: /jsfree/status");
	} else {
		session_name("jsf");
		session_set_cookie_params(1, "/jsfree/error");
		session_start();
		$_SESSION["isRedirected"] = "yes";
		$_SESSION["origin"] = "status";
		$_SESSION["status"] = "wrongRequest";
    	header("Location: /jsfree/error");
	}
?>