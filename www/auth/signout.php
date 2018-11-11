<?php
	if (!isset($_COOKIE["auth"]) or !$_COOKIE["auth"]) {
		header("Location: /");
		exit();
	}
	require_once("../../php/authLibrary.php");
	destroyAuthSession($_COOKIE["auth"]);
	if ($referer = $_SERVER['HTTP_REFERER']) {
		$structure = frontendStructure();
		$referer = explode("bitwhisk.io", $referer)[1];
		if ((isset($structure["dynamic"][$referer]) and min($structure["dynamic"][$referer]["show"]) > 0) or !isset($structure["dynamic"][$referer])) {
			$referer = "/";
		}
	} else {
		$referer = "/";
	}
	header("Location: {$referer}");
?>