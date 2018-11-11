<?php
	$login   = $session["data"]["login"];
	$balance = $session["data"]["invBalance"];

	if ($balance > 0) {
		global 	$_SERVERNAME,
				$_USERS_USERNAME,
				$_USERS_PASSWORD,
				$_DB_USERS,
				$_DB_USERS_TABLE_WITHDRAW;

		$connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
		$result = mysqli_query($connUsers, "SELECT sum(amount) AS withdraw FROM {$_DB_USERS_TABLE_WITHDRAW} WHERE login='{$login}'");
		$withdrawOrdered = mysqli_fetch_assoc($result)["withdraw"];
	}
	include($structure["static"]["head"]);
	include($structure["static"]["LSwatch"]);
?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
	    	<?php if ($balance == 0) { $case = 1;?>
	    		<p>Nothing to withdraw</p>
				<div class = "input-container wide">
					<div style = "margin-left: auto; margin-right: auto; width: 80px">
			        	<img src = "/images/no-withdraw.svg" alt = "" height = "80">
			        </div>
			        <p style = "text-align: center; font-size: 15px">You need to <a class = "faq-href" href = "/partner">become a partner</a> first.</p>
			    </div>
			<?php } elseif ($balance > 0 and $withdrawOrdered < $balance) { $case = 2;?>
				<p>
			    	Request a withdraw
			    </p>
			    <p>
			        Please note, this is not a profit withdraw. 
			        Use this form in case you decided to reduce 
			        your current investment capital. We will
			        handle your request manually.
			    </p>
			    <div class = "input-container wide">
			        <input class = "input-address protect-input" type="text" id = "wd-amount" autocomplete="off" placeholder="Amount to withdraw (BTC)">
			    </div>
			    <div class = "input-container wide">
			        <input class = "input-address protect-input" type="text" id = "wd-address" maxlength = "74" autocomplete="off" placeholder="Payout Bitcoin address">
			    </div>
			    <div class = "input-container wide">
			        <input class = "input-address protect-input" type="password" id = "wd-password" autocomplete="off" placeholder="Account password">
			    </div>
			    <div class = "continue-button-parent protect-button-parent">
			        <button class = "continue-button-disabled auth-button">Register a request</button>
			    </div>
			    <p style = "font-size: 12px">
			        Withdraw limit: <?php echo numberFormat($balance-$withdrawOrdered, 8);?> BTC
			        <?php if ($withdrawOrdered > 0) {?>
			        	<br>Withdraw in processing: <?php echo numberFormat($withdrawOrdered, 8);?> BTC
			        <?php }?>
			    </p>
			<?php } elseif ($balance > 0 and $withdrawOrdered >= $balance) { $case = 3;?>
				<p>Withdraw is limited</p>
				<div class = "input-container wide">
					<div style = "margin-left: auto; margin-right: auto; width: 80px">
			        	<img src = "/images/no-withdraw.svg" alt = "" height = "80">
			        </div>
			        <p style = "text-align: center; font-size: 15px">
			        	Withdraw in processing: <?php echo numberFormat($withdrawOrdered, 8);?> BTC<br>
			        	You may return to <a class = "faq-href" href = "/profile">profile</a>.
			        </p>
			    </div>
			<?php } ?>
		</div>
		<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>
		<?php if ($case == 2) { ?>
			<div class = "load-in-progress">
			    <div class = "animation-content">
			        <img src = "/images/spinner.svg">
			    </div>
			</div>

			<div class = "too-many-requests-popup" id = "error-popup">
			    <div class = "too-many-requests-popup-content">
			        <span class = "close-too-many-requests-popup" id = "close-error-popup"></span>
			        <p class = "too-many-requests-please">Server error</p>
			        <p class = "too-many-requests-main-text">                    
				        Due to an internal error our server refused to set register your withdraw request.
				        This happens quite rarely, there is no your fault here. 
				        We will be thankful if you notify us about this incident via 
				        <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>
				    </p> 
			        <div class = "too-many-requests-illustration-parent">
			            <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
			        </div>
			        <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
			    </div>
			</div>

			<div class = "too-many-requests-popup" id = "confirm-popup">
			    <div class = "too-many-requests-popup-content">
			        <span class = "close-too-many-requests-popup" id = "close-confirm-popup"></span>
			        <p class = "too-many-requests-please">Withdraw policy</p>
			        <p class = "too-many-requests-main-text">                    
				        Please note, your investment is a part of our mixing pool which is permanently used to handle
				        customers orders. Due to sporadic nature of withdraw operations we handle them manually.
				        Don't worry, it will not take too long.
				    </p> 
			        <div class = "accept-button-content">
		                <div class = "accept-button-parent">
		                    <button class = "accept-button">Proceed</button>
		                </div>
		            </div>
			    </div>
			</div>
		<?php } ?>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
<script src="/scripts/partner/withdraw/header.js"></script>
<script src="/scripts/partner/withdraw/windowResize.js"></script>
<?php if ($case == 1) { ?>
	<script>
		document.title = "BitWhisk \u2014 Nothing to withdraw";
	</script>
<?php } elseif ($case == 2) { ?>
	<script>
		var wdLimit = <?php echo $balance-$withdrawOrdered;?>;
	</script>
	<script src = "/scripts/partner/withdraw/validation.js"></script>
<?php } elseif ($case == 3) {?>
	<script>
		document.title = "BitWhisk \u2014 Withdraw is limited";
	</script>
<?php } ?>
</body>
</html>