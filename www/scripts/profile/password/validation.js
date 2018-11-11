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

function handleOldPasswd() {
	defineState();
	defaultStyle();
	viewPasswd.errorMode = false;

	function defaultStyle() {
		oldPasswd.style.border = "1px solid " + colorDefault;
		oldPasswdError.innerHTML = "";	
		oldPasswd.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		oldPasswd.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}
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
		passwd.style.border = "1px solid " + colorDefault;
		passwd.style.boxShadow = "inset 0 0 5px " + colorDefault;
		passwd.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		    passwdError.innerHTML = "";
		}
		passwd.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		    passwdError.innerHTML = passState.reason;
		}
	}
}

function passwdsVisible() {
	if (this.visible) {
		oldPasswd.type = "password";
		passwd.type = "password";
		passwdAgain.type = "password";
		viewPasswd.removeChild(this.firstChild);
		if (viewPasswd.errorMode) {
			viewPasswd.appendChild(viewImgError);
		} else {
			viewPasswd.appendChild(viewImg);
		}	
	} else {
		oldPasswd.type = "text";
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

function defineState() {
	setDisabled();
	if (!oldPasswd.value) {
		return false;
	}
	if (!passwd.value || !isPasswordCorrect()["isValid"]) {
		return false;
	}
	if (!passwdAgain || !isPasswordAgainCorrect()) {
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

function change() {
	if (!defineState()) {
		return;
	}
	document.querySelector(".load-in-progress").style.display = "block";
	button.onclick = function() {return};
	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'];	
	body.push('Content-Disposition: form-data; name="oldPasswd"\r\n\r\n' + oldPasswd.value + '\r\n');
	body.push('Content-Disposition: form-data; name="newPasswd"\r\n\r\n' + passwd.value + '\r\n');
	body = body.join(boundaryMiddle) + boundaryLast;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/changePassword', true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
	xhr.onreadystatechange = function() {
		if (this.readyState != 4) return;
		document.querySelector(".load-in-progress").style.display = "none";
		if (this.status === 200) {
			var response = JSON.parse(this.responseText);
			if (!response.success && response.reason == "internal") {
				failPopup.style.display = "block";
			}
			if (!response.success && response.reason == "wrongOldPassword") {
				viewPasswd.errorMode = true;
				oldPassErrorStyle("Password does not match");
			}
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (response.success) {
				oldPasswd.value = "";
				passwd.value = "";
				passwdAgain.value = "";
				defineState();
				successPopup.style.display = "block";
			}
		} else {
			failPopup.style.display = "block";
		}

		button.addEventListener("click", change);
		
		function oldPassErrorStyle(message) {
			oldPasswd.style.border = "1px solid " + colorError;
			oldPasswdError.innerHTML = message;
			viewPasswd.removeChild(viewPasswd.firstChild);
		    if (viewPasswd.visible) {
		    	viewPasswd.appendChild(hideImgError);
		    } else {
		    	viewPasswd.appendChild(viewImgError);
		    }
			oldPasswd.onfocus = function() {
				this.style.border = "1px solid " + colorDefault;
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			    oldPasswdError.innerHTML = "";
			    viewPasswd.removeChild(viewPasswd.firstChild);
			    if (viewPasswd.visible) {
			    	viewPasswd.appendChild(hideImg);
			    } else {
			    	viewPasswd.appendChild(viewImg);
			    }
			}
			oldPasswd.onblur = function() {
				this.style.border = "1px solid " + colorError;
			    this.style.boxShadow = "none";
			    oldPasswdError.innerHTML = message;
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
	xhr.send(body);
}

var oldPasswd = document.querySelector("#old-password"),
	oldPasswdError = document.querySelector("#old-password-error"),
    passwd = document.querySelector("#new-password"),
    viewPasswd = document.querySelector("#view-password"),
    passwdError = document.querySelector("#new-password-error"),
    passwdAgain = document.querySelector("#new-password-again"),
    passwdAgainError = document.querySelector("#new-password-again-error"),
    button = document.querySelector(".continue-button-disabled"),
    captchaOutdated = document.querySelector("#captcha-outdated"),
    successPopup = document.querySelector("#success"),
    closeSuccessPopup = document.querySelector("#success-close"),
    failPopup =  document.querySelector("#fail"),
    closeFailPopup =  document.querySelector("#fail-close"),
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

oldPasswd.addEventListener("input", handleOldPasswd);
passwd.addEventListener("input", handlePasswd);
viewPasswd.addEventListener("click", passwdsVisible);
viewPasswd.addEventListener("mouseover", function () {viewPasswd.hover = true;});
viewPasswd.addEventListener("mouseout", function () {viewPasswd.hover = false;});
passwdAgain.addEventListener("input", handlePasswdAgain);

button.addEventListener("click", change);

window.onclick = function(event) {
    if (event.target == failPopup) {
        failPopup.style.display = "none";
    }
    if (event.target == successPopup) {
        successPopup.style.display = "none";
    }
}

closeFailPopup.onclick = function() {
    failPopup.style.display = "none";
}

closeSuccessPopup.onclick = function() {
    successPopup.style.display = "none";
}

