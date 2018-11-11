<?php
	require_once(__DIR__."/../php/mainLibrary.php");
	controlOpenOrders();
	controlProcessingOrders();
	garbageCleaner_completedOrders();
?>