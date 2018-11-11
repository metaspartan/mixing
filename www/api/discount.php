<?php
	header("Content-Type:application/json");
	require_once("../../php/mainLibrary.php");

	if (!isset($_GET["code"])) {
		echo json_encode(array("success" => false,
	                           "error"   => "code not specified"));
	}

	$code = validateCode($_GET["code"]);

	if (!$code) {
		echo json_encode(array("success" => false,
                               "error"   => "invalid code"));
	}

	$discount = defineDiscount($code);
    echo json_encode(array("success" => true,
    		               "error"   => "",
                           "result"  => array("discount"             => $discount,
                                              "minServiceCommission" => 0.5-$discount)));

?>