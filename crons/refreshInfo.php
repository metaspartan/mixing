<?php
	require_once(__DIR__."/../php/mainLibrary.php");
	$options = array(CURLOPT_RETURNTRANSFER => true, 
	                 CURLOPT_HEADER         => false); 

	$ch = curl_init("https://bitcoinfees.earn.com/api/v1/fees/recommended");
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);  
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($http_code === 200) {
	    refreshMinerFeeRate(json_decode($content)->fastestFee);
	}
	$ch = curl_init("https://api.coinmarketcap.com/v1/ticker/bitcoin/");
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);  
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($http_code === 200) {
		$info = json_decode($content);
	    refreshExchangePrice(floatval($info[0]->price_usd));
	}
?>