<!DOCTYPE html>
<html lang="en">
<head>
	<title>BitWhisk &#x2014 Letter of Guarantee</title>
	<meta charset="utf-8"/>
	<meta name = "viewport" content="width=device-width, initial-scale=1">
	<link rel = "icon"       type = "image/x-icon" href = "/images/whisk_icon.ico">
</head>
<body>
<?php
	$HTML = $_POST["letter"];
	$str = "-----START SIGNING BITCOIN ADDRESS-----";		
	$HTML = substr_replace($HTML, "<br>", strpos($HTML, $str) + strlen($str), 0);

	$str = "-----END SIGNING BITCOIN ADDRESS-----";		
	$HTML = substr_replace($HTML, "<br>", strpos($HTML, $str), 0);

	$str = "-----END SIGNING BITCOIN ADDRESS-----";		
	$HTML = substr_replace($HTML, "<br><br>", strpos($HTML, $str) + strlen($str), 0);

	$str = "-----START LETTER OF GUARANTEE-----";
	$HTML = substr_replace($HTML, "<br>", strpos($HTML, $str) + strlen($str), 0);

	$str = "-----END LETTER OF GUARANTEE-----";
	$HTML = substr_replace($HTML, "<br>", strpos($HTML, $str), 0);

	$str = "-----END LETTER OF GUARANTEE-----";
	$HTML = substr_replace($HTML, "<br><br>", strpos($HTML, $str) + strlen($str), 0);

	$str = "-----START DIGITAL SIGNATURE-----";
	$HTML = substr_replace($HTML, "<br>", strpos($HTML, $str) + strlen($str), 0);
	
	$str = "-----END DIGITAL SIGNATURE-----";
	$HTML = substr_replace($HTML, "<br>", strpos($HTML, $str), 0);

	echo $HTML;?>
</body>
</html>