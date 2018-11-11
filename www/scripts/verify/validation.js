function isBcodeCorrect() {
	if (bcode.value === "") {
		return {isValid: true};
	}
	if (bcode.value.length < 6) {
		return {isValid: false, reason: "Too short"};
	}
	if (bcode.value.length > 6) {
		return {isValid: false, reason: "Too long"};
	}
	if (/[^abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789]/.test(bcode.value)) {
		return {isValid: false, reason: "Contains inappropriate character"}
	}
	return {isValid: true};
}

function handleBitcode() {
	var info = isBcodeCorrect(bcode);

	if (info.isValid) {
		defaultStyle();
	} else {
		errorStyle(info.reason);
	}

	defineState();

	function defaultStyle() {
		bcode.style.border = "1px solid " + colorDefault;
		bcode.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		bcode.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle(message) {
		bcode.style.border = "1px solid " + colorDefault;
		bcode.style.boxShadow = "inset 0 0 5px " + colorDefault;
		bcode.onfocus = function() {
			this.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		bcode.onblur = function() {
			this.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		}
	}
}

function handleVercode() {
	verifyError.style.display = "none";
	defineState();
}

function defineState() {
	if (vcode.value != "" && isBcodeCorrect()["isValid"]) {
		setEnabled();
		return true;
	} else {
		setDisabled();
		return false;
	}

	function setEnabled() {
		button.classList.remove("continue-button-disabled");
		button.classList.add("continue-button");
	}

	function setDisabled() {
		button.classList.remove("continue-button");
		button.classList.add("continue-button-disabled");
	}
}

function verify() {
	if (!defineState()) {
		return;
	}
	document.querySelector(".load-in-progress").style.display = "block";
	button.onclick = function() {return};
	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'];

	body.push('Content-Disposition: form-data; name="vcode"\r\n\r\n' + vcode.value + '\r\n');
	if (bcode.value) {
		body.push('Content-Disposition: form-data; name="bcode"\r\n\r\n' + bcode.value + '\r\n');
	}	
	body = body.join(boundaryMiddle) + boundaryLast;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/verifyUser', true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
	xhr.onreadystatechange = function() {
		if (this.readyState != 4) return;
		document.querySelector(".load-in-progress").style.display = "none";
		if (this.status === 200) {
			var response = JSON.parse(this.responseText);
			document.querySelector(".load-in-progress").style.display = "none";
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (!response.success && response.reason == "internal") {
				document.querySelector(".too-many-requests-popup").style.display = "block";
			}
			if (!response.success && response.reason == "wrongBCode") {
				vcode.value = "";
				defineState();
				verifyError.innerHTML = "Wrong BitWhisk code";
				verifyError.style.display = "block";
			}
			if (!response.success && response.reason == "wrongVCode") {
				vcode.value = "";
				defineState();
				verifyError.innerHTML = "Wrong verification code";
				verifyError.style.display = "block";
			}
			if (response.success) {
				if (lsTest()) {
					localStorage.bitwhiskcode = response.bcode;
					localStorage.status = 3;
					localStorage.statusChanged = "yes";
				}
				window.location.replace("/profile");
			}
		} else {
			document.querySelector(".too-many-requests-popup").style.display = "block";
		}

		button.addEventListener("click", verify);

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

var verifyError = document.querySelector(".auth-error"),
	vcode = document.querySelector("#verification-code"),
    bcode = document.querySelector("#bitwhisk-code"),
	button = document.querySelector(".continue-button-disabled"),
	colorDefault = "#729fa0",
    colorError = "#ff0033";

bcode.addEventListener("input", handleBitcode);
vcode.addEventListener("input", handleVercode);
button.addEventListener("click", verify);

if (lsTest() && localStorage.bitwhiskcode) {
	bcode.value = localStorage.bitwhiskcode;
	var inputEvent = document.createEvent("HTMLEvents");
    inputEvent.initEvent('input', true, true);
    bcode.dispatchEvent(inputEvent);
    var blurEvent = document.createEvent("HTMLEvents");
    blurEvent.initEvent('blur', true, true);
    bcode.dispatchEvent(blurEvent);
}

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