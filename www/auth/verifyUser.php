<?php
	if (!isset($_POST["vcode"]) or !$_POST["vcode"]) {
		exit();
	}
	$vcode = $_POST["vcode"];	

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	require_once("../../php/mainLibrary.php");
	$bcode = null;
	if (isset($_POST["bcode"])) {
		$bcode = validateCode($_POST["bcode"]);
	}

	if ($bcode === false) {
		echo json_encode(array("success" => false, "reason" => "wrongBCode"));
		exit();
	}

	if (!validateVerificationCode($vcode)) {
		echo json_encode(array("success" => false, "reason" => "wrongVCode"));
		exit();
	}

	$result = verifyUser($state["data"]["login"], $vcode, $bcode);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>