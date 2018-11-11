<?php 
	require_once("../../php/mainLibrary.php");

	if (!isset($_POST["codeword"]) or $_POST["codeword"] !== "sayhi") {
		echo ""; //"Unknown order format";
	}
	
   	echo json_encode(array("minerRate" => getMinerFeeRate(), "exchangeRate" => getExchangePrice()));
?>