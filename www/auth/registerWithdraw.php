<?php
	if (!isset($_POST["address"]) or !$_POST["address"]) {
		exit();
	}
	if (!isset($_POST["amount"]) or !$_POST["amount"]) {
		exit();
	}
	if (!isset($_POST["password"]) or !$_POST["password"]) {
		exit();
	}

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$password = $_POST["password"];
	$check = validatePassword($password);
	if (!$check["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "password"));
		exit();
	}

	$amount = round(floatval($_POST["amount"]), 8);
	if ($amount <= 0 or $amount > $state["data"]["invBalance"]) {
		exit();
	}

	require_once("../../php/mainLibrary.php");
	$address = validateIncomingAddress($_POST["address"]);
	if (!$address) {
		exit();
	}

	$result = registerWithdraw($state["data"]["login"], $password, $amount, $address);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>