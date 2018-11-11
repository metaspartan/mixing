window.onresize = function(){
    document.querySelector(      ".bitcode-tooltip-content"     ).style.display = "none";
    document.querySelector(       ".bitcode-tooltip-arrow"      ).style.display = "none";
    document.querySelector(        ".fee-tooltip-content"       ).style.display = "none";
    document.querySelector(         ".fee-tooltip-arrow"        ).style.display = "none";
    document.querySelector(    ".satperbyte-tooltip-content"    ).style.display = "none";
    document.querySelector(     ".satperbyte-tooltip-arrow"     ).style.display = "none";
    document.querySelector(".output-address-fee-tooltip-content").style.display = "none";
    document.querySelector( ".output-address-fee-tooltip-arrow" ).style.display = "none";
    document.querySelector(".minimum-calculator-tooltip-content").style.display = "none";
    document.querySelector( ".minimum-calculator-tooltip-arrow" ).style.display = "none";

    if (start) {
        var feeSliderCoords  = getCoords(feeSlider);
        var feeSliderLength  = feeSlider.offsetWidth;
        var feeNumberOfSteps = (feeMax-feeMin)/feeStep;
        var feeStepLength    = feeSliderLength/feeNumberOfSteps;
        feeSlider.firstChild.style.left = ((feeSlider.value-feeMin)/feeStep)*feeStepLength - feeSlider.firstChild.offsetWidth/2 + 'px';
    }
    
    if (inputAddressNumber > 1) {
        var percentageSlider       = document.querySelector(".percentage-slider");
        var percentageSliderCoords = getCoords(percentageSlider);
        var percentageSliderLength = percentageSlider.offsetWidth;
        var percentageStepLength   = percentageSliderLength/100; // 100%
        var inputAddresses         = document.querySelectorAll(".input-address");
        var currentValue           = inputAddresses[0].percent;
        var percentageThumbs       = document.querySelectorAll(".percentage-slider-thumb");
        for (var i = 0; i<inputAddressNumber-1; i++) {
            percentageThumbs[i].style.left = currentValue*percentageStepLength - percentageSlider.firstChild.offsetWidth/2 + 'px';
            currentValue += inputAddresses[i+1].percent;
        }
    }

    if (1 == showDelay) {
        var timeDelaySlider  = document.querySelector(".time-delay-slider");
        var timeSliderCoords = getCoords(timeDelaySlider);
        var timeSliderLength = timeDelaySlider.offsetWidth;
        var timeStepLength   = timeSliderLength/48; // 48 hours, lazy to exclude number
        var inputAddresses   = document.querySelectorAll(".input-address");
        var timeThumbs       = document.querySelectorAll(".time-delay-slider-thumb");
        for (var i = 0; i<inputAddressNumber; i++) {
            timeThumbs[i].style.left = (inputAddresses[i].delay)*timeStepLength - timeDelaySlider.firstChild.offsetWidth/2 + 'px';
        }
    }

    function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top:   box.top + pageYOffset,
            left:  box.left + pageXOffset,
            right: box.right + pageXOffset
        };
    }
}

