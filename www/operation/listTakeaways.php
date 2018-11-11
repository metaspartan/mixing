<?php
	if (!isset($_POST["login"]) or !$_POST["login"] or gettype($_POST["login"]) != "string") {
		exit();
	}
	$loginSent = $_POST["login"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}
	$login = $state["data"]["login"];
	if ($login != $loginSent) {
		exit();
	}

	$result = listTakeaways($login);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>