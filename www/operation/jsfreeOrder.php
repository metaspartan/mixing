<?php
	require_once("../../php/mainLibrary.php");

	if (!isset($_POST["outputsNumber"])) {
		echo "";
		exit();
	}

	$outputsNumber = intval($_POST["outputsNumber"]);
	if ($outputsNumber <= 0 or $outputsNumber > 10) {
		echo "";
		exit();
	}

	$outputAddresses = "";
	$delay = "";
	$distribution = "";

	for ($i = 0; $i < $outputsNumber; $i++) {
		if (!isset($_POST["address{$i}"]) or !isset($_POST["delay{$i}"]) or !isset($_POST["share{$i}"])) {
			echo "";
			exit();
		}
		if ($i == $outputsNumber-1) {
			$outputAddresses .= smartStrToLowerCase(trim($_POST["address{$i}"], " "));
			$delay           .= trim($_POST["delay{$i}"], " ");
			$distribution    .= trim($_POST["share{$i}"], " ");
		} else {
			$outputAddresses .= smartStrToLowerCase(trim($_POST["address{$i}"], " ")).";";
			$delay           .= trim($_POST["delay{$i}"], " ").";";
			$distribution    .= trim($_POST["share{$i}"], " ").";";
		}
	}

	$_POST["outputAddresses"] = $outputAddresses;
	$_POST["delay"]           = $delay;
	$_POST["distribution"]    = $distribution;

	if (!isset($_POST["code"])) {
		echo "";
		exit();
	}

	if ($_POST["code"] == "") {
		unset($_POST["code"]);
	}

	if (!isset($_POST["commission"]) or !isset($_POST["minerRate"])) {
		echo "";
		exit();
	}

	$_POST["commission"] = trim($_POST["commission"], " ");
	$_POST["minerRate"]  = trim($_POST["minerRate"], " ");
	$jsfree = 1;
	include("handleClientOrder.php");

	function smartStrToLowerCase($address) {
		global $_TESTNET;
		if ($_TESTNET) {
			if ($address[0] == "m" or $address[0] == "n" or $address[0] == "2") {
				return $address;
			} else {
				return strtolower($address);
			}
		} else {
			if ($address[0] == "1" or $address[0] == "3") {
				return $address;
			} else {
				return strtolower($address);
			}
		}
	}
?>