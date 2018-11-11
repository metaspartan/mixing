document.querySelector(".close-popup").onclick = function() {
    document.querySelector(".accept-popup").style.display = "none";
}

document.querySelector(".close-status-error-popup").onclick = function() {
    document.querySelector(".status-error-popup").style.display = "none";
}

document.querySelector(".close-high-min-income-error-popup").onclick = function() {
    document.querySelector(".high-min-income-error-popup").style.display = "none";
}

document.querySelector(".close-no-coins-error-popup").onclick = function() {
    document.querySelector(".no-coins-error-popup").style.display = "none";
}

document.querySelector(".close-too-many-requests-popup").onclick = function() {
    document.querySelector(".too-many-requests-popup").style.display = "none";
    setTimeout(function() {bitcodeInput.disabled = "";}, 5000*bitcodeBanTimes);
}

window.onclick = function(event) {
    if (event.target == document.querySelector(".accept-popup")) {
        document.querySelector(".accept-popup").style.display = "none";
    }
    if (event.target == document.querySelector(".high-min-income-error-popup")) {
        document.querySelector(".high-min-income-error-popup").style.display = "none";
    }
    if (event.target == document.querySelector(".no-coins-error-popup")) {
        document.querySelector(".no-coins-error-popup").style.display = "none";
    }
    if (event.target == document.querySelector(".too-many-requests-popup")) {
        document.querySelector(".too-many-requests-popup").style.display = "none";
        setTimeout(function() {bitcodeInput.disabled = "";}, 5000*bitcodeBanTimes);
    }
    if (event.target == document.querySelector(".status-error-popup")) {
        document.querySelector(".status-error-popup").style.display = "none";
    }
}

var dontAskButton = document.querySelector(".do-not-ask-check");
dontAskButton.showPopup = true;
dontAskButton.onclick = function(event) {
	if (event.target.tagName == "INPUT") {
		dontAskButton.showPopup = !dontAskButton.showPopup;
	}	
}

document.querySelector(".accept-button").onclick = function() {
	if (!generalValidity() || !start) {
		return;
	} else {
		if (lsTest() && !dontAskButton.showPopup) {
			localStorage.dontAsk = true;
		}
		continueMix();
	}
}

var continueButton = document.querySelector(".continue-button-disabled");

function continueDisabled() {return;}

function continueAsk() {
	if (lsTest()) {
		document.querySelector(  ".accept-popup"  ).style.display = "block";
	} else {
		document.querySelector(  ".accept-popup"  ).style.display = "block";
		document.querySelector(".do-not-ask-check").style.display = "none";
	}
}

