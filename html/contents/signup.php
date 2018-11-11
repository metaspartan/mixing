<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>Registration</p>
		    <div class = "input-container" style="margin-top: 25px">
		        <input class = "signup-input" id = "login" type = "text" maxlength="60" placeholder = "Login"><br>
		        <label class = "error-label" id = "login-error"></label>
		    </div>
		    <div class = "input-container">
		        <input class = "signup-input" id = "e-mail" type = "e-mail" placeholder = "E-mail"><br>
		        <label class = "error-label" id = "e-mail-error"></label>
		    </div>
		    <div class = "input-container" style = "position: relative">
		        <label id = "view-password"><img src = "/images/view.svg" alt = "" height = "18px"></label>
		        <input class = "signup-input" id = "password" type = "password" maxlength="60" placeholder = "Password"><br>
		        <label class = "error-label" id = "password-error"></label>
		    </div>
		    <div class = "input-container">
		        <input class = "signup-input" id = "password-again" type = "password" maxlength="60" placeholder = "Confirm password"><br>
		        <label class = "error-label" id = "password-again-error"></label>
		    </div>
		    <div class = "input-container captcha-container" style="margin-top: 10px">
		        <div>
		            <input class = "signup-input captcha" type = "text" placeholder = "Captcha" maxlength="6">
		        </div>
		        <div>                
		            <img title="Click to reload" class = "captcha-image" src = "/auth/createCaptcha?referer=signup">
		        </div>          
		    </div>
		    <div id = "captcha-outdated">
		        Please, reload captcha
		    </div>
		    
		    <div class = "continue-button-parent auth-button-parent">
		        <button class = "continue-button-disabled auth-button">Sign up</button>
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
		        Due to an internal error our server refused to register your account. This happens 
		        quite rarely, there is no your fault here. We will be thankful if you notify us 
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

<script src="/scripts/signup/header.js"></script>
<script src="/scripts/signup/windowResize.js"></script>
<script src="/scripts/signup/validation.js"></script>

</body>
</html>