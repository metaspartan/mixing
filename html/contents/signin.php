<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>Sign into account</p>
		    <div class = "input-container">
		        <input class = "signup-input" id = "login" type = "text" maxlength="60" placeholder = "Login or e-mail">
		    </div>
		    <div class = "input-container" style = "position: relative; margin-top: 25px">
		        <label id = "view-password"><img src = "/images/view.svg" alt = "" height = "18px"></label>
		        <input class = "signup-input" id = "password" type = "password" maxlength="60" placeholder = "Password">
		        <label class="checkbox-container" style = "width: 90px">
		            <span>Remember me</span>
		            <input type="checkbox">
		            <span class="checkmark"></span>            
		        </label>
		        <a href = "/restore" class = "restore" id = "desktop">Forgot password</a>
		        <a href = "/restore" class = "restore" id = "mobile">Restore</a>
		    </div>

		    
		    <div class = "input-container captcha-container">
		        <div>
		            <input class = "signup-input captcha" type = "text" placeholder = "Captcha" maxlength="6">
		        </div>
		        <div>                
		            <img title="Click to reload" class = "captcha-image" src = "/auth/createCaptcha?referer=signin">
		        </div>          
		    </div>
		    <div id = "captcha-outdated">
		        Please, reload captcha
		    </div>
		    
		    <div class = "continue-button-parent auth-button-parent">
		        <button class = "continue-button-disabled auth-button">Sign in</button>
		    </div>

		    <div class = "auth-error">
		        Unable to authorize
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
		        Due to an internal error our server refused to let you in. This happens 
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

<script src="/scripts/signin/header.js"></script>
<script src="/scripts/signin/windowResize.js"></script>
<script src="/scripts/signin/validation.js"></script>

</body>
</html>