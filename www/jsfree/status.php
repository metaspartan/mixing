<?php
	session_name("jsf");
	session_set_cookie_params(1, "/jsfree/status");
	session_start();
	if (!isset($_SESSION["isRedirected"]) or $_SESSION["isRedirected"] != "yes") {
		echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/default.html");
		session_destroy();
		exit();
	}

	if ($_SESSION["status"] == "noOrder") {
		echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/status_no_order.html");
		session_destroy();
		exit();
	}

	$minimum = $_SESSION["minimum"];
	$maximum = $_SESSION["maximum"];
	$activeUntil = $_SESSION["activeUntil"];

	if ($_SESSION["status"] == "emptyOrder") {
		include(__DIR__."/../../html/contents/jsfree/handling/status_empty_order.php");
		session_destroy();
		exit();
	}

	if ($_SESSION["status"] != "fullOrder") {
		session_destroy();
		exit();
	}

	$unconfirmedAmount = $_SESSION["unconfirmedAmount"];
	$confirmedAmount = $_SESSION["confirmedAmount"];
	$receivedAmount = $_SESSION["receivedAmount"];
	$max_ok_display = $_SESSION["max_ok_display"];
	$max_not_ok_display = $_SESSION["max_not_ok_display"];
	$block1 = $_SESSION["block1"];
	$block2 = $_SESSION["block2"];
	$block3 = $_SESSION["block3"];
	$block4 = $_SESSION["block4"];
	$minerRate = $_SESSION["minerRate"];
	$summaryNeeded = $_SESSION["summaryNeeded"];
	$outputsNumber = $_SESSION["outputsNumber"];
	$info = $_SESSION["info"];
	$notAssigned = $_SESSION["notAssigned"];
	$unhandledAmount = $_SESSION["unhandledAmount"];

	include(__DIR__."/../../html/contents/jsfree/handling/status_full_order.php");
	session_destroy();
?>