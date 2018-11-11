<?php
	$URI = $_SERVER["REQUEST_URI"];
	$trimmedURI = preg_replace('/(\/+)/','/', $URI);
	if ($trimmedURI != "/") {
		$trimmedURI = strtolower(rtrim($trimmedURI, "/"));
	}
	if ($URI != $trimmedURI) {
		header("Location: https://bitwhisk.io{$trimmedURI}");
		exit();
	}

	require_once("../php/authLibrary.php");
	$id = isOrderRequest($URI);
	if (!$id) {
		echoHTML($URI);
	} else {
		echoOrderHTML($id);
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