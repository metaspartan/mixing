<?php
	if (!isset($_POST["codeword"]) or $_POST["codeword"] != "kokoko") {
		exit();
	}

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$referer = explode("bitwhisk.io", $_SERVER["HTTP_REFERER"])[1];
	$ID = isOrderRequest($referer);
	if (!$ID) {
		exit();
	}
	$login = $state["data"]["login"];

	$result = deleteTakeaway($login, $ID);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_TAKEAWAYS, $result["log"].PHP_EOL, FILE_APPEND);
	}
	
	function isOrderRequest($uri) {
		$arr = explode("/", $uri);
		if (count($arr) != 3 or $arr[1] != "mixing" or strlen($arr[2]) != 64) {
			return false;
		}
		$trimmedID = preg_replace('/[^a-f0-9]/', '', $arr[2]);
		if ($trimmedID != $arr[2]) {
			return false;
		}
		return $arr[2];
	}
?>