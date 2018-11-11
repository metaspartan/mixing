tooltipBitcodeImg.onmouseover = function() {
	var coordinates        = getCoords(this),
		tooltip            = document.querySelector(".bitcode-tooltip-content"),
		tooltipArrow       = document.querySelector(".bitcode-tooltip-arrow");
	tooltip.style.opacity      = 0;
	tooltipArrow.style.opacity = 0;

	if (window.innerWidth < 2800) {
		tooltip.style.width = "170px";
	} else {
		if (window.innerWidth < 5000) {
			tooltip.style.width = "220px";
		} else {
			tooltip.style.width = "280px";
		}
	}
	
	tooltipArrow.style.top  = coordinates.top + 13 + "px";
	tooltipArrow.style.left = coordinates.left - 1 +"px";

	tooltip.style.top  = coordinates.top + 23 + "px";
	if (window.innerWidth > 400) {
		tooltip.style.left = coordinates.left - tooltip.style.width.slice(0,-2)*1/2 + "px";
	} else {
		tooltip.style.left = coordinates.left - tooltip.style.width.slice(0,-2)*1/2 - 45 + "px";
	}
	
	tooltip.style.display = "block";
    tooltipArrow.style.display = "block";	
	var int;
	clearInterval(int);
    var n = 0;
    int = setInterval(function () {
        if (n >= .9) {
            n = 1;
            clearInterval(int);
        }
        n = n + 0.1;
        tooltip.style.opacity = n;
    	tooltipArrow.style.opacity = n;}, 15);	

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top    : box.top    + pageYOffset,
            bottom : box.bottom + pageYOffset,
            left   : box.left   + pageXOffset,
            right  : box.right  + pageXOffset
        };
    }
}

tooltipBitcodeImg.onmouseout = function() {
	var tooltip 	 = document.querySelector(".bitcode-tooltip-content"),
		tooltipArrow = document.querySelector(".bitcode-tooltip-arrow"),
	 	int;
	
	clearInterval(int);
    var n = 1;
    int   = setInterval(function () {
		if (n <= 0.1) {
		  n = 0;
		  clearInterval(int);
		  tooltip.style.display = "none";
		  tooltipArrow.style.display = "none";
		}
		n = n - 0.1;
		tooltip.style.opacity = n;
		tooltipArrow.style.opacity = n;}, 15);
}

tooltipFeeImg.onmouseover = function() {
	var coordinates        = getCoords(this),
		tooltip            = document.querySelector(".fee-tooltip-content"),
		tooltipArrow       = document.querySelector(".fee-tooltip-arrow");
	tooltip.style.opacity      = 0;
	tooltipArrow.style.opacity = 0;

	if (window.innerWidth < 2800) {
		tooltip.style.width = "170px";
	} else {
		if (window.innerWidth < 5000) {
			tooltip.style.width = "220px";
		} else {
			tooltip.style.width = "280px";
		}
	}

	if ((this.getBoundingClientRect().top > window.innerHeight - this.getBoundingClientRect().bottom) && (window.innerHeight - this.getBoundingClientRect().bottom < 118)) {
		tooltip.style.top 			   = "";
		tooltipArrow.style.top 		   = "";
		tooltipArrow.style.bottom      = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 1 + "px";	
		tooltip.style.bottom  		   = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 11 + "px";
		tooltipArrow.style.borderColor = "#232223 transparent transparent transparent";
	} else {
		tooltip.style.bottom 	       = "";
		tooltipArrow.style.bottom      = "";
		tooltipArrow.style.top         = coordinates.top + 15 + "px";
		tooltip.style.top  			   = coordinates.top + 25 + "px";
		tooltipArrow.style.borderColor = "transparent transparent #232223 transparent";
	}

	if (!tooltipFeeImg.discount) {
		if (window.innerWidth > 400) {
			tooltip.style.left      = coordinates.left - tooltip.style.width.slice(0,-2)*1/2 + "px";
			tooltipArrow.style.left = coordinates.left - 1 +"px";
		} else {
			tooltip.style.left      = coordinates.left - tooltip.style.width.slice(0,-2)*1/2 - 45 + "px";
			tooltipArrow.style.left = coordinates.left - 1 +"px";
		}
	} else {
		if (window.innerWidth > 400) {
			tooltip.style.left      = coordinates.left - tooltip.style.width.slice(0,-2)*1/2 + "px";
			tooltipArrow.style.left = coordinates.left + 0 +"px";
		} else {
			tooltip.style.left      = coordinates.left - tooltip.style.width.slice(0,-2)*1/2 - 45 + "px";
			tooltipArrow.style.left = coordinates.left + 0 +"px";
		}
	}
	
	
	tooltip.style.display = "block";
    tooltipArrow.style.display = "block";
	var int;
	clearInterval(int);
    var n = 0;
    int = setInterval(function () {
        if (n >= .9) {
            n = 1;
            clearInterval(int);
        }
        n = n + 0.1;
        tooltip.style.opacity = n;
    	tooltipArrow.style.opacity = n;}, 15);	

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top    : box.top    + pageYOffset,
            bottom : box.bottom + pageYOffset,
            left   : box.left   + pageXOffset,
            right  : box.right  + pageXOffset
        };
    }
}

