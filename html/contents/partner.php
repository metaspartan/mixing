<?php
	$status = $session["status"];
	if ($status == 3) {
		global 	$_SERVERNAME,
				$_USERS_USERNAME,
				$_USERS_PASSWORD,
				$_DB_USERS,
				$_DB_USERS_TABLE_ACCOUNTS,
				$_OUR_CAPITAL;

		$balance = $session["data"]["invBalance"];
		$address = $session["data"]["invAddress"];

		$connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
	    $result = mysqli_query($connUsers, "SELECT sum(inv_balance) AS total FROM {$_DB_USERS_TABLE_ACCOUNTS}");
	    $total = mysqli_fetch_assoc($result)["total"] + $_OUR_CAPITAL;
	    if ($balance > 0) {
	    	$share = 0.7*$balance/$total;
	    	$shareText = ($share < 0.01) ? "less than 1" : numberFormat($share*100, 2);
	    }
	}
	include($structure["static"]["head"]);
	include($structure["static"]["LSwatch"]);
?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div id = "partner-container">
	    	<div class = "auth-content">
			    <p>
			    	<?php if ($status == 3 and $balance > 0) {?>
			    		Invest in BitWhisk
			    	<?php } else {?>
			    		Become a partner
			    	<?php }?>
			    </p>
		    	<?php if ($status == 0) {?>
		    		<p class = "partner-slogan">
			    		If you want to join our mission of guarding people's privacy, please
			    		<a class = "faq-href" href = "/signup">create an account</a> or <a class = "faq-href" href = "/signin">sign in</a>.
			    	</p>
		    	<?php } elseif ($status == 1) {?>
		    		<p class = "partner-slogan">
			    		You are almost there. Please, <a class = "faq-href" href = "/verify">verify your e-mail</a> to
			    		get full access to your account.
			    	</p>
		    	<?php } elseif ($status == 2) {?>
		    		<p class = "partner-slogan">
		    			Please, <a class = "faq-href" href = "/signature">confirm your signature</a> to get access to your account data.
		    		</p>
		    	<?php } elseif ($status == 3) {?>
			    	<p>
				    	Your current investment capital is <?php echo numberFormat($balance, 8);?> BTC<?php if ($balance > 0) {?>,
				    	while share in our profit constitutes <?php echo $shareText;?>%<?php }?>.
				    	Below is the address accepting your payments:
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
				    	investment is registered and the new deposit address is released.
				    </p>
				    <p class = "text-center" style = "font-size: 16px; margin-top: 50px;">
				    	Calculator
				    </p>
				    <div class = "invest-calculator">
				    	<div>
				    		<input type = "text" class = "signup-input" id = "partner-investment" placeholder = "Your BTC">
				    	</div>
				    	<div>
				    		<input type = "text" class = "signup-input" id = "partner-share" placeholder = "Your %">
				    	</div>
				    </div>
				    <p style = "margin-top: 80px;">
				    	You can always <a class = "faq-href" href = "/stats">get acquainted</a> with our turnover before investing.
				    </p>
			    <?php }?>
			</div>
			<div class = "slideshow-container" style = "<?php if ($status == 3) { echo "margin-top: 50px"; }?>">
	    		<div class = "slide">
	    			<div>
	    				<img src = "/images/shares.svg" alt="" height = "70">
	    			</div>
	    			<p class = "slide-header">Fair stakes</p>
	    			<p class = "slide-prop">70% of profit is shared among our partners</p>
	    		</div>
	    		<div class = "slide">
	    			<div>
	    				<img src = "/images/atm.svg" alt="" height = "70">
	    			</div>
	    			<p class = "slide-header">Fast withdraw</p>
	    			<p class = "slide-prop">Request your coins back any time</p>
	    		</div>
	    		<div class = "slide">
	    			<div>
	    				<img src = "/images/operations.svg" alt="" height = "70">
	    			</div>
	    			<p class = "slide-header">Smart account</p>
	    			<p class = "slide-prop">All operations at one place</p>
	    		</div>
	    		<div class = "slide">
	    			<div>
	    				<img src = "/images/system.svg" alt="" height = "70">
	    			</div>
	    			<p class = "slide-header">No lower-bound</p>
	    			<p class = "slide-prop">Invest an amount you are comfortable with</p>
	    		</div>
	    		<div class = "slide">
	    			<div>
	    				<img src = "/images/control.svg" alt="" height = "70">
	    			</div>
	    			<p class = "slide-header">Full control</p>
	    			<p class = "slide-prop">Observe the mixer statistics</p>
	    		</div>
	    		<div class = "slide">
	    			<div>
	    				<img src = "/images/padlock.svg" alt="" height = "70">
	    			</div>
	    			<p class = "slide-header">Best security</p>
	    			<p class = "slide-prop">Protect your account with Bitcoin signature</p>
	    		</div>
	    	</div>
    	</div>
    	<?php if ($status < 3) {?>
	    	<script>
	    		document.querySelector("#partner-container").style.visibility = "hidden";
	    	</script>
    	<?php }?>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
<?php if ($status < 3) {?>
<script src="/scripts/partner/header.js"></script>
<script src="/scripts/partner/windowResize.js"></script>
<?php } else {?>
<script> 
	var balance = <?php echo $balance;?>,
		investmentPool = <?php echo $total;?>;
	if (balance > 0) {
		document.title = "BitWhisk \u2014 Invest in BitWhisk";
	}
</script>
<script src="/scripts/header.js"></script>
<script src="/scripts/partner/calculator.js"></script>
<script src="/scripts/partner/letter.js"></script>
<?php }?>


</body>
</html>