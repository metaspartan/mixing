<?php
	$balance = $session["data"]["depBalance"];
	$address = $session["data"]["depAddress"];
?>
<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>
		    	Account deposit
		    </p>
		    <p>
		    	Your current account balance is <?php echo numberFormat($balance, 8);?> BTC. 
		    	Below is the address accepting payments:
		    </p>
		    <div class = "deposit-address"> 
		        <div class = "list-incoming">
		        	<li class = "el-list-incoming">
		        		<span class="generated-address unclickable-address">
		        			<?php echo $address;?>
		        		</span>
		        	</li>
		        	<button class = "add-incoming-address" style = "margin-top: 10px; margin-bottom: -10px">Letter of Guarantee</button>
		        </div>
		    </div>
		    <div class = "qr-codes">
		        <img class = "qr-img" src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=<?php echo $address;?>">
		    </div>
		    <p>
		    	Please note, this address is one-off.
		    	Once your incoming transaction gets two confirmations, your 
		    	balance is updated and the new deposit address is released.
		    </p>
		    <p class = "text-center">
		    	Read <a class = "faq-href" href = "/faq#account-deposit">FAQ</a> 
		    	on why we accept deposits.
		    </p>
		</div>
		<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>

	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
<script src="/scripts/profile/deposit/header.js"></script>
<script src="/scripts/profile/deposit/windowResize.js"></script>
<script src="/scripts/profile/deposit/letter.js"></script>

</body>
</html>