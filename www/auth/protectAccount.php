<?php
	if (!isset($_POST["address"]) or !$_POST["address"]) {
		exit();
	}

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	require_once("../../php/mainLibrary.php");
	$signAddress = validateIncomingAddress($_POST["address"]);
	
	if (!$signAddress) {
		exit();
	}

	// only legacy address is possible
	if ($_TESTNET and $signAddress[0] != "m" and $signAddress[0] != "n") {
		exit();
    } elseif (!$_TESTNET and $signAddress[0] != "1") {
    	exit();
    }

	if ($state["data"]["twoFactorUI"] == "yes") {
		exit();
	}


	$result = protectAccount($state["data"]["login"], $signAddress);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>