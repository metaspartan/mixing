<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>

    	<div class = "auth-content">
	    	<?php if ($session["data"]["twoFactorUI"] == "no") {?>
			    <p>Protect account</p>
			    <p>
			        Just provide us with a <a class="legacy-address">legacy Bitcoin address</a> that you know the private key of.
			        After each login you will be prompted to sign a random string with your address.
			        As simple as that: no third-party involved, perfect protection and anonymity.
			    </p>
			    <div class = "bitcode-tooltip-content">
                    Legacy Bitcoin addresses start with 1. We require the signing 
                    address to be of that type due to compatibility issues.
                </div>
                <div class = "bitcode-tooltip-arrow">
                </div>
			    <div class = "input-container wide">
			        <input class = "input-address protect-input" type="text" maxlength = "74" autocomplete="off" placeholder="Signing Bitcoin address">
			    </div>
			    
			    <div class = "continue-button-parent protect-button-parent">
			        <button class = "continue-button-disabled auth-button">Set protection</button>
			    </div>
			<?php } else {?>
				<p>Account protected</p>
				<div class = "input-container wide">
					<div style = "margin-left: auto; margin-right: auto; width: 80px">
			        	<img src = "/images/geek.svg" alt = "" height = "80">
			        </div>
			        <p style = "text-align: center; font-size: 15px">You may return to <a class = "faq-href" href = "/profile">profile</a></p>
			    </div>
			<?php } ?>
		</div>
		<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>

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
			        Due to an internal error our server refused to set up two-factor authorization 
			        for your account. This happens quite rarely, there is no your fault here. 
			        We will be thankful if you notify us about this incident via 
			        <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>
			    </p> 
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
		    </div>
		</div>

		<div class = "accept-popup" id = "confirm-popup">
	        <div class = "accept-popup-content">
	            <span class = "close-popup" id = "close-confirm-popup"></span>
	            <p class = "accept-popup-please">Please confirm action</p>
	            <p class = "accept-popup-main-text">
		            You are about to set up a two-factor authorization for your account.
		        	Please note,
		            this action is irreversible, once installed the protection cannot be cancelled.
		            Without the private key of the specified address you wont be able to access your
		            BitWhisk account.
		            Moreover, you will not be able to change the signing address in future.
	        	</p>
	            <div class = "accept-button-content">
	                <div class = "accept-button-parent">
	                    <button class = "accept-button">Proceed</button>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/profile/protect/header.js"></script>
<script src="/scripts/profile/protect/windowResize.js"></script>
<?php if ($session["data"]["twoFactorUI"] == "no") {?>
<script src="/scripts/profile/protect/validation.js"></script>
<?php }  else {?>
<script>
	document.title = "BitWhisk \u2014 Account protected";
</script>
<?php } ?>
</body>
</html>