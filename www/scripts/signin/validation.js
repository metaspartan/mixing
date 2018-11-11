function handleLogin() {
	signinError.style.display = "none";
	defineState();
}

function handlePasswd() {
	signinError.style.display = "none";
	defineState();
}

function passwdsVisible() {
	if (this.visible) {
		passwd.type = "password";
		viewPasswd.removeChild(this.firstChild);
		viewPasswd.appendChild(viewImg);
	} else {
		passwd.type = "text";
		viewPasswd.removeChild(this.firstChild);
		viewPasswd.appendChild(hideImg);
	}
	this.visible = !this.visible;
}

function handleCheckbox(event) {
	if (event.target.tagName == "INPUT") {
		checkbox.remember = !checkbox.remember;
	}	
}

function isCaptchaCorrect() {
	if (captcha.value.length != 6) {
		return false;
	}
	return /^[a-zA-Z0-9]+$/.test(captcha.value);
}

function handleCaptcha() {
	signinError.style.display = "none";
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
	body.push('Content-Disposition: form-data; name="referer"\r\n\r\nsignin\r\n');
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
	captchaImage.src = "/auth/createCaptcha?referer=signin&a="+captchaImage.a;
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
	if (!login.value) {
		return false;
	}
	if (!passwd.value) {
		return false;
	}
	if (!captcha.isCorrect) {
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

function signin() {
	if (!defineState()) {
		return;
	}
	document.querySelector(".load-in-progress").style.display = "block";
	button.onclick = function() {return};
	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'], 
		remember = checkbox.remember ? "1" : "0";

	body.push('Content-Disposition: form-data; name="login"\r\n\r\n' + login.value + '\r\n');
	body.push('Content-Disposition: form-data; name="password"\r\n\r\n' + passwd.value + '\r\n');
	body.push('Content-Disposition: form-data; name="captcha"\r\n\r\n' + captcha.value + '\r\n');
	body.push('Content-Disposition: form-data; name="remember"\r\n\r\n' + remember + '\r\n');
	body = body.join(boundaryMiddle) + boundaryLast;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/signinUser', true);
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
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (!response.success && response.reason == "internal") {
				document.querySelector(".too-many-requests-popup").style.display = "block";
			}
			if (!response.success && response.reason == "wrongData") {
				loadNewCaptcha();
				passwd.value = "";
				defineState();
				signinError.style.display = "block";
			}
			if (response.success) {
				if (lsTest()) {
					localStorage.status = response.newStatus;
					localStorage.statusChanged = "yes";
					if (response.bcode) {
						localStorage.bitwhiskcode = response.bcode;
					}
				}
				window.location.replace(response.nextStep);
			}
		} else {
			document.querySelector(".too-many-requests-popup").style.display = "block";
		}

		button.addEventListener("click", signin);

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

var signinError = document.querySelector(".auth-error"),
	login = document.querySelector("#login"),
    passwd = document.querySelector("#password"),
    viewPasswd = document.querySelector("#view-password"),
    checkbox = document.querySelector(".checkbox-container"),
    captcha = document.querySelector(".captcha"),
    captchaImage = document.querySelector(".captcha-image"),
    button = document.querySelector(".continue-button-disabled"),
    captchaOutdated = document.querySelector("#captcha-outdated"),
	colorDefault   = "#729fa0",
    colorError     = "#ff0033",
    colorCaptchaCorrect = "#c7eacd";    

viewPasswd.visible = false;
checkbox.remember = false;
viewImg = viewPasswd.firstChild;
hideImg = document.createElement("img");
hideImg.src = "/images/hide.svg";
hideImg.style.alt = "";
hideImg.style.height = "18px";

login.addEventListener("input", handleLogin);
passwd.addEventListener("input", handlePasswd);
viewPasswd.addEventListener("click", passwdsVisible);
checkbox.addEventListener("click", handleCheckbox);
captcha.addEventListener("input", handleCaptcha);
captchaImage.addEventListener("click", loadNewCaptcha);
captchaImage.a = 1;
button.addEventListener("click", signin);

window.onclick = function(event) {
    if (event.target == document.querySelector(".too-many-requests-popup")) {
        document.querySelector(".too-many-requests-popup").style.display = "none";
    }
}

document.querySelector(".close-too-many-requests-popup").onclick = function() {
    document.querySelector(".too-many-requests-popup").style.display = "none";
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

