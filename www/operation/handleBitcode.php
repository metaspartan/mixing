<?php 
	require_once("../../php/mainLibrary.php");

	if (!isset($_POST["code"])) {
		echo ""; //"Unknown order format";
	}

	$code = validateCode($_POST["code"]);
	if (!$code) {
		echo "wrong code";
	}

	$discount = defineDiscount($code);
    echo $discount;
?>