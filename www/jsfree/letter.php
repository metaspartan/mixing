<?php
	if (isset($_POST["letter"])) {
		include(__DIR__."/../../html/contents/jsfree/handling/letter.php");
	} else {
		echo file_get_contents(__DIR__."/../../html/contents/jsfree/handling/default.html");
	}
?>