function continueMix() {
	if (generalValidity() && start) {
		continueButton.onclick   = continueDisabled;
		continueButton.className = "continue-button-disabled";
		document.querySelector(  ".accept-popup"  ).style.display = "none";
		document.querySelector(".load-in-progress").style.display = "block";

		var feeSlider      = document.querySelector   (  ".fee-slider" ),
		    inputAddresses = document.querySelectorAll(".input-address");	

		order.minerRate       = satPerByte;
		order.outputAddresses = "";
		order.delay           = "";
		order.distribution    = "";

		for (var i = 0; i<inputAddressNumber-1; i++) {
			order.outputAddresses += smartLowerCaseTransform(withoutSpaces(inputAddresses[i].value)) + ";";
			order.delay           +=               inputAddresses[i].delay  + ";";
			order.distribution    +=              inputAddresses[i].percent + ";";
		}

		order.outputAddresses += smartLowerCaseTransform(withoutSpaces(inputAddresses[i].value));
		order.delay           += inputAddresses[i].delay;
		order.distribution    += inputAddresses[i].percent
		order.commission       = feeSlider.value;

		if (bitcodeInput.value != "") {
			order.code = bitcodeInput.value;
		}

		var boundary       = String(Math.random()).slice(2),
			boundaryMiddle = '--' + boundary + '\r\n',
			boundaryLast   = '--' + boundary + '--\r\n';

		var body = ['\r\n'];
		for (var key in order) {
			body.push('Content-Disposition: form-data; name="' + key + '"\r\n\r\n' + order[key] + '\r\n');
		}

		body = body.join(boundaryMiddle) + boundaryLast;

		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/operation/handleClientOrder', true);

		xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);

		xhr.onreadystatechange = function() {		
			if (this.readyState != 4) return;	

			if (xhr.status === 200) {
				if (this.responseText === "Incorrect order") {
					document.querySelector(".load-in-progress").style.display = "none";
					document.querySelector(     ".error"      ).style.display = "block";
				} else {
					document.querySelector(".load-in-progress").style.display = "none";
					document.querySelector(     ".error"      ).style.display = "none";

					var response = JSON.parse(this.responseText);

					if (response["orderStatus"] == "tooHighMinIncome") {
						order = {};
						if (typeof localStorage.dontAsk == "undefined") {						
							continueButton.onclick = continueAsk;
						} else {
							continueButton.onclick = continueMix;
						}					
						continueButton.className = "continue-button";
						document.querySelector(".high-min-income-error-popup").style.display = "block";
						document.querySelector(".high-min-income-error-popup-min").innerHTML = response["minimumIncome"].toFixed(8) + " BTC";
						document.querySelector(".high-min-income-error-popup-max").innerHTML = response["balance"].toFixed(8) + " BTC";
					}

					if (response["orderStatus"] == "noAvailableCoins") {
						order = {};
						if (typeof localStorage.dontAsk == "undefined") {						
							continueButton.onclick = continueAsk;
						} else {
							continueButton.onclick = continueMix;
						}					
						continueButton.className = "continue-button";
						bitcodeInput.value = "";
						document.querySelector(".no-coins-error-popup").style.display = "block";
					}

					if (response["orderStatus"] == "somethingWrong") {
						window.location.replace("/500");
					}

					if (response["orderStatus"] == "OK") {
						var newLi 	      = document.createElement("li"),
					    newSpan 	      = document.createElement("span");
						order.code        = response["code"];
						
						newLi.className   = "el-list-incoming";			
						newSpan.className = "generated-address";

						newSpan.minimum   = response["minimumIncome"].toFixed(8);
						newSpan.address   = response[ "newAddress"  ];
						newSpan.letter    = response[   "letter"    ];

						newSpan.success   = false;
						newSpan.active    = true;
						newSpan.innerHTML = newSpan.address;

						newSpan.onmouseover = function() {
							if (this.active) {
								this.style.cursor = "text";
							} else {
								this.style.color  = "#EBE8E8";
								this.style.cursor = "pointer";
							}
						}

						newSpan.onmouseout = function() {
							if (this.active) {return;}
							else {
								this.style.color  = "#0d1111";
								this.style.cursor = "text";
							}
						}

						newSpan.onclick = function() {
							if (this.active) {return;}
							if (this.success) {
								document.querySelector(".qr-img").src = "/images/success.svg";
							} else {
								document.querySelector(".qr-img").src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=" + this.address;	
							}				
							var incomingAddresses = document.querySelectorAll(".generated-address");
							for (var i = 0; i<incomingAddresses.length; i++) {
								incomingAddresses[i].active      = false;
								incomingAddresses[i].style.color = "#0d1111";
							}
							this.style.cursor = "text";
							this.style.color = "#EBE8E8";
							this.active = true;
							if (document.querySelector(".minimum") !== null) {
								document.querySelector(".minimum").innerHTML = this.minimum;
							}							
						}
						
						document.querySelector(".list-incoming").appendChild(newLi);
						newLi.appendChild(newSpan);

						var letterInside  = document.querySelector(".letter-inside");
						window.URL 		  = window.URL || window.webkitURL;
						letterInside.href = window.URL.createObjectURL(new Blob([newSpan.letter], {type: "text/plain"}));

						document.querySelector(    ".qr-img"   ).src        = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=" + newSpan.address;
						document.querySelector(   ".minimum"   ).innerHTML  = newSpan.minimum;
						document.querySelector(   ".maximum"   ).innerHTML  = response["balance"].toFixed(8);
						document.querySelector(".bitcode-value").innerHTML  = response["code"];
						if (lsTest()) {
							localStorage.bitwhiskcode = response["code"];
						}

						document.querySelector(  ".start"   ).style.display = "none";
						document.querySelector(".order-done").style.display = "block";

						start = false;
						document.querySelector(".add-incoming-address").onclick = addNewIncomingAddress;
						defineState();			
						incomingAddressesNumber++;

						document.querySelector(".mix-page-content").removeChild(document.querySelector(".continue-button-parent"));
					}				
				}
			} else {
				if (xhr.status === 429) {
					window.location.replace("/429");
				} else {
					window.location.replace("/500");
				}				
			}      
		}
		xhr.send(body);
	}

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

	function smartLowerCaseTransform(address) {
		if (TESTNET) {
			if (address[0] == "m" || address[0] == "n" || address[0] == "2") {
				return address;
			} else {
				return address.toLowerCase();
			}
		} else {
			if (address[0] == "1" || address[0] == "3") {
				return address;
			} else {
				return address.toLowerCase();
			}
		}
	}
}

