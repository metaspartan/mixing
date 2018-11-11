var popupButton = document.querySelector(".continue-button"),
	deleteButton = document.querySelector(".accept-button"),
	confirmPopup = document.querySelector("#confirm-popup"),
    closeConfirmPopup = document.querySelector("#close-confirm-popup"),
    errorPopup = document.querySelector("#error-popup"),
    closeErrorPopup = document.querySelector("#close-error-popup"),
    deleteSuccess = document.querySelector("#delete-success"),
    timer = document.querySelector("#timer"),
    load = document.querySelector(".load-in-progress");

popupButton.addEventListener("click", function() {
	confirmPopup.style.display = "block";
});

deleteButton.addEventListener("click", function() {
	confirmPopup.style.display = "none";
	load.style.display = "block";

	var boundary       = String(Math.random()).slice(2),
		boundaryMiddle = '--' + boundary + '\r\n',
		boundaryLast   = '--' + boundary + '--\r\n';

	var body = ['\r\n'];

	body.push('Content-Disposition: form-data; name="codeword"\r\n\r\nkokoko\r\n');
	body = body.join(boundaryMiddle) + boundaryLast;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/operation/deleteTakeaway', true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
	xhr.onreadystatechange = function() {
		if (this.readyState != 4) return;
		load.style.display = "none";
		if (this.status === 200) {
			var response = JSON.parse(this.responseText);
			if (!response.success && response.reason == "permissions") {
				window.location.replace("/403");
			}
			if (!response.success && response.reason == "internal") {
				errorPopup.style.display = "block";
			}
			if (response.success) {
				deleteSuccess.style.display = "block";
				setInterval(function() {
					timer.innerHTML = timer.innerHTML*1 - 1;
				}, 1000);
				setTimeout(function() {
					window.location.replace("/profile");
				}, 3000);
			}
		} else {
			errorPopup.style.display = "block";
		}
	}
	xhr.send(body);
});

window.addEventListener("click", function(event) {
    if (event.target == confirmPopup) {
        confirmPopup.style.display = "none";
    }
    if (event.target == errorPopup) {
        errorPopup.style.display = "none";
    }
});

closeConfirmPopup.addEventListener("click", function() {
    confirmPopup.style.display = "none";
});

closeErrorPopup.addEventListener("click", function() {
    errorPopup.style.display = "none";
});

