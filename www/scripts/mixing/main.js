function makeFeeSlider(slider, sliderValue, min, max, step, initial /*string random makes random position*/){
    sliderValue.style.fontWeight = "bold";
    slider.innerHTML = '';
    if (initial == "random") {
        slider.style.backgroundColor = colorFeeSlider; 
    } else {
        slider.style.backgroundColor = colorDiscount;
    }    

    var thumb = document.createElement("div");
    thumb.className = slider.className + "-thumb";
    if (initial == "random") {
        thumb.style.backgroundColor = colorFeeSlider;
    } else {
        thumb.style.backgroundColor = colorDiscount;
    }
   
    slider.appendChild(thumb);

    var sliderCoords = getCoords(slider);
    var sliderLength = slider.offsetWidth;
    var stepDecimals = numberOfDecimals(step);
    var numberOfSteps = (max-min)/step;
    var stepLength = sliderLength/numberOfSteps;

    if (initial === "random") {
        var value = min + step*Math.round(numberOfSteps*Math.random()/5);
        value = value.toFixed(stepDecimals);
        value = value*1;
    } else {
        var value = min;
    }
    slider.value = value;
    sliderValue.innerHTML = value.toFixed(stepDecimals) + "%";
    thumb.style.left = ((value-min)/step)*stepLength - thumb.offsetWidth/2 + 'px';

    var isMouseDownOnSlider = 0;
    var isMouseOverSlider = 0;

    var sliderMouseover = function(e){
        isMouseOverSlider = 1;
        slider.style.opacity = 1;
    }

    var sliderMouseout = function(e){
        isMouseOverSlider = 0;
        isMouseDownOnSlider ? slider.style.opacity = 1: slider.style.opacity = .7;
    }

    var sliderOnMouseDown1 = function(e){
        var sliderCoords = getCoords(slider);
        var sliderLength = slider.offsetWidth;
        var stepLength = sliderLength/numberOfSteps;
        var thumbCoords = getCoords(thumb);
        var thumbStyle = thumb.style;
        e.pageX = e.pageX || e.touches[0].pageX;
        isMouseDownOnSlider = 1; 

        if (e.pageX > thumbCoords.right || e.pageX < thumbCoords.left) {
            var temp = Math.round((e.pageX - sliderCoords.left)/stepLength);
            thumbStyle.left = temp*stepLength - (thumb.offsetWidth/2) + 'px';
            value = min + step*temp;
            value = value.toFixed(stepDecimals);
            value = value*1;
            slider.value = value;
            sliderValue.innerHTML = value.toFixed(stepDecimals) + "%";
        }
    };

    var sliderOnMouseDown2 = function(e){
        e.preventDefault(); 
        isMouseDownOnSlider = 1; 

        var sliderCoords = getCoords(slider);
        var sliderLength = slider.offsetWidth;
        var stepLength = sliderLength/numberOfSteps;
        e.pageX = e.pageX || e.touches[0].pageX; 
        var shiftX = e.pageX - getCoords(thumb).left;    
        var thumbStyle = thumb.style;         
        slider.style.opacity = 1;

        function changeAtMove(e){ 
            isMouseDownOnSlider = 1; 
            if (e.pageX !== 0) {
                e.pageX = e.pageX || e.touches[0].pageX;
            }     
            if((e.pageX - shiftX + thumb.offsetWidth/2) < sliderCoords.left){
                value = min;
                thumbStyle.left = - (thumb.offsetWidth/2) +'px';     
            } else if((e.pageX - shiftX + thumb.offsetWidth/2) > sliderCoords.right){
                value = max;
                thumbStyle.left = slider.offsetWidth - (thumb.offsetWidth/2) + 'px';
            } else {
                var temp = Math.round((e.pageX - shiftX  + thumb.offsetWidth/2 - sliderCoords.left)/stepLength);
                thumbStyle.left = temp*stepLength - thumb.offsetWidth/2 + 'px';
                value = min + step*temp;
                value = value.toFixed(stepDecimals);
                value = value*1;
            }
            sliderValue.innerHTML = value.toFixed(stepDecimals) + "%";
            slider.value = value;
        }

        document.onmousemove = function(e){
            changeAtMove(e);
        }

        document.onmouseup = slider.onmouseup = function(){
            isMouseDownOnSlider = 0;
            isMouseOverSlider ? slider.style.opacity = 1: slider.style.opacity = .7;
            document.onmousemove = document.onmouseup = null;
        }
    };

    var sliderOnMouseDown3 = function(e){
        e.preventDefault(); 
        isMouseDownOnSlider = 1; 

        var sliderCoords = getCoords(slider);
        var sliderLength = slider.offsetWidth;
        var stepLength = sliderLength/numberOfSteps;
        e.pageX = e.pageX || e.touches[0].pageX;
        var shiftX = e.pageX - getCoords(thumb).left;    
        var thumbStyle = thumb.style;         
        slider.style.opacity = 1;

        function changeAtMove(e){ 
            isMouseDownOnSlider = 1;  
            e.pageX = e.pageX || e.touches[0].pageX;        
            if((e.pageX - shiftX + thumb.offsetWidth/2) < sliderCoords.left){
                value = min;
                thumbStyle.left = - (thumb.offsetWidth/2) +'px';     
            } else if((e.pageX - shiftX + thumb.offsetWidth/2) > sliderCoords.right){
                value = max;
                thumbStyle.left = slider.offsetWidth - (thumb.offsetWidth/2) + 'px';
            } else {
                var temp = Math.round((e.pageX - shiftX  + thumb.offsetWidth/2 - sliderCoords.left)/stepLength);
                thumbStyle.left = temp*stepLength - thumb.offsetWidth/2 + 'px';
                value = min + step*temp;
                value = value.toFixed(stepDecimals);
                value = value*1;
            }
            sliderValue.innerHTML = value.toFixed(stepDecimals) + "%";
            slider.value = value;
        }

        document.ontouchmove = function(e){
            changeAtMove(e);
        }

        document.ontouchend = slider.ontouchend = function(){
            isMouseDownOnSlider = 0;
            isMouseOverSlider ? slider.style.opacity = 1: slider.style.opacity = .7;
            document.ontouchmove = document.ontouchend = null;
        }
    };

    slider.parentNode.addEventListener("mousedown", sliderOnMouseDown1);
    slider.parentNode.addEventListener("mousedown", sliderOnMouseDown2);
    //slider.parentNode.addEventListener("touchstart", sliderOnMouseDown1);
    slider.parentNode.addEventListener("touchstart", sliderOnMouseDown3);
    slider.parentNode.addEventListener("mouseover", sliderMouseover);
    slider.parentNode.addEventListener("mouseout", sliderMouseout);

    function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top:   box.top + pageYOffset,
            left:  box.left + pageXOffset,
            right: box.right + pageXOffset
        };
    }

    function numberOfDecimals(x){
        var xDecimals = 0;
        while (1){
            if (x.toFixed(xDecimals) == x) {
                break;
            }
            else {
                xDecimals++;
            };
        }
        return xDecimals;
    }
}

