function handleLogin() {
	defineState();
	restoreError.style.display = "none";
}

function handleRcode() {
	defineState();
	restoreError.style.display = "none";
}

function isPasswordCorrect() {
	var password = passwd.value;
	if (/[^A-Za-z0-9!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/.test(password)) {
		return {isValid: false, reason: "Contains inappropriate character"}
	}
	if (password.length < 8) {
		return {isValid: false, reason: "At least 8 characters long"}
	}
	if (password.length > 60) {
		return {isValid: false, reason: "Too long"}
	}
	if (!/(?=.*[a-z])/.test(password)) {
		return {isValid: false, reason: "At least one a-z symbol"}
	}
	if (!/(?=.*[A-Z])/.test(password)) {
		return {isValid: false, reason: "At least one A-Z symbol"}
	}
	if (!/(?=.*\d)/.test(password)) {
		return {isValid: false, reason: "At least one digit"}
	}
	if (!/(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/.test(password)) {
		return {isValid: false, reason: "At least one special character"}
	}
	return {isValid: true};
}

function handlePasswd() {	
	var passState = isPasswordCorrect();
	if (passState.isValid || passwd.value == "") {
		defaultStyle();
	} else {
		errorStyle();		
	}

	if (!isPasswordAgainCorrect() && passwdAgain.value) {
		passwdAgain.style.border = "1px solid " + colorError;
	    passwdAgain.style.boxShadow = "none";
	    passwdAgainError.innerHTML = "Passwords don't match";
	}

	if (isPasswordAgainCorrect() && passwdAgain.value) {
		passwdAgain.style.border = "1px solid " + colorDefault;
	    passwdAgain.style.boxShadow = "none";
	    passwdAgainError.innerHTML = "";
	}

	defineState();

	function defaultStyle() {
		viewPasswd.errorMode = false;
		passwd.style.border = "1px solid " + colorDefault;
		passwdError.innerHTML = "";	
		passwd.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		passwd.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle() {
		viewPasswd.errorMode = true;
		passwd.style.border = "1px solid " + colorDefault;
		passwd.style.boxShadow = "inset 0 0 5px " + colorDefault;
		passwd.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		    passwdError.innerHTML = "";
		    viewPasswd.removeChild(viewPasswd.firstChild);
		    if (viewPasswd.visible) {
		    	viewPasswd.appendChild(hideImg);
		    } else {
		    	viewPasswd.appendChild(viewImg);
		    }
		}
		passwd.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		    passwdError.innerHTML = passState.reason;
		    viewPasswd.removeChild(viewPasswd.firstChild);
		    if (viewPasswd.visible) {
		    	viewPasswd.appendChild(hideImgError);
		    } else {
		    	viewPasswd.appendChild(viewImgError);
		    }
		    if (viewPasswd.hover) {
		    	var clickEvent = document.createEvent("MouseEvents");
		    	clickEvent.initEvent("click", true, true);
		    	viewPasswd.dispatchEvent(clickEvent);
		    }
		}
	}
}

function passwdsVisible() {
	if (this.visible) {
		passwd.type = "password";
		passwdAgain.type = "password";
		viewPasswd.removeChild(this.firstChild);
		if (viewPasswd.errorMode) {
			viewPasswd.appendChild(viewImgError);
		} else {
			viewPasswd.appendChild(viewImg);
		}		
	} else {
		passwd.type = "text";
		passwdAgain.type = "text";
		viewPasswd.removeChild(this.firstChild);
		if (viewPasswd.errorMode) {
			viewPasswd.appendChild(hideImgError);
		} else {
			viewPasswd.appendChild(hideImg);
		}
	}
	this.visible = !this.visible;
}

function isPasswordAgainCorrect() {
	return passwd.value === passwdAgain.value;
}

function handlePasswdAgain() {
	if (isPasswordAgainCorrect() || passwdAgain.value == "") {
		defaultStyle();
	} else {
		errorStyle();	
	}

	defineState();

	function defaultStyle() {
		passwdAgain.style.border = "1px solid " + colorDefault;
		passwdAgainError.innerHTML = "";
		passwdAgain.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		passwdAgain.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle() {
		passwdAgain.style.border = "1px solid " + colorDefault;
		passwdAgain.style.boxShadow = "inset 0 0 5px " + colorDefault;
		passwdAgain.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		    passwdAgainError.innerHTML = "";
		}
		passwdAgain.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		    passwdAgainError.innerHTML = "Passwords don't match";
		}
	}
}

function isCaptchaCorrect() {
	if (captcha.value.length != 6) {
		return false;
	}
	return /^[a-zA-Z0-9]+$/.test(captcha.value);
}

