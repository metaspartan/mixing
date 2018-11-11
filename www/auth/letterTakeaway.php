<?php
	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		exit();
	}

	$referer = explode("bitwhisk.io", $_SERVER["HTTP_REFERER"])[1];
	$ID = isOrderRequest($referer);
	if (!$ID) {
		exit();
	}
	$login = $state["data"]["login"];

	$letter = generateTakeawayLetter($login, $ID);
	if ($letter !== false) {
		header('Content-Disposition: attachment; filename="Stash Letter of Guarantee.txt"');
		header('Content-Type: text/plain');
		header('Content-Length: '.strlen($letter));
		header('Connection: close');
		echo $letter;
	} else {
		$letter  = "An error occured while generating a Letter of Guarantee for your mixing order.\r\n";
		$letter .= "We would be thankful if you notify us about this incident via contact@bitwhisk.io";
		header('Content-Disposition: attachment; filename="Error.txt"');
		header('Content-Type: text/plain');
		header('Content-Length: '.strlen($letter));
		header('Connection: close');
		echo $letter;
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