<?php
	if (!isset($_POST["amount"]) or !$_POST["amount"] or gettype($_POST["amount"]) != "string") {
		exit();
	}
	if (!isset($_POST["commission"]) or !$_POST["commission"] or gettype($_POST["commission"]) != "string") {
		exit();
	}
	$amount = floatval($_POST["amount"]);
	$commission = $_POST["commission"];

	require_once("../../php/authLibrary.php");
	$state = getPermissionAndSessionData(__FILE__);
	if (!$state["permission"]) {
		echo json_encode(array("success" => false, "reason" => "permissions"));
		exit();
	}
	$login = $state["data"]["login"];
	$code = $state["data"]["code"];
	$balance = $state["data"]["depBalance"];

	if ($balance <= 0) {
		exit();
	}

	require_once("../../php/mainLibrary.php");
	$minCommission = 0.5 - defineDiscount($code);
	$commission = validateCommission($commission, $minCommission);
	if (!$commission) {
		exit();
	}

	$maxInfo = defineUserMaximum($code);
	if (!$maxInfo["success"]) {
		echo json_encode(array("success" => false, "reason" => "internal"));
		exit();
	}

	if ($amount <= 0) {
		exit();
	}

	if ($amount > $maxInfo["result"]) {
		echo json_encode(array("success" => false, "reason" => "maximumChanged", "maximum" => $maxInfo["result"]));
		exit();
	}

	$minerRate = getMinerFeeRate();
	$result = prepareTakeaway($login, $code, $amount, $commission, $balance, $minerRate);
	echo json_encode($result["echo"]);
	if (isset($result["log"])) {
		file_put_contents($_LOG_FILE_TAKEAWAYS, $result["log"].PHP_EOL, FILE_APPEND);
	}
?>