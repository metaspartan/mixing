function addAddress(event) {
    if (inputAddressNumber < maxNumberOfInputs) {
        percentageValue.style.display = "block";
        if (inputAddressNumber == 1) {
            document.querySelector(".sliders").style.marginTop = "-7px";
        }
        var inputAddresses = document.querySelectorAll(".input-address");
        for (var i = 0; i<inputAddressNumber; i++) {  
            if (isValid(inputAddresses[i].value)) {
                inputAddresses[i].style.border = "1px solid " + colors[inputAddresses[i].index];
                inputAddresses[i].onfocus = function(){
                    this.style.boxShadow = "inset 0 0 5px " + colors[this.index];
                }
                inputAddresses[i].onblur = function(){
                    this.style.boxShadow = "none";
                }
            } else {
                inputAddresses[i].style.border = "1px solid " + colorError;
                inputAddresses[i].onfocus = function(){
                    this.style.border = "1px solid " + colors[this.index];
                    this.style.boxShadow = "inset 0 0 5px " + colors[this.index];
                }
                inputAddresses[i].onblur = function(){
                    this.style.border = "1px solid " + colorError;
                    this.style.boxShadow = "none";
                }
            }
        }
        
        var newInputBlock       = document.createElement("div");
        newInputBlock.className = "mix-address";

        var newRemoveButton       = document.createElement("img");
        newRemoveButton.className = "remove-address";
        newRemoveButton.src       = "images/remove.svg";
        newInputBlock.appendChild(newRemoveButton);
        newRemoveButton.addEventListener("click", removeAddress);   

        var newInputAddress          = document.createElement("input");
        newInputAddress.index        = inputAddressNumber;
        newInputAddress.className    = "input-address removable-input-address";
        newInputAddress.type         = "text";
        newInputAddress.maxLength    = 74;

        newInputAddress.style.border = "1px solid " + colors[newInputAddress.index];
        newInputBlock.appendChild(newInputAddress);
        newInputAddress.onfocus = function(){
            this.style.boxShadow = "inset 0 0 5px " + colors[newInputAddress.index];
        }
        newInputAddress.onblur = function(){
            this.style.boxShadow = "none";
        }
        newInputAddress.addEventListener("change", validateInputAddress);
        newInputAddress.addEventListener("input", backToNormalColorAddress);
        if (showDelay == 0) {newInputAddress.delay = 0;}

        var newTimeDelayDeclaration       = document.createElement("span");
        newTimeDelayDeclaration.className = "time-delay-declaration";
        showDelay == 0 ? newTimeDelayDeclaration.innerHTML = "" : newTimeDelayDeclaration.innerHTML = "delay:";
        newInputBlock.appendChild(newTimeDelayDeclaration);

        var newTimeDelay = document.createElement("span");
        newTimeDelay.className = "time-delay-value";
        showDelay == 0 ? newTimeDelay.style.display = "none" : newTimeDelay.style.display = "block";
        newInputBlock.appendChild(newTimeDelay);

        var newPercentage = document.createElement("span");
        newPercentage.className = "percentage-value";
        newInputBlock.appendChild(newPercentage);
        inputForm.appendChild(newInputBlock);  

        makePercentageSlider(percentageDistribution, percentageValue, 0, 100, percentStep, inputAddressNumber);

        inputAddressNumber++;
        if (inputAddressNumber == maxNumberOfInputs) {addAddressButton.style.display = "none";};

        if (showDelay) {
            makeTimeSlider(delayContent, timeDelay, timeDelayMin, timeDelayMax, timeDelayStep, inputAddressNumber);
        }

        var newReceiveAddressBlock = document.createElement("div"); 
        newReceiveAddressBlock.className = "receive-address-block";
        var newInputReceive = document.createElement("input");
        newInputReceive.type = "text";
        newInputReceive.className = "input-receive";
        newInputReceive.index = inputAddressNumber - 1;

        if (inputAddressNumber == 2) {
            inputReceive.style.border = "1px solid " + colors[inputAddressNumber-2];
            inputReceive.onfocus = function(){
                this.style.boxShadow = "inset 0 0 5px " + colors[inputReceive.index];
            }
            inputReceive.onblur = function(){
                this.style.boxShadow = "none";
            }
        }
        newInputReceive.addEventListener("input", controlReceiveCalculator);
        newInputReceive.style.border = "1px solid " + colors[newInputReceive.index];
        newInputReceive.onfocus = function(){
            this.style.boxShadow = "inset 0 0 5px " + colors[newInputReceive.index];
        }
        newInputReceive.onblur = function(){
            this.style.boxShadow = "none";
        }

        newReceiveAddressBlock.appendChild(newInputReceive);
        var newInputReceiveDetails = document.createElement("span");
        newInputReceiveDetails.className = "input-receive-details";
        newReceiveAddressBlock.appendChild(newInputReceiveDetails);
        receiveBlockCalculator.appendChild(newReceiveAddressBlock);
        
        controlDetailsCalculator();
        controlSendCalculator();

        feeAmount.innerHTML = feeSlider.value.toFixed(4) + "%";
          
        continueButton.className = "continue-button-disabled";
        continueButton.onclick = continueDisabled;
    }

    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
}
    