function handleBitcode() {
	var standardTooltipText = "It is very important to set arbitrary service commission to prevent amount-based blockchain analysis. " + 
                              "See FAQ for details.<br><br>" +
                              "If you use BitWhisk often, you get the discount. See Fees for details.",
    	discountTooltipText = "You've got the discount!<br>" +
                              "Thank you for using BitWhisk.";                          	  

	if (bitcodeInput.value == "") {		
		defaultStyle();
		tooltipFeeImg.discount = false;
		if (feeMin < .5) {			
			feeMin = .5;
			document.querySelector(".fee-tooltip-content").innerHTML = standardTooltipText;	
			tooltipFeeImg.src = "/images/question-mark-gray.svg";
			makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");
		}		
		defineState();
	} 
	if (!isBitcodeCorrect()) {
		errorStyle();
		tooltipFeeImg.discount = false;		
		if (feeMin < .5) {			
			feeMin = .5;
			document.querySelector(".fee-tooltip-content").innerHTML = standardTooltipText;	
			tooltipFeeImg.src = "/images/question-mark-gray.svg";
			makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");
		}
		defineState();
	} 
	if (isBitcodeCorrect() && bitcodeInput.value != "") {
		var boundary       = String(Math.random()).slice(2);
		var boundaryMiddle = '--' + boundary + '\r\n';
		var boundaryLast   = '--' + boundary + '--\r\n';

		var body = ['\r\n'];
			body.push('Content-Disposition: form-data; name="code"\r\n\r\n' + bitcodeInput.value + '\r\n');

		body = body.join(boundaryMiddle) + boundaryLast;
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/operation/handleBitcode', true);
		xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);

		xhr.onreadystatechange = function() {		
			if (this.readyState != 4) {return};
			if (xhr.status === 200) {
				var discount = this.responseText*1;
				if (discount > 0) {
					if (.5-discount != feeMin) {
						feeMin = .5 - discount;
						tooltipFeeImg.discount = true;
						discountStyle();
						document.querySelector(".fee-tooltip-content").innerHTML = discountTooltipText;	
						tooltipFeeImg.src = "/images/info-discount.svg";
						if (feeSlider.activated == true) {				
							makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "min");
						} else {
							feeSlider.activated = true;
						}
					}
				} else {
					defaultStyle();	
					tooltipFeeImg.discount = false;				
					if (feeMin < .5) {						
						document.querySelector(".fee-tooltip-content").innerHTML = standardTooltipText;	
						tooltipFeeImg.src = "/images/question-mark-gray.svg";					
						feeMin = .5;
						makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");
					}
				}
				defineState();
			} else {
				if (xhr.status === 429) {
					if (start) {
						document.querySelector(".too-many-requests-popup").style.display = "block";
						bitcodeInput.value = "";						
						defaultStyle();
						bitcodeInput.blur();
						bitcodeInput.boxShadow = "none";
						bitcodeBanTimes += 1;
						bitcodeInput.disabled = "true";							
						tooltipFeeImg.discount = false;				
						if (feeMin < .5) {						
							document.querySelector(".fee-tooltip-content").innerHTML = standardTooltipText;	
							tooltipFeeImg.src = "/images/question-mark-gray.svg";					
							feeMin = .5;
							makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");
						}												
					} else {
						bitcodeInput.value = "";
						defaultStyle();	
						tooltipFeeImg.discount = false;				
						if (feeMin < .5) {						
							document.querySelector(".fee-tooltip-content").innerHTML = standardTooltipText;	
							tooltipFeeImg.src = "/images/question-mark-gray.svg";					
							feeMin = .5;
							makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");
						}
						error429 = true;
					}
				} else {
					if (start) {window.location.replace("/500");} else {error500 = true;}
				}
				defineState();
			}
		}
		xhr.send(body);
	}

	function discountStyle() {
		bitcodeInput.style.border = "1px solid " + colorDiscount;
		if (start) {
			bitcodeInput.style.boxShadow = "inset 0 0 5px " + colorDiscount;
		}
		bitcodeInput.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDiscount;
		}
		bitcodeInput.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function defaultStyle() {
		bitcodeInput.style.border = "1px solid " + colorDefault;
		if (start) {
			bitcodeInput.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}		
		bitcodeInput.onfocus = function(){
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		bitcodeInput.onblur = function(){
		    this.style.boxShadow = "none";
		}
	}

	function errorStyle() {
		bitcodeInput.style.border = "1px solid " + colorDefault;
		bitcodeInput.style.boxShadow = "inset 0 0 5px " + colorDefault;
		bitcodeInput.onfocus = function(){
			bitcodeInput.style.border = "1px solid " + colorDefault;
		    this.style.boxShadow = "inset 0 0 5px " + colorDefault;
		}
		bitcodeInput.onblur = function(){
			bitcodeInput.style.border = "1px solid " + colorError;
		    this.style.boxShadow = "none";
		}
	}
}

