<?php
	if (!isset($_COOKIE["auth"]) or !$_COOKIE["auth"]) {
		header("Location: /");
		exit();
	}
	require_once("../../php/authLibrary.php");
	totalDestroyAuthSession($_COOKIE["auth"]);
	header("Location: /");
?>