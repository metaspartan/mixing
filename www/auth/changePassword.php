<?php
	if (!isset($_POST["oldPasswd"]) or !$_POST["oldPasswd"]) {
		exit();
	}
	if (!isset($_POST["newPasswd"]) or !$_POST["newPasswd"]) {
		exit();
	}

	$oldPasswd = $_POST["oldPasswd"];
	$newPasswd = $_POST["newPasswd"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$checkOld = validatePassword($oldPasswd);
	$checkNew = validatePassword($newPasswd);

	if (!$checkNew["isCorrect"]) {
		exit();
	}

	if (!$checkOld["isCorrect"]) {
		echo json_encode(array("success" => false, "reason" => "wrongOldPassword"));
		exit();
	}

	$result = changePassword($state["data"]["login"], $oldPasswd, $newPasswd);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>