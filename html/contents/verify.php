<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>
		        Verification
		    </p>
		    <div class = "input-container">
		        <input class = "signup-input wide" id = "verification-code" type = "text" maxlength="20" placeholder = "Verification code (check e-mail)">
		    </div>

		    <div class = "input-container bitwhisk-code-container">
		        <div>
		            <input class = "signup-input" id = "bitwhisk-code" type = "text" maxlength="6" placeholder = "BitWhisk code"><br>
		            <div id = "what-is-it"><a href = "/faq#what-is-bitwhisk-code">What is this code?</a></div>
		        </div>               
		        <div class = "continue-button-parent auth-button-parent no-margin-top">
		            <button class = "continue-button-disabled auth-button no-margin-top">Verify</button>
		        </div>
		    </div>
		    <div class = "auth-error" style = "margin-top: 20px">
		    </div>
		</div>
		<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>
		<div class = "load-in-progress">
		    <div class = "animation-content">
		        <img src = "/images/spinner.svg">
		    </div>
		</div>

		<div class = "too-many-requests-popup">
		    <div class = "too-many-requests-popup-content">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Server error</p>
		        <p class = "too-many-requests-main-text">                    
		        Due to an internal error our server refused to verify your account. This happens 
		        quite rarely, there is no your fault in this. We will be thankful if you notify us 
		        about this incident via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a></p> 
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
		    </div>
		</div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
<script src="/scripts/verify/header.js"></script>
<script src="/scripts/verify/windowResize.js"></script>
<script src="/scripts/verify/validation.js"></script>

</body>
</html>