<?php
	if (!isset($_COOKIE["captcha"]) or !$_COOKIE["captcha"] or !isset($_POST["referer"]) or !isset($_POST["captcha"])) {
		exit();
	}
	$admissibleURIs = array("signin", "signup", "restore");
	if (!in_array($_POST["referer"], $admissibleURIs)) {
        exit();
    }
	require_once("../../php/authLibrary.php");
	echo json_encode(validateCaptcha($_POST["captcha"], $_POST["referer"]));
?>