var bitcodeInput            = document.querySelector(      ".input-bitcode"     ),
	tooltipBitcodeImg       = document.querySelector(     ".question-bitcode"   ),
    inputForm               = document.querySelector(       ".mix-content"      ),
	addAddressButton        = document.querySelector(       ".add-address"      ),
	inputAddress            = document.querySelector(      ".input-address"     ),
	feeSlider               = document.querySelector(       ".fee-slider"       ),
	feeAmount               = document.querySelector(       ".fee-amount"       ),
	tooltipFeeImg           = document.querySelector(      ".question-fee"      ),
	delayContent            = document.querySelector(         ".delay"          ),
	timeSlider              = document.querySelector(    ".time-delay-slider"   ),
	timeDelay               = document.querySelector(     ".time-delay-value"   ),
	addDelayButton          = document.querySelector(        ".add-delay"       ),
	percentageDistribution  = document.querySelector(        ".percentage"      ),
	percentageValue         = document.querySelector(     ".percentage-value"   ),
	sendBlockCalculator     = document.querySelector(  ".send-block-calculator" ),
	inputCalculator         = document.querySelector(      ".input-send"        ),
	receiveBlockCalculator  = document.querySelector(".receive-block-calculator"),
	inputReceive            = document.querySelector(     ".input-receive"      ),
	currencySwitch          = document.querySelector(    ".currency-switch"     ),
	inputReceiveDetails     = document.querySelector(  ".input-receive-details" );

	bitcodeInput.    		  addEventListener("input" ,      handleBitcode      );
	addAddressButton.		  addEventListener("click" ,        addAddress       );
	addDelayButton.  		  addEventListener("click" ,      controlDelay       );
	inputAddress.    		  addEventListener("change",   validateInputAddress  );
	inputAddress.    		  addEventListener("input" , backToNormalColorAddress);
	inputCalculator. 		  addEventListener("input" ,   controlSendCalculator );
	inputReceive.    		  addEventListener("input" , controlReceiveCalculator);
	currencySwitch.           addEventListener("click" ,     changeCurrency      );

document.querySelector(".input-miner-rate").oninput = function() {
	if (isNumeric(this.value) && this.value > 0) {
		satPerByte = Math.ceil(this.value);
		this.value = satPerByte;
	} else {
		satPerByte = "NaN";
	}
	controlDetailsCalculator();
	controlSendCalculator();
}

document.querySelector(".input-miner-rate").onblur = function() {
	if (isNumeric(this.value) && this.value > 0) {
		satPerByte = Math.ceil(this.value);
		this.value = satPerByte;
	} else {
		this.value = optSatPerByte;
		satPerByte = optSatPerByte;
	}
	controlDetailsCalculator();
	controlSendCalculator();
}

var colors                   = ["#5a85ce", 
								"#3dc688", 
								"#36c1b8", 
								"#7aed50", 
								"#46995c", 
								"#b2b150", 
								"#dbcb55", 
								"#e8a035", 
								"#e86d35", 
								"#bc84b4"],
    colorDefault             =  "#729fa0",
    colorError               =  "#ff0033",
    colorDiscount            =  "#39b569",
    colorFeeSlider           =  "#848cbc",
	order                    =         {},
	start                    =      false,
	error500                 =      false,
	error429                 =      false,
	incomingAddressesNumber  =          0,
	maxIncomingAddresses     =          5,
	inputAddressNumber       =          1,
	maxNumberOfInputs        =         10,
	feeMin                   =        0.5,
	feeMax                   =          3,
	feeStep                  =     0.0001,
	timeDelayMin             =          0,
	timeDelayMax             =         48,
	timeDelayStep            =          1,
	showDelay                =          0,
	customMiner              =          0,
	satPerByte               =      "NaN",
	optSatPerByte            =      "NaN",
	minimumAcceptedValue     =      "NaN",
	minimumOfMinimum         =      "NaN",
	bitcodeBanTimes          =          0,
	currency                 =      "BTC",
	exchangeRate             =      "NaN",
	TESTNET                  =       true,
	percentStep              =          1;
	inputReceive.index       =          0;
	feeSlider.activated      =      false;
	inputAddress.index       =          0;
	inputAddress.delay       =          0;
	inputAddress.percent     =        100;
	timeDelay.style.display  =     "none";

if (lsTest() && localStorage.bitwhiskcode !== undefined) {
	bitcodeInput.value = localStorage.bitwhiskcode;
	var inputEvent = document.createEvent("HTMLEvents");
    inputEvent.initEvent('input', true, true);
    bitcodeInput.dispatchEvent(inputEvent);
    var blurEvent = document.createEvent("HTMLEvents");
    blurEvent.initEvent('blur', true, true);
    bitcodeInput.dispatchEvent(blurEvent);
}

(function() {
	var boundary       = String(Math.random()).slice(2);
	var boundaryMiddle = '--' + boundary + '\r\n';
	var boundaryLast   = '--' + boundary + '--\r\n';
	var body = ['\r\n'];
		body.push('Content-Disposition: form-data; name="codeword"\r\n\r\n'+ 'sayhi'+ '\r\n');

	body = body.join(boundaryMiddle) + boundaryLast;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/operation/currentInfo', true);
	xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);

	xhr.onreadystatechange = function() {		
		if (this.readyState != 4) return;
		if (xhr.status === 200) {
			var response = JSON.parse(this.responseText);
			satPerByte = response.minerRate*1;
			optSatPerByte = satPerByte;
			document.querySelector(".input-miner-rate").value = satPerByte;
			document.querySelector(".optimal-miner-rate").innerHTML = optSatPerByte;		
			document.querySelector(".miner-fee-summary").style.display = "block";
			exchangeRate = response.exchangeRate*1;
			document.querySelector(".exchange-rate").innerHTML = exchangeRate;
			controlDetailsCalculator();		
		} else {
			if (xhr.status === 429) {
				if (start) {window.location.replace("/429");} else {error429 = true;}
			} else {
				if (start) {window.location.replace("/500");} else {error500 = true;}
			}			
		}
	}
	xhr.send(body);
})();

