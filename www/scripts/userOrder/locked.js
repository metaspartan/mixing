var address1 = document.querySelector("#address1"),
	address2 = document.querySelector("#address2"),
	qrIMG = document.querySelector(".qr-img"),
	letterbutton = document.querySelector(".add-incoming-address");

address1.onclick = function() {
	if (address1.classList.contains("unclickable-address")) {
		return;
	}
	toggleAddresses(1);
}

address2.onclick = function() {
	if (address2.classList.contains("unclickable-address")) {
		return;
	}
	toggleAddresses(2);
}

letterbutton.addEventListener("click", downloadLetter);

function toggleAddresses(number) {
	if (number === 1) {
		address1.classList.remove("clickable-address");
		address1.classList.add("unclickable-address");
		address2.classList.remove("unclickable-address");
		address2.classList.add("clickable-address");
		qrIMG.src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=" + address1.innerHTML;
	} else if (number === 2) {
		address1.classList.remove("unclickable-address");
		address1.classList.add("clickable-address");
		address2.classList.remove("clickable-address");
		address2.classList.add("unclickable-address");
		qrIMG.src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=" + address2.innerHTML;
	}
}

function downloadLetter() {
	letterbutton.onclick = function() {return};
	window.location.href = "/auth/letterTakeaway";
	letterbutton.addEventListener("click", downloadLetter);
}

