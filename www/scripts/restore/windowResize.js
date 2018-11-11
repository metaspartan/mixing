(function() {
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

	document.querySelector(".auth-content").style.visibility = "visible";

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top:    box.top    + pageYOffset,
            bottom: box.bottom + pageYOffset
        };
    }
})();

window.onresize = function() {
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