tooltipFeeImg.onmouseout = function() {
	var tooltip 	 = document.querySelector(".fee-tooltip-content"),
		tooltipArrow = document.querySelector(".fee-tooltip-arrow"),
	 	int;
	
	clearInterval(int);
    var n = 1;
    int   = setInterval(function () {
		if (n <= 0.1) {
		  n = 0;
		  clearInterval(int);
		  tooltip.style.display = "none";
		  tooltipArrow.style.display = "none";
		}
		n = n - 0.1;
		tooltip.style.opacity = n;
		tooltipArrow.style.opacity = n;}, 15);
}

document.querySelector(".satperbyte-th").onmouseover = function() {
	var coordinates        = getCoords(this),
		tooltip            = document.querySelector(".satperbyte-tooltip-content"),
		tooltipArrow       = document.querySelector(".satperbyte-tooltip-arrow");
	tooltip.style.opacity      = 0;
	tooltipArrow.style.opacity = 0;

	if (window.innerWidth < 2800) {
		tooltip.style.width = "170px";
	} else {
		if (window.innerWidth < 5000) {
			tooltip.style.width = "220px";
		} else {
			tooltip.style.width = "280px";
		}
	}

	if ((this.getBoundingClientRect().top > window.innerHeight - this.getBoundingClientRect().bottom) && 
		(window.innerHeight - this.getBoundingClientRect().bottom < 95)) {
		tooltip.style.top 			   = "";
		tooltipArrow.style.top 		   = "";
		tooltipArrow.style.bottom      = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 1 + "px";	
		tooltip.style.bottom  		   = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 11 + "px";
		tooltipArrow.style.borderColor = "#232223 transparent transparent transparent";
	} else {
		tooltip.style.bottom 	       = "";
		tooltipArrow.style.bottom      = "";
		tooltipArrow.style.top         = coordinates.bottom + 1 + "px";
		tooltip.style.top  			   = coordinates.bottom + 11 + "px";	
		tooltipArrow.style.borderColor = "transparent transparent #232223 transparent";
	}


	if (window.innerWidth > 550) {
		tooltip.style.left  = coordinates.left + (coordinates.right - coordinates.left)/2.5 - tooltip.style.width.slice(0,-2)*1/2 + "px";
	} else {
		tooltip.style.left  = coordinates.left + (coordinates.right - coordinates.left)/2.5 - tooltip.style.width.slice(0,-2)*1/4.2 + "px";
	}

	tooltipArrow.style.left = coordinates.left + (coordinates.right - coordinates.left)/2.5 +"px";
	
	
	tooltip.style.display = "block";
    tooltipArrow.style.display = "block";
	var int;
	clearInterval(int);
    var n = 0;
    int = setInterval(function () {
        if (n >= .9) {
            n = 1;
            clearInterval(int);
        }
        n = n + 0.1;
        tooltip.style.opacity = n;
    	tooltipArrow.style.opacity = n;}, 15);	

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top    : box.top    + pageYOffset,
            bottom : box.bottom + pageYOffset,
            left   : box.left   + pageXOffset,
            right  : box.right  + pageXOffset
        };
    }
}

document.querySelector(".satperbyte-th").onmouseout = function() {
	var tooltip 	 = document.querySelector(".satperbyte-tooltip-content"),
		tooltipArrow = document.querySelector(".satperbyte-tooltip-arrow"),
	 	int;
	
	clearInterval(int);
    var n = 1;
    int   = setInterval(function () {
		if (n <= 0.1) {
		  n = 0;
		  clearInterval(int);
		  tooltip.style.display = "none";
		  tooltipArrow.style.display = "none";
		}
		n = n - 0.1;
		tooltip.style.opacity = n;
		tooltipArrow.style.opacity = n;}, 15);
}