function removeAddress(event) {
    inputToDelete = event.target.parentNode || event.srcElement.parentNode;
    inputForm.removeChild(inputToDelete);
    inputAddressNumber--;

    var receiveAddressBlockToDelete = receiveBlockCalculator.lastChild;
    receiveBlockCalculator.removeChild(receiveAddressBlockToDelete);
    var receiveInputs = document.querySelectorAll(".input-receive");
    for (var i = 0; i<inputAddressNumber; i++) {
        receiveInputs[i].index = i;
    }
    
    if (inputAddressNumber == 1) {
        if (showDelay == 0) {
            document.querySelector(".sliders").style.marginTop = "-20px";
        }
        percentageDistribution.innerHTML = "";
        percentageValue.innerHTML = "100%";
        percentageValue.style.display = "none";
        var inputAddress = document.querySelector(".input-address");
        inputAddress.percent = 100;
        if (isValid(inputAddress.value)) {
            inputAddress.style.border = "1px solid" + colorDefault;
            inputAddress.onfocus = function(){
                this.style.boxShadow = "inset 0 0 5px " + colorDefault;
            }
            inputAddress.onblur = function(){
                this.style.boxShadow = "none";
            }
        } else {
            inputAddress.style.border = "1px solid" + colorError;
            inputAddress.onfocus = function(){
                this.style.border = "1px solid" + colorDefault;
                this.style.boxShadow = "inset 0 0 5px " + colorDefault;
            }
            inputAddress.onblur = function(){
                this.style.border = "1px solid" + colorError;
                this.style.boxShadow = "none";
            }
        }
        
        inputReceive.style.border = "1px solid" + colorDefault;
        inputReceive.onfocus = function(){
            this.style.boxShadow = "inset 0 0 5px " + colorDefault;
        }
        inputReceive.onblur = function(){
            this.style.boxShadow = "none";
        }    
    } else {
        makePercentageSlider(percentageDistribution, percentageValue, 0, 100, percentStep, inputAddressNumber-1);
        var inputAddresses = document.querySelectorAll(".input-address");
        for (var i = 0; i < inputAddressNumber; i++) {
            inputAddresses[i].index = i;
            if (isValid(inputAddresses[i].value)) {
                inputAddresses[i].style.border = "1px solid" + colors[i];
            } else {
                inputAddresses[i].style.border = "1px solid " + colorError;
                inputAddresses[i].onfocus = function(){
                    this.style.border = "1px solid " + colors[this.index];
                    this.style.boxShadow = "inset 0 0 5px " + colors[this.index];
                }
                inputAddresses[i].onblur = function(){
                    this.style.border = "1px solid " + colorError;
                    this.style.boxShadow = "none";
                }
            }
        }
    }

    if (inputAddressNumber == maxNumberOfInputs-1) {
        addAddressButton.style.display = "block";        
    }

    if (showDelay) {
        makeTimeSlider(delayContent, timeDelay, timeDelayMin, timeDelayMax, timeDelayStep, inputAddressNumber);
    }

    controlDetailsCalculator();
    controlSendCalculator();

    feeAmount.innerHTML = feeSlider.value.toFixed(4) + "%";

    defineState();

    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
}

function controlDelay(event){
    if (showDelay == 0) {
        if (inputAddressNumber == 1) {
            document.querySelector(".sliders").style.marginTop = "-7px";
        }
        makeTimeSlider(delayContent, timeDelay, timeDelayMin, timeDelayMax, timeDelayStep, inputAddressNumber);
        addDelayButton.innerHTML = "Delete Delay";
        var timeDelayClass = timeDelay.className;
        var timeDelays = document.querySelectorAll("." + timeDelayClass);
        var delayDeclarations = document.querySelectorAll(".time-delay-declaration");
        var percentageValueClass = percentageValue.className;
        var percentageDistributions = document.querySelectorAll("." + percentageValueClass);
        for (var i = 0; i < inputAddressNumber; i++) {
            timeDelays[i].style.display = "block";
            delayDeclarations[i].innerHTML = "delay:";
        }
        showDelay++;
        controlDetailsCalculator();
    }
    else {
        if (inputAddressNumber == 1) {
            document.querySelector(".sliders").style.marginTop = "-20px";
        }
        delayContent.innerHTML = "";
        addDelayButton.innerHTML = "Add Delay";
        var timeDelayClass = timeDelay.className;
        var timeDelays = document.querySelectorAll("." + timeDelayClass);
        var delayDeclarations = document.querySelectorAll(".time-delay-declaration");
        var percentageValueClass = percentageValue.className;
        var percentageDistributions = document.querySelectorAll("." + percentageValueClass);
        var inputAddresses = document.querySelectorAll(".input-address");
        for (var i = 0; i < inputAddressNumber; i++) {
            inputAddresses[i].delay = 0;
            timeDelays[i].style.display = "none";
            delayDeclarations[i].innerHTML = "";
        }
        showDelay--;
        controlDetailsCalculator();
    }

    event = event || window.event;
    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
}