function handleAmount() {
    amount.correct = false;
    if (amount.value == "") {
        defineState();
        defaultStyle();
        return;
    }

    if (!isNumeric(amount.value) || amount.value > maxAmount || amount.value <= 0) {
        defineState();
        errorStyle();
        if (isNumeric(amount.value) && amount.value > maxAmount) {
            maxAmountCaption.classList.add("incorrect");
        } else {
            maxAmountCaption.classList.remove("incorrect");
        }
        return;
    }

    var temp = amount.value.split(".");
    if (temp[1] && temp[1].length > 8) {
        amount.value = temp[0] + "." + temp[1].substring(0,8);
    }

    amount.correct = true;
    defaultStyle();
    defineState();

    function defaultStyle() {
        maxAmountCaption.classList.remove("incorrect");
        amount.style.border = "1px solid " + colorDefault;
        amount.onfocus = function(){
            this.style.boxShadow = "inset 0 0 5px " + colorDefault;
        }
        amount.onblur = function(){
            this.style.boxShadow = "none";
        }
    }

    function errorStyle() {
        amount.style.border = "1px solid " + colorDefault;
        amount.onfocus = function() {
            this.style.border = "1px solid " + colorDefault;
            this.style.boxShadow = "inset 0 0 5px " + colorDefault;
        }
        amount.onblur = function() {
            this.style.border = "1px solid " + colorError;
            this.style.boxShadow = "none";
        }
    }
}

function defineState() {
    setDisabled();

    if (!amount.correct) {
        return false;
    }

    setEnabled();
    return true;

    function setEnabled() {
        button.classList.remove("continue-button-disabled");
        button.classList.add("continue-button");
    }

    function setDisabled() {
        button.classList.remove("continue-button");
        button.classList.add("continue-button-disabled");
    }
}

