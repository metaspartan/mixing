function handleSignature() {
	wrongSign.style.display = "none";
	defineState();
}

function defineState() {
	setDisabled();
	if (signature.value == "") {
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

function verifySignature() {
	if (!defineState()) {
		return;
	}
	document.querySelector(".load-in-progress").style.display = "block";
	button.onclick = function() {return};
	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'];

	body.push('Content-Disposition: form-data; name="signature"\r\n\r\n' + signature.value + '\r\n');
	body = body.join(boundaryMiddle) + boundaryLast;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/auth/checkSignature', true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
	xhr.onreadystatechange = function() {
		if (this.readyState != 4) return;
		document.querySelector(".load-in-progress").style.display = "none";
		if (this.status === 200) {
			var response = JSON.parse(this.responseText);
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (!response.success && response.reason == "internal") {
				document.querySelector(".too-many-requests-popup").style.display = "block";
			}
			if (!response.success && response.reason == "wrongSignature") {
				signature.value = "";
				wrongSign.style.display = "block";
				defineState();
			}
			if (response.success) {
				localStorage.status = 3;
				localStorage.statusChanged = "yes";
				window.location.replace("/profile");
			}
		} else {
			document.querySelector(".too-many-requests-popup").style.display = "block";
		}

		button.addEventListener("click", verifySignature);
	}
	xhr.send(body);
}

var signature = document.querySelector(".input-address"),
    button = document.querySelector(".continue-button-disabled"),
    wrongSign = document.querySelector(".auth-error");    

signature.addEventListener("input", handleSignature);
button.addEventListener("click", verifySignature);

window.onclick = function(event) {
    if (event.target == document.querySelector(".too-many-requests-popup")) {
        document.querySelector(".too-many-requests-popup").style.display = "none";
    }
}

document.querySelector(".close-too-many-requests-popup").onclick = function() {
    document.querySelector(".too-many-requests-popup").style.display = "none";
}

