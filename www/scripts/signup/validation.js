function isLoginCorrect() {
	if (/[^A-Za-z0-9]/.test(login.value)) {
		return {isValid: false, reason: "Contains inappropriate character"}
	}
	if (login.value.length < 5) {
		return {isValid: false, reason: "At least 5 characters long"}
	}
	if (login.value.length > 60) {
		return {isValid: false, reason: "Too long"}
	}
	if (!/[a-z]/i.test(login.value)) {
		return {isValid: false, reason: "At least one letter"}
	}
	if (occupiedLogins.contains(login.value)) {
		return {isValid: false, reason: "This login is already occupied"}
	}
	return {isValid: true};	
}

function handleLogin() {
	if (login.value == "") {
		defaultStyle();
		defineState();
		return;
	}
	var loginState = isLoginCorrect();

	if (!loginState.isValid) {
		defineState();
		errorStyle(loginState.reason);		
	} else {
		defineState();
		defaultStyle();
	}
	
	function defaultStyle() {
		login.style.border = "1px solid " + colorDefault;
		loginError.innerHTML = "";
		login.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		login.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle(message) {
		login.style.border = "1px solid " + colorDefault;
		login.style.boxShadow = "inset 0 0 5px " + colorDefault;
		login.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		    loginError.innerHTML = "";
		}
		login.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		    loginError.innerHTML = message;
		}
	}
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

function isEmailCorrect() {
	var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	if (!regex.test(email.value)) {
		return {isValid: false, reason: "Incorrect address"};
	}
	if (occupiedMails.contains(email.value)) {
		return {isValid: false, reason: "This e-mail is already occupied"};
	}
	return {isValid: true};
}

function handleEmail() {
    if (email.value == "") {
    	defineState();	
		defaultStyle();
		return;
	}

	var emailState = isEmailCorrect();

	if (!emailState["isValid"]) {
		defineState();
		errorStyle(emailState["reason"]);
	} else {
		defineState();
		defaultStyle();
	}

	function defaultStyle() {
		email.style.border = "1px solid " + colorDefault;
		emailError.innerHTML = "";	
		email.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		email.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle(message) {
		email.style.border = "1px solid " + colorDefault;
		email.style.boxShadow = "inset 0 0 5px " + colorDefault;
		email.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		    emailError.innerHTML = "";
		}
		email.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		    emailError.innerHTML = message;
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
	body.push('Content-Disposition: form-data; name="referer"\r\n\r\nsignup\r\n');
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
	captchaImage.src = "/auth/createCaptcha?referer=signup&a="+captchaImage.a;
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
	if (!login.value || !isLoginCorrect()["isValid"]) {
		return false;
	}
	if (!passwd.value || !isPasswordCorrect()["isValid"]) {
		return false;
	}
	if (!passwdAgain || !isPasswordAgainCorrect()) {
		return false;
	}
	if (!email.value || !isEmailCorrect()["isValid"]) {
		return false;
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

function signup() {
	if (!defineState()) {
		return;
	}
	document.querySelector(".load-in-progress").style.display = "block";
	button.onclick = function() {return};
	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'];	
	body.push('Content-Disposition: form-data; name="login"\r\n\r\n' + login.value + '\r\n');
	body.push('Content-Disposition: form-data; name="email"\r\n\r\n' + email.value + '\r\n');
	body.push('Content-Disposition: form-data; name="password"\r\n\r\n' + passwd.value + '\r\n');
	body.push('Content-Disposition: form-data; name="captcha"\r\n\r\n' + captcha.value + '\r\n');
	body = body.join(boundaryMiddle) + boundaryLast;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/createUser', true);
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
				captchaDefaultStyle();
				defineState();
			}
			if (!response.success && response.reason == "internal") {
				document.querySelector(".too-many-requests-popup").style.display = "block";
			}
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (!response.success && response.reason == "loginUsed") {
				loginErrorStyle("This login is already occupied");
				if (!occupiedLogins.contains(login.value)) {
					occupiedLogins.push(login.value);
				}
				loadNewCaptcha();
			}
			if (!response.success && response.reason == "emailUsed") {
				emailErrorStyle("This e-mail is already occupied");
				if (!occupiedMails.contains(email.value)) {
					occupiedMails.push(email.value);
				}
				loadNewCaptcha();
			}			
			if (response.success) {
				if (lsTest()) {
					localStorage.status = 1;
					localStorage.statusChanged = "yes";
				}
				window.location.replace("/verify");
			}
		} else {
			document.querySelector(".too-many-requests-popup").style.display = "block";
		}

		button.addEventListener("click", signup);

		function captchaDefaultStyle() {
			captcha.style.border = "1px solid " + colorDefault;
			captcha.style.background = "white";
			captcha.onfocus = function(){
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			}
			captcha.onblur = function(){
			    this.style.boxShadow = "none";
			}
		}

		function loginErrorStyle(message) {
			login.style.border = "1px solid " + colorError;
			loginError.innerHTML = message;
			login.onfocus = function() {
				this.style.border = "1px solid " + colorDefault;
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			    loginError.innerHTML = "";
			}
			login.onblur = function() {
				this.style.border = "1px solid " + colorError;
			    this.style.boxShadow = "none";
			    loginError.innerHTML = message;
			}
		}

		function emailErrorStyle(message) {
			email.style.border = "1px solid " + colorError;
			emailError.innerHTML = message;
			email.onfocus = function() {
				this.style.border = "1px solid " + colorDefault;
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			    emailError.innerHTML = "";
			}
			email.onblur = function() {
				this.style.border = "1px solid " + colorError;
			    this.style.boxShadow = "none";
			    emailError.innerHTML = message;
			}
		}
	}
	xhr.send(body);
}

