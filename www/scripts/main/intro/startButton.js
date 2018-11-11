document.querySelector(".start-button").onclick = function() {
	if (error429) {window.location.replace("/429"); return;}
	if (error500) {window.location.replace("/500"); return;}
	document.querySelector(".intro").style.display = "none";
	document.querySelector(".start").style.display = "block";
	start = true;
	if (!feeSlider.activated) {		
		makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");
		feeSlider.activated = true;
	} else {
		makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "min");
	}
	controlDetailsCalculator();
	var hrefs = document.querySelectorAll("a[href]:not(.signingout)");

	for (var i = 0; i < hrefs.length; i++) {
		hrefs[i].addEventListener("click", function(e) {
			e.preventDefault();
			var inputAddresses = document.querySelectorAll(".input-address");
			for (var i = 0; i<inputAddresses.length; i++) {
				if (inputAddresses[i].value) {
					document.querySelector("#leave-ref").href = this.href;
					document.querySelector(".status-error-popup").style.display = "block";
					return;
				}
			}
			window.location.href = (this.href);
		});
	}
}

