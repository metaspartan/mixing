<?php
	if (!isset($_POST["sdate"]) or !$_POST["sdate"]) {
		exit();
	}
	if (!isset($_POST["edate"]) or !$_POST["edate"]) {
		exit();
	}

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}

	$sdate = validateDate($_POST["sdate"]);
	$edate = validateDate($_POST["edate"]);

	if (!$sdate or !$edate) {
		exit();
	}

	$stime = mktime(0, 0, 0, $sdate[1], $sdate[0], $sdate[2]);
	$etime = mktime(0, 0, 0, $edate[1], $edate[0], $edate[2]);
	$etime = ($etime == $stime) ? mktime(23, 59, 59, $edate[1], $edate[0], $edate[2]) : $etime;

	$result = selectStatistics($state["data"]["login"], $stime, $etime);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_AUTH, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>