<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>Manage password</p>
		    <div class = "input-container" style = "position: relative">
		        <label id = "view-password"><img src = "/images/view.svg" alt = "" height = "18px"></label>
		        <input class = "signup-input" id = "old-password" type = "password" maxlength="60" placeholder = "Old password">
		        <label class = "error-label" id = "old-password-error"></label>
		    </div>
		    <div class = "input-container" style = "position: relative">        
		        <input class = "signup-input" id = "new-password" type = "password" maxlength="60" placeholder = "New password">
		        <label class = "error-label" id = "new-password-error"></label>
		    </div>
		    <div class = "input-container">
		        <input class = "signup-input" id = "new-password-again" type = "password" maxlength="60" placeholder = "Confirm new password">
		        <label class = "error-label" id = "new-password-again-error"></label>
		    </div>
		    
		    <div class = "continue-button-parent auth-button-parent" style = "margin-top: 10px">
		        <button class = "continue-button-disabled auth-button">Change</button>
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

		<div class = "too-many-requests-popup" id = "fail">
		    <div class = "too-many-requests-popup-content" id = "fail-close">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Server error</p>
		        <p class = "too-many-requests-main-text">                    
		        Due to an internal error our server refused to change your password. This happens 
		        quite rarely, there is no your fault here. We will be thankful if you notify us 
		        about this incident via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a></p> 
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
		    </div>
		</div>

		<div class = "too-many-requests-popup" id = "success">
		    <div class = "too-many-requests-popup-content" id = "success-close">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Password changed</p>
		        <p class = "too-many-requests-main-text">                    
		        The password has been successfully changed. You may return to 
		        <a class = "faq-href" href = "/profile">profile page</a>.
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/happy.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Thanks for using BitWhisk</p>
		    </div>
		</div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/profile/password/header.js"></script>
<script src="/scripts/profile/password/windowResize.js"></script>
<script src="/scripts/profile/password/validation.js"></script>

</body>
</html>