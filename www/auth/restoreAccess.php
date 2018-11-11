<?php
	if (!isset($_POST["rcode"]) or !$_POST["rcode"]) {
		exit();
	}
	if (!isset($_POST["password"]) or !$_POST["password"]) {
		exit();
	}
	if (!isset($_COOKIE["captcha"]) or !$_COOKIE["captcha"] or !isset($_POST["captcha"]) or !$_POST["captcha"]) {
		exit();
	}
	$rcode    = $_POST["rcode"];
	$password = $_POST["password"];
	$captcha  = $_POST["captcha"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	if (!validateRcode($rcode)) {
		echo json_encode(array("success" => false, "reason" => "invalidRestoreCode"));
		exit();
	}

	$check = validatePassword($password);
	if (!$check["isCorrect"]) {
		// валидируем пароль на интерфейсе, нет смысла отвечать
		exit();
	}

	$check = validateCaptcha($captcha, "restore");
	if (!$check["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "captcha"));
		exit();
	}

	$result = restoreAccess($rcode, $password);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>