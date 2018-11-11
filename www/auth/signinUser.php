<?php
	if (!isset($_POST["login"]) or !$_POST["login"]) {
		exit();
	}
	if (!isset($_POST["password"]) or !$_POST["password"]) {
		exit();
	}
	if (!isset($_POST["remember"])) {
		exit();
	}
	if (!isset($_COOKIE["captcha"]) or !$_COOKIE["captcha"] or !isset($_POST["captcha"]) or !$_POST["captcha"]) {
		exit();
	}

	$loginOrMail = strtolower($_POST["login"]);	
	$password    = $_POST["password"];
	$remember    = $_POST["remember"];
	$captcha     = $_POST["captcha"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$check = validateCaptcha($captcha, "signin");
	if (!$check["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "captcha"));
		exit();
	}

	$check = validatePassword($password);
	if (!$check["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "wrongData"));
		exit();
	}

	$checkAsLogin = validateLogin($loginOrMail);
	$checkAsMail  = validateEmail($loginOrMail);

	if (!$checkAsLogin["isCorrect"] and !$checkAsMail["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "wrongData"));
		exit();
	}

	if ($checkAsLogin["isUsed"] !== true and $checkAsMail["isUsed"] !== true) {
		echo json_encode(array("success" => false, "reason" => "wrongData"));
		exit();
	}

	$remember = $remember == "0" ? false : true;
	
	$result = signinUser($loginOrMail, $password, $remember);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>