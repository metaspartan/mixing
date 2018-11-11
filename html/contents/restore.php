<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>Restore access</p>
		    <div id = "restore-first-step">        
		        <div class = "input-container">
		            <input class = "signup-input" id = "login" type = "text" maxlength="60" placeholder = "Login or e-mail">
		        </div>
		        <div>
		            <a id = "skip-restore-FS">I have a restore code</a>
		        </div>
		    </div>
		    <div id = "restore-second-step">
		        <div class = "input-container">
		            <input class = "signup-input" id = "restore-code" type = "text" maxlength="20" placeholder = "Restore code (check e-mail)">
		            <label class = "error-label" id = "restore-code-error"></label>
		        </div>
		        <div class = "input-container" style = "position: relative">
		            <label id = "view-password"><img src = "/images/view.svg" alt = "" height = "18px"></label>
		            <input class = "signup-input" id = "password" type = "password" maxlength="60" placeholder = "Password"><br>
		            <label class = "error-label" id = "password-error"></label>
		        </div>
		        <div class = "input-container">
		            <input class = "signup-input" id = "password-again" type = "password" maxlength="60" placeholder = "Confirm password">
		            <br>
		            <label class = "error-label" id = "password-again-error"></label>
		        </div>
		    </div>
		    <div class = "input-container captcha-container" style="margin-top: 10px">
		        <div>
		            <input class = "signup-input captcha" type = "text" placeholder = "Captcha" maxlength="6">
		        </div>
		        <div>                
		            <img title="Click to reload" class = "captcha-image" src = "/auth/createCaptcha?referer=restore">
		        </div>          
		    </div>
		    <div id = "captcha-outdated">
		        Please, reload captcha
		    </div>
		    
		    <div class = "continue-button-parent auth-button-parent">
		        <button class = "continue-button-disabled auth-button">Send code</button>
		    </div>   
		    <div class = "auth-error">
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

		<div class = "too-many-requests-popup FS-int-error">
		    <div class = "too-many-requests-popup-content">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Server error</p>
		        <p class = "too-many-requests-main-text">                    
		        Due to an internal error our server refused to send a restore code to your e-mail. This happens 
		        quite rarely, there is no your fault here. We will be thankful if you notify us 
		        about this incident via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a></p> 
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
		    </div>
		</div>

		<div class = "too-many-requests-popup SS-int-error">
		    <div class = "too-many-requests-popup-content">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Server error</p>
		        <p class = "too-many-requests-main-text">                    
		        Due to an internal error our server refused to verify your restore code. This happens 
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

<script src="/scripts/restore/header.js"></script>
<script src="/scripts/restore/windowResize.js"></script>
<script src="/scripts/restore/validation.js"></script>

</body>
</html>