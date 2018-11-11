<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "donation-content" style = "margin-top: 40px">
	        <a class = "donation-please">Want to support us? Direct your donations to:</a>
	        <div style = "margin-top: 5px;">
	            <a href = "https://blockchain.info/address/1BWhisku6FmdcWk776vrqb2KHs88r5oicp" class = "donation-address">1BWhisku6FmdcWk776vrqb2KHs88r5oicp</a>
	        </div>        
	        <div style = "margin-top: 25px;">
	            <img class = "donation-picture" src = "/images/donation.svg">
	        </div>
	        <div style = "margin-top: 15px;">
	            <a class = "donation-thank-you">Thank you for using BitWhisk</a>
	        </div>            
	    </div>
	</div>
	<script>
	document.querySelector(".donation-content").style.visibility = "hidden";
	</script>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/donation/header.js"></script>
<script src="/scripts/donation/windowResize.js"></script>
</body>
</html>