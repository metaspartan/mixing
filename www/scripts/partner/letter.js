var button = document.querySelector(".add-incoming-address");

function download() {
	button.onclick = function() {return};
	window.location.href = "/auth/invLetter";
	button.addEventListener("click", download);
}

button.addEventListener("click", download);