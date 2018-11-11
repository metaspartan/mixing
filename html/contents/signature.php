<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>

    	<div class = "auth-content">
		    <p>Sign a string</p>
		    <div class = "input-container wide gray">
		        <?php echo $session["data"]["checkString"];?>
		    </div>	
		    <div class = "input-container wide">
		        <input class = "input-address protect-input" type="text" autocomplete="off" placeholder="Your signature">
		    </div>		    
		    <div class = "continue-button-parent protect-button-parent">
		        <button class = "continue-button-disabled auth-button">Let me in</button>
		    </div>
		    <div class="auth-error">
		    	Wrong signature
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

		<div class = "too-many-requests-popup" id = "error-popup">
		    <div class = "too-many-requests-popup-content">
		        <span class = "close-too-many-requests-popup" id = "close-error-popup"></span>
		        <p class = "too-many-requests-please">Server error</p>
		        <p class = "too-many-requests-main-text">                    
			        Due to an internal error our server failed to verify your signature. 
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
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/signature/header.js"></script>
<script src="/scripts/signature/windowResize.js"></script>
<script src="/scripts/signature/validation.js"></script>
</body>
</html>