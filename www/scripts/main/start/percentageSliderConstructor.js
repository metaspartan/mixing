function makePercentageSlider(sliderContent, sliderValue, min, max, step, numberOfThumbs){
    if (numberOfThumbs > maxNumberOfInputs-1) {
        numberOfThumbs = maxNumberOfInputs-1;
    }
    sliderContent.innerHTML = '';
    var text = document.createElement("p");
    text.style.fontSize = "13px";
    text.innerHTML = "Percentage distribution";
    sliderContent.appendChild(text);
    var sliderParent = document.createElement("div");
    sliderParent.className = "percentage-slider-parent";
    var slider = document.createElement("div");
    slider.className = "percentage-slider";
    slider.style.backgroundColor = colorDefault;
    sliderContent.appendChild(sliderParent);
    sliderParent.appendChild(slider);

    var sliderValueClass = sliderValue.className;
    var sliderValues = document.querySelectorAll("."+sliderValueClass);

    var thumbs = [];
    for (var i = 0; i<numberOfThumbs; i++) {
        var thumb = document.createElement("div");
        thumb.className = slider.className + "-thumb";
        thumb.style.background = colorDefault;
        slider.appendChild(thumb);
        thumbs.push(thumb);
    };

    var sliderCoords = getCoords(slider);
    var sliderLength = slider.offsetWidth;
    var stepDecimals = numberOfDecimals(step);
    var numberOfSteps = (max-min)/step;
    var stepLength = sliderLength/numberOfSteps;

    var values = [];       

    for (var i = 0; i<numberOfThumbs; i++) {
        var value = min + Math.floor((max-min)/(numberOfThumbs+1)*step*(i+1));
        value = value.toFixed(stepDecimals);
        value = value*1;
        thumbs[i].style.left = ((value-min)/step)*stepLength - thumb.offsetWidth/2 + 'px';        
        thumbs[i].style.top = -18*i - 7 + 'px';
        values.push(value);       
    }

    var thumbCenters = defineCentersCoordinates(thumbs);

    var lenghts = defineLenghts(values);
    writePercentage(sliderValues, lenghts);
    var gradient = defineGradient(values);
    slider.style.background = gradient;

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
        var thumbCenters = defineCentersCoordinates(thumbs);
        e.pageX = e.pageX || e.touches[0].pageX;
        var closest = defineClosestIndexes(thumbCenters, e.pageX - sliderCoords.left);
        var thumbCoords = getCoords(thumbs[closest]);
        var thumbStyle = thumbs[closest].style;

        isMouseDownOnSlider = 1; 

        if (e.pageX > thumbCoords.right || e.pageX < thumbCoords.left) {
            var temp = Math.round((e.pageX - sliderCoords.left)/stepLength);
            thumbCenters[closest] = temp*stepLength;
            thumbStyle.left = temp*stepLength - (thumb.offsetWidth/2) + 'px';
            values[closest] = min + step*temp;
            values[closest] = values[closest].toFixed(stepDecimals);
            values[closest] = values[closest]*1;
        }   

        lenghts = defineLenghts(values);
        writePercentage(sliderValues, lenghts);
        gradient = defineGradient(values);
        slider.style.background = gradient;

        controlDetailsCalculator();
        controlSendCalculator();
    };

    var sliderOnMouseDown2 = function(e){
        e.preventDefault(); 
        isMouseDownOnSlider = 1; 

        var sliderCoords = getCoords(slider);
        var sliderLength = slider.offsetWidth;
        var stepLength = sliderLength/numberOfSteps;
        var thumbCenters = defineCentersCoordinates(thumbs);
        e.pageX = e.pageX || e.touches[0].pageX;
        var closest = defineClosestIndexes(thumbCenters, e.pageX - sliderCoords.left); 
        if (closest == 0) {
            var minValueForThisThumb = step;
            var minCenterCoordinateForThisThumb = stepLength;
            if (numberOfThumbs>1) {
                var maxValueForThisThumb = values[closest+1]-step;
                var maxCenterCoordinateForThisThumb = thumbCenters[closest+1] - stepLength;
            } else {
                var maxValueForThisThumb = max - step;
                var maxCenterCoordinateForThisThumb = sliderLength - stepLength;
            }
        } else if (closest == numberOfThumbs-1) {
            var minValueForThisThumb = values[closest-1] + step;
            var minCenterCoordinateForThisThumb = thumbCenters[closest-1] + stepLength;
            var maxValueForThisThumb = max - step;
            var maxCenterCoordinateForThisThumb = sliderLength - stepLength;
        } else {
            var minValueForThisThumb = values[closest-1] + step;
            var minCenterCoordinateForThisThumb = thumbCenters[closest-1] + stepLength;
            var maxValueForThisThumb = values[closest+1]-step;
            var maxCenterCoordinateForThisThumb = thumbCenters[closest+1] - stepLength;
        }

        var shiftX = e.pageX - getCoords(thumbs[closest]).left;        
        var thumbStyle = thumbs[closest].style;

        slider.style.opacity = 1;

        function changeAtMove(e){ 
            isMouseDownOnSlider = 1;
            if (e.pageX !== 0) {
                e.pageX = e.pageX || e.touches[0].pageX;
            }   
            if((e.pageX - shiftX + thumb.offsetWidth/2) < minCenterCoordinateForThisThumb + sliderCoords.left){
                values[closest] = minValueForThisThumb;
                thumbCenters[closest] = minCenterCoordinateForThisThumb;
                thumbStyle.left = minCenterCoordinateForThisThumb - (thumb.offsetWidth/2) +'px';
            } else if((e.pageX - shiftX + thumb.offsetWidth/2) > maxCenterCoordinateForThisThumb + sliderCoords.left){
                values[closest] = maxValueForThisThumb;
                thumbCenters[closest] = maxCenterCoordinateForThisThumb;
                thumbStyle.left = maxCenterCoordinateForThisThumb - (thumb.offsetWidth/2) + 'px';
            } else {
                var temp = Math.round((e.pageX - shiftX  + thumb.offsetWidth/2 - sliderCoords.left)/stepLength);
                thumbCenters[closest] = temp*stepLength;
                thumbStyle.left = temp*stepLength - thumb.offsetWidth/2 + 'px';
                values[closest] = min + step*temp;
                values[closest] = values[closest].toFixed(stepDecimals);
                values[closest] = values[closest]*1;   
            } 

            lenghts = defineLenghts(values);
            writePercentage(sliderValues, lenghts);
            gradient = defineGradient(values);
            slider.style.background = gradient;

            controlDetailsCalculator();
            controlSendCalculator();
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
        var thumbCenters = defineCentersCoordinates(thumbs);
        e.pageX = e.pageX || e.touches[0].pageX;
        var closest = defineClosestIndexes(thumbCenters, e.pageX - sliderCoords.left); 
        if (closest == 0) {
            var minValueForThisThumb = step;
            var minCenterCoordinateForThisThumb = stepLength;
            if (numberOfThumbs>1) {
                var maxValueForThisThumb = values[closest+1]-step;
                var maxCenterCoordinateForThisThumb = thumbCenters[closest+1] - stepLength;
            } else {
                var maxValueForThisThumb = max - step;
                var maxCenterCoordinateForThisThumb = sliderLength - stepLength;
            }
        } else if (closest == numberOfThumbs-1) {
            var minValueForThisThumb = values[closest-1] + step;
            var minCenterCoordinateForThisThumb = thumbCenters[closest-1] + stepLength;
            var maxValueForThisThumb = max - step;
            var maxCenterCoordinateForThisThumb = sliderLength - stepLength;
        } else {
            var minValueForThisThumb = values[closest-1] + step;
            var minCenterCoordinateForThisThumb = thumbCenters[closest-1] + stepLength;
            var maxValueForThisThumb = values[closest+1]-step;
            var maxCenterCoordinateForThisThumb = thumbCenters[closest+1] - stepLength;
        }

        var shiftX = e.pageX - getCoords(thumbs[closest]).left;        
        var thumbStyle = thumbs[closest].style;

        slider.style.opacity = 1;

        function changeAtMove(e){ 
            isMouseDownOnSlider = 1; 
            e.pageX = e.pageX || e.touches[0].pageX;          
            if((e.pageX - shiftX + thumb.offsetWidth/2) < minCenterCoordinateForThisThumb + sliderCoords.left){
                values[closest] = minValueForThisThumb;
                thumbCenters[closest] = minCenterCoordinateForThisThumb;
                thumbStyle.left = minCenterCoordinateForThisThumb - (thumb.offsetWidth/2) +'px';
            } else if((e.pageX - shiftX + thumb.offsetWidth/2) > maxCenterCoordinateForThisThumb + sliderCoords.left){
                values[closest] = maxValueForThisThumb;
                thumbCenters[closest] = maxCenterCoordinateForThisThumb;
                thumbStyle.left = maxCenterCoordinateForThisThumb - (thumb.offsetWidth/2) + 'px';
            } else {
                var temp = Math.round((e.pageX - shiftX  + thumb.offsetWidth/2 - sliderCoords.left)/stepLength);
                thumbCenters[closest] = temp*stepLength;
                thumbStyle.left = temp*stepLength - thumb.offsetWidth/2 + 'px';
                values[closest] = min + step*temp;
                values[closest] = values[closest].toFixed(stepDecimals);
                values[closest] = values[closest]*1;   
            } 

            lenghts = defineLenghts(values);
            writePercentage(sliderValues, lenghts);
            gradient = defineGradient(values);
            slider.style.background = gradient;

            controlDetailsCalculator();
            controlSendCalculator();
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
    slider.parentNode.addEventListener("touchstart", sliderOnMouseDown1);
    slider.parentNode.addEventListener("touchstart", sliderOnMouseDown3);
    slider.parentNode.addEventListener("mouseover", sliderMouseover);
    slider.parentNode.addEventListener("mouseout", sliderMouseout);

    function getCoords(elem){
        var box = elem.getBoundingClientRect();
        return {
            top   : box.top   + pageYOffset,
            left  : box.left  + pageXOffset,
            right : box.right + pageXOffset
        };
    }

    function numberOfDecimals(x){
        var xDecimals = 0;
        while (1){
            if (x.toFixed(xDecimals) == x)
                break;
            xDecimals++;
        }
        return xDecimals;
    }

    function defineClosestIndexes(Array, number){
        var temp = [];
        for (var i=0; i < Array.length; i++) {
            temp.push(Math.abs(Array[i]-number));
        }        
        var min = Infinity;
        for (var i=0; i < Array.length; i++) {
            if (temp[i] < min) {min = temp[i]};
        }
        var closestToNumber = '';
        for (var i=0; i < Array.length; i++) {
            if (temp[i] == min) {
                closestToNumber = i;
                break;
            }
        }
        return closestToNumber;
    }

    function defineLenghts(values){
        var lenghts = [values[0]-min];
        for (i = 1; i<numberOfThumbs; i++) {
            lenghts.push(values[i]-values[i-1]);
        }
        lenghts.push(max-values[i-1]);
        return lenghts;
    }

    function defineGradient(values) {
        var gradientControl = "linear-gradient(to right, ";
        for (var i = 0; i<=numberOfThumbs; i++) {
            if (i == 0) {
            gradientControl = gradientControl + colors[i] + ", " + colors[i] + " " + values[i] + "%, ";
            } else if (i == numberOfThumbs) {
                gradientControl = gradientControl + colors[i] + " " + values[i-1] + "%, " + colors[i] + ")";
            } else {
                gradientControl = gradientControl + colors[i] + " " + values[i-1] + "%, " + colors[i] + " " + values[i] + "%, ";
            }
        }
        return gradientControl;
    }

    function writePercentage(sliderValues, lenghts) {
        var inputAddresses = document.querySelectorAll(".input-address");
        for (var i=0; i<=numberOfThumbs; i++) {
            inputAddresses[i].percent = lenghts[i];
            sliderValues[i].innerHTML = "share: " + lenghts[i] + "%";
        }
    }

    function defineCentersCoordinates(thumbs) {
        var thumbCenters = [];
        var thumbOffsetWidth = thumbs[0].offsetWidth;
        for (var i = 0; i<thumbs.length; i++) {
            thumbCenters.push(thumbs[i].style.left.slice(0,-2)*1 + thumbOffsetWidth/2);
        }
        return thumbCenters;
    }
}

