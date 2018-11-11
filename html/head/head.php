<?php
	if ($userOrderPage) {
		$title = $structure["userOrderPage"]["title"][$orderStatus];
	} else {
		$title = $structure["dynamic"][$uri]["title"];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>BitWhisk &#x2014 <?php echo $title;?></title>
    <meta charset="utf-8" />
    <meta name = "viewport"  content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" type = "text/css"  href = "/style/style.css">
    <link rel = "icon"       type = "image/x-icon" href = "/images/whisk_icon.ico">       
</head>