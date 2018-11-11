<?php
	if (!isset($_POST["login"]) or !$_POST["login"]) {
		exit();
	}
	if (!isset($_COOKIE["captcha"]) or !$_COOKIE["captcha"] or !isset($_POST["captcha"]) or !$_POST["captcha"]) {
		exit();
	}
	$loginOrMail = strtolower($_POST["login"]);	
	$captcha 	 = $_POST["captcha"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}
	$checkAsLogin = validateLogin($loginOrMail);
	$checkAsMail  = validateEmail($loginOrMail);

	if (!$checkAsLogin["isCorrect"] and !$checkAsMail["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "invalidCredentials"));
		exit();
	}

	if ($checkAsLogin["isUsed"] !== true and $checkAsMail["isUsed"] !== true) {
		echo json_encode(array("success" => false, "reason" => "invalidCredentials"));
		exit();
	}
	
	$check = validateCaptcha($captcha, "restore");
	if (!$check["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "captcha"));
		exit();
	}

	$result = setRestoreCode($loginOrMail);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>