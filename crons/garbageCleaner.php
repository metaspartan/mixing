<?php
	require_once(__DIR__."/../php/mainLibrary.php");
	garbageCleaner_unusedCodesAndAddresses();
	garbageCleaner_usedAddresses();
	require_once(__DIR__."/../php/authLibrary.php");
	cleanUserAddresses();
	cleanSessions();
?>