document.querySelector(".output-address-fee-th").onmouseover = function() {
	var coordinates        = getCoords(this),
		tooltip            = document.querySelector(".output-address-fee-tooltip-content"),
		tooltipArrow       = document.querySelector(".output-address-fee-tooltip-arrow");
	tooltip.style.opacity      = 0;
	tooltipArrow.style.opacity = 0;

	if (window.innerWidth < 2800) {
		tooltip.style.width = "170px";
	} else {
		if (window.innerWidth < 5000) {
			tooltip.style.width = "220px";
		} else {
			tooltip.style.width = "280px";
		}
	}

	if ((this.getBoundingClientRect().top > window.innerHeight - this.getBoundingClientRect().bottom) && (window.innerHeight - this.getBoundingClientRect().bottom < 100)) {
		tooltip.style.top 			   = "";
		tooltipArrow.style.top 		   = "";
		tooltipArrow.style.bottom      = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 1 + "px";	
		tooltip.style.bottom  		   = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 11 + "px";
		tooltipArrow.style.borderColor = "#232223 transparent transparent transparent";
	} else {
		tooltip.style.bottom 	       = "";
		tooltipArrow.style.bottom      = "";
		tooltipArrow.style.top         = coordinates.bottom + 1 + "px";
		tooltip.style.top  			   = coordinates.bottom + 11 + "px";
		tooltipArrow.style.borderColor = "transparent transparent #232223 transparent";
	}


	tooltip.style.left      = coordinates.left + (coordinates.right - coordinates.left)/2.2 - tooltip.style.width.slice(0,-2)*1/2 + "px";
	tooltipArrow.style.left = coordinates.left + (coordinates.right - coordinates.left)/2.2 +"px";
	
	tooltip.style.display = "block";
    tooltipArrow.style.display = "block";
	var int;
	clearInterval(int);
    var n = 0;
    int = setInterval(function () {
        if (n >= .9) {
            n = 1;
            clearInterval(int);
        }
        n = n + 0.1;
        tooltip.style.opacity = n;
    	tooltipArrow.style.opacity = n;}, 15);	

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top    : box.top    + pageYOffset,
            bottom : box.bottom + pageYOffset,
            left   : box.left   + pageXOffset,
            right  : box.right  + pageXOffset
        };
    }
}

document.querySelector(".output-address-fee-th").onmouseout = function() {
	var tooltip 	 = document.querySelector(".output-address-fee-tooltip-content"),
		tooltipArrow = document.querySelector(".output-address-fee-tooltip-arrow"),
	 	int;
	
	clearInterval(int);
    var n = 1;
    int   = setInterval(function () {
		if (n <= 0.1) {
		  n = 0;
		  clearInterval(int);
		  tooltip.style.display = "none";
		  tooltipArrow.style.display = "none";
		}
		n = n - 0.1;
		tooltip.style.opacity = n;
		tooltipArrow.style.opacity = n;}, 15);
}

document.querySelector(".minimum-calculator-th").onmouseover = function() {
	var coordinates        = getCoords(this),
		tooltip            = document.querySelector(".minimum-calculator-tooltip-content"),
		tooltipArrow       = document.querySelector(".minimum-calculator-tooltip-arrow");
	tooltip.style.opacity      = 0;
	tooltipArrow.style.opacity = 0;

	if (window.innerWidth < 2800) {
		tooltip.style.width = "170px";
	} else {
		if (window.innerWidth < 5000) {
			tooltip.style.width = "220px";
		} else {
			tooltip.style.width = "280px";
		}
	}

	if ((this.getBoundingClientRect().top > window.innerHeight - this.getBoundingClientRect().bottom) && (window.innerHeight - this.getBoundingClientRect().bottom < 110)) {
		tooltip.style.top 			   = "";
		tooltipArrow.style.top 		   = "";
		tooltipArrow.style.bottom      = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 1 + "px";	
		tooltip.style.bottom  		   = window.innerHeight - this.getBoundingClientRect().top - pageYOffset + 11 + "px";
		tooltipArrow.style.borderColor = "#232223 transparent transparent transparent";
	} else {
		tooltip.style.bottom 	       = "";
		tooltipArrow.style.bottom      = "";
		tooltipArrow.style.top         = coordinates.bottom + 1 + "px";
		tooltip.style.top  			   = coordinates.bottom + 11 + "px";
		tooltipArrow.style.borderColor = "transparent transparent #232223 transparent";
	}

	if (window.innerWidth > 550) {
		tooltip.style.left  = coordinates.left + (coordinates.right - coordinates.left)/2.5 - tooltip.style.width.slice(0,-2)*1/2 + "px";
	} else {
		tooltip.style.left  = coordinates.left + (coordinates.right - coordinates.left)/2.5 - tooltip.style.width.slice(0,-2)*3.2/4.2 + "px";
	}

	tooltipArrow.style.left = coordinates.left + (coordinates.right - coordinates.left)/2.5 +"px";
	
	tooltip.style.display = "block";
    tooltipArrow.style.display = "block";
	var int;
	clearInterval(int);
    var n = 0;
    int = setInterval(function () {
        if (n >= .9) {
            n = 1;
            clearInterval(int);
        }
        n = n + 0.1;
        tooltip.style.opacity = n;
    	tooltipArrow.style.opacity = n;}, 15);	

	function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top    : box.top    + pageYOffset,
            bottom : box.bottom + pageYOffset,
            left   : box.left   + pageXOffset,
            right  : box.right  + pageXOffset
        };
    }
}

document.querySelector(".minimum-calculator-th").onmouseout = function() {
	var tooltip 	 = document.querySelector(".minimum-calculator-tooltip-content"),
		tooltipArrow = document.querySelector(".minimum-calculator-tooltip-arrow"),
	 	int;
	
	clearInterval(int);
    var n = 1;
    int   = setInterval(function () {
		if (n <= 0.1) {
		  n = 0;
		  clearInterval(int);
		  tooltip.style.display = "none";
		  tooltipArrow.style.display = "none";
		}
		n = n - 0.1;
		tooltip.style.opacity = n;
		tooltipArrow.style.opacity = n;}, 15);
}

