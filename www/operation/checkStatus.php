<?php 
	require_once("../../php/mainLibrary.php");

	if (!isset($_POST["code"]) or !isset($_POST["incomingAddress"])) {
		echo ""; //"Unknown order format";
	}
	
	$code = validateCode($_POST["code"]);
	$address = validateIncomingAddress($_POST["incomingAddress"]);
	if (!$code or !$address) {
		echo "wrong data";	
	}

	echo json_encode(checkStatus($address, $code));
?>