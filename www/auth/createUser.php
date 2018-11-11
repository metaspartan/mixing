<?php
	if (!isset($_POST["login"]) or !$_POST["login"]) {
		exit();
	}
	if (!isset($_POST["password"]) or !$_POST["password"]) {
		exit();
	}	
	if (!isset($_POST["email"]) or !$_POST["email"]) {
		exit();
	}
	if (!isset($_COOKIE["captcha"]) or !$_COOKIE["captcha"] or !isset($_POST["captcha"]) or !$_POST["captcha"]) {
		exit();
	}

	$login    = strtolower($_POST["login"]);
	$email    = strtolower($_POST["email"]);
	$password = $_POST["password"];
	$captcha  = $_POST["captcha"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$check = validateLogin($login);
	if (!$check["isCorrect"]) {
		exit();
	}
	if ($check["isUsed"]) {
		echo json_encode(array("success" => false, "reason" => "loginUsed"));
		exit();
	}

	$check = validateEmail($email);
	if (!$check["isCorrect"]) {
		exit();
	}
	if ($check["isUsed"]) {
		echo json_encode(array("success" => false, "reason" => "emailUsed"));
		exit();
	}

	$check = validatePassword($password);
	if (!$check["isCorrect"]) {
		exit();
	}
	
	$check = validateCaptcha($captcha, "signup");
	if (!$check["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "captcha"));
		exit();
	}

	$result = createUser($login, $email, $password);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>