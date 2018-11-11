<?php
	session_name("jsf");
	session_set_cookie_params(1, "/jsfree/order");
	session_start();
	if (!isset($_SESSION["isRedirected"]) or $_SESSION["isRedirected"] != "yes") {
		echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/default.html");
		session_destroy();
		exit();
	}

	require_once(__DIR__."/../../php/authLibrary.php");
	$session = getAuthSession();
	$status = $session["status"];
	if ($status == -2) {
		echo file_get_contents(__DIR__."/../html/errors/auth_error.html");
        file_put_contents($_LOG_FILE_AUTH, $session["error"].PHP_EOL, FILE_APPEND);
        exit();
    }

	$structure = frontendStructure();
	
	$newAddress = $_SESSION["newAddress"];
	$minimum = $_SESSION["minimum"];
	$maximum = $_SESSION["maximum"];
	$letter = $_SESSION["letter"];
	$code = $_SESSION["code"];

	include(__DIR__."/../../html/contents/jsfree/handling/order_done.php");
	session_destroy();
?>