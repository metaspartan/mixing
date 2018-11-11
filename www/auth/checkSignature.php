<?php
	if (!isset($_POST["signature"]) or !$_POST["signature"]) {
		exit();
	}

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$signAddress = $state["data"]["signAddress"];
	$checkString = $state["data"]["checkString"];

	$result = checkSignature($state["data"]["login"], $signAddress, $_POST["signature"], $checkString);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>