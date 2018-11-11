<?php
	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		exit();
	}

	$invAddress = $state["data"]["invAddress"];
	$invStamp = $state["data"]["invStamp"];
	$login = $state["data"]["login"];

	$letter = generateInvLetter($login, $invAddress, $invStamp);
	if ($letter !== false) {
		header('Content-Disposition: attachment; filename="Investment Letter of Guarantee.txt"');
		header('Content-Type: text/plain');
		header('Content-Length: '.strlen($letter));
		header('Connection: close');
		echo $letter;
	} else {
		$letter  = "An error occured while generating a Letter of Guarantee for your investment address.\r\n";
		$letter .= "We would be thankful if you notify us about this incident via contact@bitwhisk.io";
		header('Content-Disposition: attachment; filename="Error.txt"');
		header('Content-Type: text/plain');
		header('Content-Length: '.strlen($letter));
		header('Connection: close');
		echo $letter;
	}
?>