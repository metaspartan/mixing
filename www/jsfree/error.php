<?php
	session_name("jsf");
	session_set_cookie_params(1, "/jsfree");
	session_start();
	if (!isset($_SESSION["isRedirected"]) or $_SESSION["isRedirected"] != "yes") {
		echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/default.html");
		session_destroy();
		exit();
	}

	if ($_SESSION["origin"] == "order") {
		$status = $_SESSION["orderStatus"];
		if ($status == "somethingWrong") {
			echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/errors/error_order_somethingWrong.html");
			session_destroy();
			exit();
		}

		if ($status == "noAvailableCoins") {
			echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/errors/error_order_noAvailableCoins.html");
			session_destroy();
			exit();
		}

		if ($status == "wrongRequest") {
			$outputsNumber = $_SESSION["outputsNumber"];
			include(__DIR__."/../../html/contents/jsfree/handling/errors/error_order_wrongRequest.php");
			session_destroy();
			exit();
		}

		$minimum = $_SESSION["minimum"];
		$maximum = $_SESSION["maximum"];

		if ($status == "tooHighMinIncome") {
			include(__DIR__."/../../html/contents/jsfree/handling/errors/error_order_tooHighMinIncome.php");
			session_destroy();
			exit();
		}
	}

	if ($_SESSION["origin"] == "status") {
		$status = $_SESSION["status"];
		if ($status == "wrongRequest") {
			echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/errors/error_status_wrongRequest.html");
			session_destroy();
			exit();
		}

		if ($status == "error") {
			echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/errors/error_status_internalError.html");
			session_destroy();
			exit();
		}
	}
?>