function handleCaptcha() {
	if (!captcha.value) {
		defaultStyle();
		defineState();
		return;
	} 
	if (!isCaptchaCorrect()) {
		errorStyle();
		defineState();
		return;
	}

	var boundary   = String(Math.random()).slice(2),
	boundaryMiddle = '--' + boundary + '\r\n',
	boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'];
	body.push('Content-Disposition: form-data; name="referer"\r\n\r\nrestore\r\n');
	body.push('Content-Disposition: form-data; name="captcha"\r\n\r\n'+captcha.value+'\r\n');
	body = body.join(boundaryMiddle) + boundaryLast;	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/checkCaptcha', true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
	xhr.onreadystatechange = function() {		
		if (this.readyState != 4) return;
		if (this.status === 200) {
			var response = JSON.parse(this.responseText);
			if (response.isCorrect) {
				captcha.isCorrect = true;
				rightStyle();
				defineState();
			} else {
				captcha.isCorrect = false;
				errorStyle();
				defineState();
			}
		} else {
			captcha.isCorrect = true;
			defaultStyle();
		}
	}
	xhr.send(body);

	function rightStyle() {
		captcha.style.border = "1px solid " + colorDefault;
		captcha.style.boxShadow = "none";
		captcha.style.background = colorCaptchaCorrect;
		captcha.onfocus = function(){
			this.style.border = "1px solid " + colorDefault;
			this.style.background = "white";
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		captcha.onblur = function(){
			this.style.border = "1px solid " + colorDefault;
			this.style.background = colorCaptchaCorrect;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		    this.style.boxShadow = "none";
		}
	}

	function defaultStyle() {
		captcha.style.border = "1px solid " + colorDefault;
		captcha.style.background = "white";
		captcha.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		captcha.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle() {
		captcha.style.border = "1px solid " + colorDefault;
		captcha.style.background = "white"; 
		captcha.style.boxShadow = "inset 0 0 5px " + colorDefault;
		captcha.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		captcha.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		}
	}
}

function loadNewCaptcha() {
	captchaImage.onclick = function() {return};
	captchaImage.src = "/auth/createCaptcha?referer=restore&a="+captchaImage.a;
	captchaImage.a++;
	captcha.value = "";
	captcha.isCorrect = false;
	defaultStyle();
	captchaOutdated.style.display = "none";
	defineState();
	captchaImage.addEventListener("click", loadNewCaptcha);

	function defaultStyle() {
		captcha.style.border = "1px solid " + colorDefault;
		captcha.style.background = "white";
		captcha.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		captcha.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}
}

function defineState() {
	setDisabled();
	if (firstStep) {
		if (!login.value) return false;
	} else {
		if (!rcode.value) return false;
		if (!passwd.value || !isPasswordCorrect()["isValid"]) return false;
		if (!passwdAgain || !isPasswordAgainCorrect()) return false;
	}
	if (!captcha.value || !isCaptchaCorrect() || !captcha.isCorrect) {
		return false;
	}
	setEnabled();
	return true;

	function setEnabled() {
		button.classList.remove("continue-button-disabled");
		button.classList.add("continue-button");
	}

	function setDisabled() {
		button.classList.remove("continue-button");
		button.classList.add("continue-button-disabled");
	}
}

function restore() {
	if (!defineState()) {
		return;
	}
	document.querySelector(".load-in-progress").style.display = "block";
	button.onclick = function() {return};
	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n',
		body = ['\r\n'],
		procedure;

	if (firstStep) {		
		body.push('Content-Disposition: form-data; name="login"\r\n\r\n' + login.value + '\r\n');
		body.push('Content-Disposition: form-data; name="captcha"\r\n\r\n' + captcha.value + '\r\n');
		procedure = "setRestoreCode";
	} else {
		body.push('Content-Disposition: form-data; name="rcode"\r\n\r\n' + rcode.value + '\r\n');
		body.push('Content-Disposition: form-data; name="password"\r\n\r\n' + passwd.value + '\r\n');
		body.push('Content-Disposition: form-data; name="captcha"\r\n\r\n' + captcha.value + '\r\n');		
		procedure = "restoreAccess";		
	}
	body = body.join(boundaryMiddle) + boundaryLast;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/' + procedure, true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
	
	xhr.onreadystatechange = function() {
		if (this.readyState != 4) return;
		document.querySelector(".load-in-progress").style.display = "none";
		if (this.status === 200) {
			var response = JSON.parse(this.responseText);
			if (!response.success && response.reason == "captcha") {
				captchaOutdated.style.display = "block";
				captcha.value = "";
				captcha.isCorrect = false;
				defaultStyle();
				defineState();
			}
			if (!response.success && response.reason == "internal" && firstStep) {
				document.querySelector(".FS-int-error").style.display = "block";
			}
			if (!response.success && response.reason == "internal" && !firstStep) {
				document.querySelector(".SS-int-error").style.display = "block";
			}
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (!response.success && response.reason == "invalidCredentials") {
				login.value = "";
				loadNewCaptcha();
				restoreError.innerHTML = "Invalid credentials";
				restoreError.style.display = "block";
			}
			if (!response.success && response.reason == "invalidRestoreCode") {
				rcode.value = "";
				loadNewCaptcha();
				restoreError.innerHTML = "Wrong restore code";
				restoreError.style.display = "block";
			}
			if (response.success && firstStep) {
				firstStep = false;
				loadNewCaptcha();
				restoreFS.style.display = "none";
				restoreSS.style.display = "block";
				button.innerHTML = "Restore";
				skipFirstStep.parentElement.style.display = "none";
				centralize();
			} else if (response.success && !firstStep) {
				document.querySelector(".auth-content").innerHTML = '<p>Access restored</p><p style = "margin-top: 15px; text-align: center;"><img src = "/images/access-restored.svg" alt="" height = 100></p>';
				centralize();
			}
		} else {
			if (firstStep) {
				document.querySelector(".FS-int-error").style.display = "block";
			} else {
				document.querySelector(".SS-int-error").style.display = "block";
				
			}			
		}

		button.addEventListener("click", restore);

		function defaultStyle() {
			captcha.style.border = "1px solid " + colorDefault;
			captcha.style.background = "white";
			captcha.onfocus = function(){
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			}
			captcha.onblur = function(){
			    this.style.boxShadow = "none";
			}
		}
	}
	xhr.send(body);
}

function skipFS() {
	if (!firstStep) {
		return;
	}
	firstStep = false;
	restoreFS.style.display = "none";
	restoreSS.style.display = "block";
	button.innerHTML = "Restore";
	skipFirstStep.parentElement.style.display = "none";
	centralize();
}

var firstStep = true,
	restoreFS = document.querySelector("#restore-first-step"),
	login = document.querySelector("#login"),
	captchaImage = document.querySelector(".captcha-image"),
	captcha = document.querySelector(".captcha"),
	captchaOutdated = document.querySelector("#captcha-outdated"),
	restoreError = document.querySelector(".auth-error"),
	skipFirstStep = document.querySelector("#skip-restore-FS"),
	
	restoreSS = document.querySelector("#restore-second-step"),
    rcode = document.querySelector("#restore-code"),
    passwd = document.querySelector("#password"),
    viewPasswd = document.querySelector("#view-password"),
    passwdError = document.querySelector("#password-error"),
    passwdAgain = document.querySelector("#password-again"),
    passwdAgainError = document.querySelector("#password-again-error"),    
    button = document.querySelector(".continue-button-disabled"),    
	colorDefault   = "#729fa0",
    colorError     = "#ff0033",
    colorCaptchaCorrect = "#c7eacd";
    

viewPasswd.visible = false;
viewPasswd.errorMode = false;
viewImg = viewPasswd.firstChild;
hideImg = document.createElement("img");
hideImg.src = "/images/hide.svg";
hideImg.style.alt = "";
hideImg.style.height = "18px";

viewImgError = document.createElement("img");
viewImgError.src = "/images/view-error.svg";
viewImgError.style.alt = "";
viewImgError.style.height = "18px";

hideImgError = document.createElement("img");
hideImgError.src = "/images/hide-error.svg";
hideImgError.style.alt = "";
hideImgError.style.height = "18px";


login.addEventListener("input", handleLogin);
rcode.addEventListener("input", handleRcode);
passwd.addEventListener("input", handlePasswd);
viewPasswd.addEventListener("click", passwdsVisible);
viewPasswd.addEventListener("mouseover", function () {viewPasswd.hover = true;});
viewPasswd.addEventListener("mouseout", function () {viewPasswd.hover = false;});
passwdAgain.addEventListener("input", handlePasswdAgain);
captcha.addEventListener("input", handleCaptcha);
captchaImage.addEventListener("click", loadNewCaptcha);
captchaImage.a = 1;
button.addEventListener("click", restore);
skipFirstStep.addEventListener("click", skipFS);

window.onclick = function(event) {
    if (event.target == document.querySelector(".too-many-requests-popup")) {
        var popups = document.querySelectorAll(".too-many-requests-popup");
        for (var i = 0; i < popups.length; i++) {
	    	popups[i].style.display = "none";
	    }
    }
}

document.querySelector(".close-too-many-requests-popup").onclick = function() {
    var popups = document.querySelectorAll(".too-many-requests-popup");
    for (var i = 0; i < popups.length; i++) {
    	popups[i].style.display = "none";
    }
}

function centralize() {
	var donationContentCoords = getCoords(document.querySelector(".auth-content")),
		headerCoords          = getCoords(document.querySelector(".header-mobile-right-menu")),
		footerCoords          = getCoords(document.querySelector(".footer"));

	if (Math.abs(headerCoords.bottom-headerCoords.top) < 0.001) {
		headerCoords = getCoords(document.querySelector(".header"));
	}

	if ((window.innerHeight - headerCoords.bottom - (footerCoords.bottom-footerCoords.top)) - (donationContentCoords.bottom - donationContentCoords.top) > 10) {
		document.querySelector(".auth-content").style.marginTop = ((window.innerHeight - headerCoords.bottom - (footerCoords.bottom-footerCoords.top)) - (donationContentCoords.bottom - donationContentCoords.top))/2 + "px"; 
	} else {
		document.querySelector(".auth-content").style.marginTop = ((footerCoords.top - headerCoords.bottom) - (donationContentCoords.bottom - donationContentCoords.top))/2 + "px"; 
	}

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top:    box.top    + pageYOffset,
            bottom: box.bottom + pageYOffset
        };
    }
}