function prepare(event) {
    if (!defineState()) {
        return;
    }
    if (event.target == button && (!lsTest() || localStorage.noTakeawayPopup != "true")) {
        var sum = amount.value*(1+feeSlider.value/100);
        specifiedAmount.innerHTML = amount.value*1;
        incomingAmount.innerHTML = sum.toFixed(8)*1;
        if (!lsTest()) {
            dontAskButton.style.display = "none";
        }
        confirmPopup.style.display = "block";
        return;
    }
    if (lsTest() && !dontAskButton.showPopup) {
        localStorage.noTakeawayPopup = "true";
    }
    confirmPopup.style.display = "none";
    load.style.display = "block";

    var boundary       = String(Math.random()).slice(2),
        boundaryMiddle = '--' + boundary + '\r\n',
        boundaryLast   = '--' + boundary + '--\r\n';

    var body = ['\r\n'];

    body.push('Content-Disposition: form-data; name="amount"\r\n\r\n' + amount.value + '\r\n');
    body.push('Content-Disposition: form-data; name="commission"\r\n\r\n' + feeSlider.value + '\r\n');
    body = body.join(boundaryMiddle) + boundaryLast;
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/operation/prepareTakeaway', true);
    xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
    xhr.onreadystatechange = function() {
        if (this.readyState != 4) return;
        load.style.display = "none";
        if (this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (!response.success && response.reason == "permissions") {
                window.location.replace("/403");
            }
            if (!response.success && response.reason == "internal") {
                errorPopup.style.display = "block";
            }
            if (!response.success && response.reason == "unconfirmedOutputs") {
                unconfirmedPopup.style.display = "block";
            }
            if (!response.success && response.reason == "insufficientBalance") {
                balancePopup.style.display = "block";
            }
            if (!response.success && response.reason == "maximumChanged") {
                amount.value = "";
                maxAmount = response.maximum;
                maxAmountChangePopup.style.display = "block";
                maxAmountCaption.innerHTML = response.maximum + " BTC";
                defineState();
            }
            if (response.success) {
                window.location.replace("/mixing/" + response.ID);
            }
        } else {
            errorPopup.style.display = "block";
        }
    }
    xhr.send(body);
}

var amount = document.querySelector("#amount-to-mix"),
    feeSlider = document.querySelector(".fee-slider"),
    feeAmount = document.querySelector(".fee-amount"),
    button = document.querySelector(".continue-button-disabled"),
    proceedButton = document.querySelector(".accept-button"),
    maxAmountCaption = document.querySelector("#maximum-amount"),

    dontAskButton = document.querySelector(".do-not-ask-check"),
    confirmPopup = document.querySelector("#confirm-popup"),
    closeConfirmPopup = document.querySelector("#close-confirm-popup"),
    errorPopup = document.querySelector("#error-popup"),
    closeErrorPopup = document.querySelector("#close-error-popup"),
    balancePopup = document.querySelector("#insufficient-balance"),
    closeBalancePopup = document.querySelector("#close-insufficient-balance"),
    unconfirmedPopup = document.querySelector("#unconfirmed-output"),
    closeUnconfirmedPopup = document.querySelector("#close-unconfirmed-output"),
    maxAmountChangePopup = document.querySelector("#maximum-amount-changed"),
    closeMaxAmountChangePopup = document.querySelector("#close-maximum-amount-changed"),

    specifiedAmount = document.querySelector("#specified-amount"),
    incomingAmount = document.querySelector("#incoming-amount"),
    load = document.querySelector(".load-in-progress"),

    colorFeeSlider = (discount > 0) ? "#39b569" : "#848cbc",
    colorDefault = "#729fa0",
    colorError = "#ff0033",
    
    feeMin  = 0.5-discount,
    feeMax  = 3,
    feeStep = 0.0001;

amount.correct = false;
dontAskButton.showPopup = true;
makeFeeSlider(feeSlider, feeAmount, feeMin, feeMax, feeStep, "random");

amount.addEventListener("input", handleAmount);
button.addEventListener("click", prepare);
proceedButton.addEventListener("click", prepare);
dontAskButton.addEventListener("click", function(event) {
    if (event.target.tagName == "INPUT") {
        dontAskButton.showPopup = !dontAskButton.showPopup;
    }   
});

window.addEventListener("resize", function() {
    var feeSliderCoords  = getCoords(feeSlider),
        feeSliderLength  = feeSlider.offsetWidth,
        feeNumberOfSteps = (feeMax-feeMin)/feeStep,
        feeStepLength    = feeSliderLength/feeNumberOfSteps;
    feeSlider.firstChild.style.left = ((feeSlider.value-feeMin)/feeStep)*feeStepLength - feeSlider.firstChild.offsetWidth/2 + 'px';

    function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top:   box.top + pageYOffset,
            left:  box.left + pageXOffset,
            right: box.right + pageXOffset
        };
    }
});

window.addEventListener("click", function(event) {
    if (event.target == confirmPopup) {
        confirmPopup.style.display = "none";
    }
    if (event.target == errorPopup) {
        errorPopup.style.display = "none";
    }
    if (event.target == balancePopup) {
        balancePopup.style.display = "none";
    }
    if (event.target == unconfirmedPopup) {
        unconfirmedPopup.style.display = "none";
    }
    if (event.target == maxAmountChangePopup) {
        maxAmountChangePopup.style.display = "none";
    }
});

closeConfirmPopup.addEventListener("click", function() {
    confirmPopup.style.display = "none";
});

closeErrorPopup.addEventListener("click", function() {
    errorPopup.style.display = "none";
});

closeBalancePopup.addEventListener("click", function() {
    balancePopup.style.display = "none";
});

closeUnconfirmedPopup.addEventListener("click", function() {
    unconfirmedPopup.style.display = "none";
});

closeMaxAmountChangePopup.addEventListener("click", function() {
    maxAmountChangePopup.style.display = "none";
});


function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
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
