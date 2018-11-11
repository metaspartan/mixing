function changeCurrency() {
    if (currency == "BTC") {
        currency = "USD";
        currencySwitch.innerHTML = "Switch to BTC";
        var youSend = inputCalculator.value,
            didYouSendNumber = isNumeric(youSend);

        if (didYouSendNumber) {
            inputCalculator.value = (inputCalculator.value*exchangeRate).toFixed(2);
        }
    } else {
        currency = "BTC";
        currencySwitch.innerHTML = "Switch to USD";
        var youSend = inputCalculator.value,
            didYouSendNumber = isNumeric(youSend);

        if (didYouSendNumber) {
            inputCalculator.value = (inputCalculator.value/exchangeRate).toFixed(8);
        }
    }
    controlDetailsCalculator();
    controlSendCalculator();
}

function controlSendCalculator() {
    var calculatorValues = document.querySelectorAll(".input-receive");
    var actualValues = getCalculator();
    if (currency == "BTC") {
        var afterDots = 8;
    } else {
        var afterDots = 2;
    }
    for (var i = 0; i<inputAddressNumber; i++) {
        if (minimumAcceptedValue !== "NaN" && inputCalculator.value*1 >= minimumAcceptedValue*1) {
            if (actualValues[i] > 0) {
                calculatorValues[i].value = (actualValues[i]).toFixed(afterDots);
            } else {
                calculatorValues[i].value = "";
            }
        } else {
            calculatorValues[i].value = "";
        }
    }
} 

function controlReceiveCalculator() {
    var comission = feeSlider.value/100;
    var inputAddresses = document.querySelectorAll(".input-address");
    var percents = [];
    for (var i = 0; i<inputAddressNumber; i++) {
        percents.push(inputAddresses[i].percent);
    }
    if (currency == "BTC") {
        var afterDots = 8;
    } else {
        var afterDots = 2;
    }

    var inputReceives = document.querySelectorAll(".input-receive");
    var currentPercent = percents[this.index]/100;
    if (currency == "BTC") {
        var outputFee = 140*0.00000001*(satPerByte);
    } else {
        var outputFee = 140*0.00000001*(satPerByte)*exchangeRate;        
    }
    
    if (minimumAcceptedValue !== "NaN" && this.value*1 + outputFee >= (minimumAcceptedValue*(1-comission))*currentPercent*1) {        
        inputCalculator.value = (((this.value*1 + outputFee)/currentPercent)/(1-comission)).toFixed(afterDots);
        var actualValues = getCalculator();
        for (var i = 0; i<inputAddressNumber; i++) {
            if (i != this.index) {
                if (actualValues[i] > 0) {
                    inputReceives[i].value = actualValues[i].toFixed(afterDots);
                } else {
                    inputReceives[i].value = "";
                }
            }
        }
    } else {
        inputCalculator.value = "";
        for (var i = 0; i<inputAddressNumber; i++) {
            if (inputReceives[i].index != this.index) {
                inputReceives[i].value = "";
            }
        }
    }    
}

function getCalculator() {
    var youSend = inputCalculator.value;
    var didYouSendNumber = isNumeric(youSend);
    if (didYouSendNumber && currency == "USD") {
        youSend = youSend/exchangeRate;
    }
    var youReceive = [];
    var comission = feeSlider.value/100;

    if (inputAddressNumber > 1) {
        var inputAddresses = document.querySelectorAll(".input-address");
        var percents = [];
        for (var i = 0; i<inputAddressNumber; i++) {
            percents.push(inputAddresses[i].percent);
        }
    } 

    if (inputAddressNumber == 1) {
        if (didYouSendNumber) {
            if (currency == "BTC") {
                youReceive.push((youSend)*(1-comission) - 140*0.00000001*(satPerByte));
            } else {
                youReceive.push(((youSend)*(1-comission) - 140*0.00000001*(satPerByte))*exchangeRate);
            }            
        } else {
            youReceive.push('');
        } 
    }

    if (inputAddressNumber > 1) {
        for (var i = 0; i < inputAddressNumber; i++) {
            if (didYouSendNumber) {
                if (currency == "BTC") {
                    youReceive.push((youSend*(1-comission))*(percents[i]/100) - 140*0.00000001*(satPerByte));
                } else {
                    youReceive.push(((youSend*(1-comission))*(percents[i]/100) - 140*0.00000001*(satPerByte))*exchangeRate);
                }                
            } else {
                youReceive.push('');
            }
        }   
    }
    return youReceive;
}

function controlDetailsCalculator() {
    var calculatorDetails = document.querySelectorAll(".input-receive-details");
    document.querySelector(".input-send-details").innerHTML = currency;
    actualDetails = getActualDetails();
    for (var i = 0; i<inputAddressNumber; i++) {
        calculatorDetails[i].innerHTML = actualDetails[i];
    };  

    function getActualDetails() {
        var actualDetails  = [];
        var inputAddresses = document.querySelectorAll(".input-address");                  
        var percents       = [];
        var minPercent     = 101;
        for (var i = 0; i<inputAddressNumber; i++) {
            if (inputAddresses[i].percent < minPercent) {
                minPercent = inputAddresses[i].percent;
            }
            percents.push(inputAddresses[i].percent);
        }
        var commission = feeSlider.value/100;        

        if (satPerByte !== "NaN") {
            var outputAddressFee = (satPerByte*140*0.00000001);
            if (currency == "BTC") {
                var afterDots = 8;
            } else {
                var afterDots = 2;
                outputAddressFee = outputAddressFee*exchangeRate;
            }
            
            document.querySelector(".output-address-fee").innerHTML = outputAddressFee.toFixed(afterDots) + " " + currency;
            var currentMin = ((3*140*0.00000001*(satPerByte)*100/minPercent)/(1-commission));
            minimumOfMinimum = ((3*140*0.00000001*(optSatPerByte)*100/minPercent)/(1-commission));
            if (currency == "USD") {
                minimumOfMinimum = minimumOfMinimum*exchangeRate;
                currentMin       = currentMin*exchangeRate;
            }
            minimumAcceptedValue = Math.max(currentMin, minimumOfMinimum).toFixed(afterDots);
            document.querySelector(".minimum-calculator").innerHTML = minimumAcceptedValue + " " + currency;
        } else {
            document.querySelector(".output-address-fee").innerHTML = "";
            minimumAcceptedValue = "NaN";
            document.querySelector(".minimum-calculator").innerHTML = "";
        }

        if (showDelay == 1) {
            var timeDelays = [];
            for (var i = 0; i<inputAddressNumber; i++) {
                timeDelays.push(inputAddresses[i].delay);
            }
        }

        if (showDelay == 0) {
            for (var i = 0; i < inputAddressNumber; i++) {
                actualDetails.push(currency + " (" + percents[i] + "%) right away");
            }   
        }

        if (showDelay == 1) {
            for (var i = 0; i < inputAddressNumber; i++) {
                if (timeDelays[i] == 0) {
                    actualDetails.push(currency + " (" + percents[i] + "%) right away");
                } else {
                    actualDetails.push(currency + " (" + percents[i] + "%) after " + timeDelays[i] + "h");
                }
            }   
        }
        return actualDetails;
    }
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

