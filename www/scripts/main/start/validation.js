function validateInputAddress() {
    if (!isValid(this.value)) {
        if (inputAddressNumber > 1) {
	        this.style.border = "1px solid " + colorError;
			this.onfocus = function(){
				this.style.border = "1px solid " + colors[this.index];
			    this.style.boxShadow = "inset 0 0 5px " + colors[this.index];
			}
			this.onblur = function(){
				this.style.border = "1px solid " + colorError;
			    this.style.boxShadow = "none";
			}
		} else {
			this.style.border = "1px solid " + colorError;
			this.onfocus = function(){
				this.style.border = "1px solid " + colorDefault;
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			}
			this.onblur = function(){
				this.style.border = "1px solid " + colorError;
			    this.style.boxShadow = "none";
			}
		}
    } else {
    	if (inputAddressNumber > 1) {
	        this.style.border = "1px solid " + colors[this.index];
			this.onfocus = function(){
			    this.style.boxShadow = "inset 0 0 5px " + colors[this.index];
			}
			this.onblur = function(){
			    this.style.boxShadow = "none";
			}
		} else {
			this.style.border = "1px solid " + colorDefault;
			this.onfocus = function(){
			    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
			}
			this.onblur = function(){
			    this.style.boxShadow = "none";
			}
		}
    }    
}

function backToNormalColorAddress() {
	if (inputAddressNumber > 1) {
        this.style.border = "1px solid " + colors[this.index];
        this.style.boxShadow = "inset 0 0 5px " + colors[this.index];
	} else {
		this.style.border = "1px solid " + colorDefault;
        this.style.boxShadow = "inset 0 0 5px " + colorDefault;
	}
	defineState();
}

function isBitcodeCorrect() {
	var bitcode = bitcodeInput.value,
		lettersForBitcode = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789";

	if (bitcode != "") {
		if (bitcode.length != 6) {return false;}
		for (var i = 0; i<bitcode.length; i++) {
			if (lettersForBitcode.indexOf(bitcode[i]) < 0) {
				return false;
			}
		}
	}
	return true;
}

function generalValidity() {
	if (!isBitcodeCorrect()) {return false;}
	var inputAddresses = document.querySelectorAll(".input-address"), S = 0;
	if (inputAddresses.length > 10) {return false;}
	if (feeSlider.value  <  feeMin) {return false;}
	for (var i = 0; i < inputAddresses.length; i++) {
		if (inputAddresses[i].value == '' || onlySpaces(inputAddresses[i].value) || !isValid(inputAddresses[i].value)) {
			return false;
		}
		if (typeof(inputAddresses[i].delay) != "number") {
			return false;
		} else {
			if (inputAddresses[i].delay < 0 || inputAddresses[i].delay > 48 || !isInt(inputAddresses[i].delay)) {
				return false;
			}
		} 
		if (typeof(inputAddresses[i].percent) != "number") {
			return false;
		} else {
			if (inputAddresses.length > 1) {
				if (inputAddresses[i].percent < 1 || inputAddresses[i].percent > 99 || !isInt(inputAddresses[i].percent)) {
					return false;
				} 
			} else {
				if (inputAddresses[i].percent != 100) {
					return false;
				}
			}
		}
		S += inputAddresses[i].percent;
	}
	if (S != 100) {
		return false;
	}

	for (i = 0; i<inputAddresses.length; i++) {
		for (var j = i+1; j<inputAddresses.length; j++) {
			if (withoutSpaces(inputAddresses[i].value) == withoutSpaces(inputAddresses[j].value)) {
				return false;
			}
		}
	}
    return true;

    function withoutSpaces(str) {
    	var startSpace = 0, endSpace = 0;
		for (var i = 0; i < str.length; i++) {
			if (str[i] == ' ') {startSpace++} else {break;}
		}
		for (var i = str.length-1; i >= 0; i--) {
			if (str[i] == ' ') {endSpace++} else {break;}
		}
		return str.substring(startSpace, str.length-endSpace);
	}	

    function onlySpaces(str) {
		for (var i = 0; i < str.length; i++) {
			if (str[i] != ' ') {return false;}
		}
		return true;
	}	

	function isInt(value) {
		return typeof value === "number"
		              && Number.isFinite(value)
		              && !(value % 1);
	}
}

function defineState() {
	if (start) {
		if (!generalValidity()) {       
	        continueButton.className = "continue-button-disabled";
	        continueButton.onclick = continueDisabled;
	    } else {
	        continueButton.className = "continue-button";
	        if (!lsTest()) {
	        	continueButton.onclick = continueAsk;
	        } else {
		        if (typeof localStorage.dontAsk === "undefined") {
		            continueButton.onclick = continueAsk;
		        } else {
		            continueButton.onclick = continueMix;
		        }
		    }
	    }
	} else {
		continueButton.className = "continue-button-disabled";
	    continueButton.onclick = continueDisabled;
	}
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