var login = document.querySelector("#login"),
	loginError = document.querySelector("#login-error"),
    passwd = document.querySelector("#password"),
    viewPasswd = document.querySelector("#view-password"),
    passwdError = document.querySelector("#password-error"),
    passwdAgain = document.querySelector("#password-again"),
    passwdAgainError = document.querySelector("#password-again-error"),
    email = document.querySelector("#e-mail"),
    emailError = document.querySelector("#e-mail-error"),
    captcha = document.querySelector(".captcha"),
    captchaImage = document.querySelector(".captcha-image"),
    button = document.querySelector(".continue-button-disabled"),
    captchaOutdated = document.querySelector("#captcha-outdated"),
	colorDefault   = "#729fa0",
    colorError     = "#ff0033",
    colorCaptchaCorrect = "#c7eacd";
   
occupiedLogins = [];
occupiedMails = [];

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
passwd.addEventListener("input", handlePasswd);
viewPasswd.addEventListener("click", passwdsVisible);
viewPasswd.addEventListener("mouseover", function () {viewPasswd.hover = true;});
viewPasswd.addEventListener("mouseout", function () {viewPasswd.hover = false;});
passwdAgain.addEventListener("input", handlePasswdAgain);
email.addEventListener("input", handleEmail);
captcha.addEventListener("input", handleCaptcha);
captchaImage.addEventListener("click", loadNewCaptcha);
captchaImage.a = 1;
button.addEventListener("click", signup);

window.onclick = function(event) {
    if (event.target == document.querySelector(".too-many-requests-popup")) {
        document.querySelector(".too-many-requests-popup").style.display = "none";
    }
}

document.querySelector(".close-too-many-requests-popup").onclick = function() {
    document.querySelector(".too-many-requests-popup").style.display = "none";
}

Array.prototype.contains = function(el) {
	return this.indexOf(el) > -1;
}

function lsTest(){
    var test = 'test';
    try {
        localStorage.setItem(test, test);
        localStorage.removeItem(test);
        return true;
    } catch(e) {
        return false;
    }
}
