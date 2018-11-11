function makeTimeSlider(sliderContent, sliderValue, min, max, step, numberOfThumbs){
    if (numberOfThumbs > maxNumberOfInputs) {
        numberOfThumbs = maxNumberOfInputs;
    }
    sliderContent.innerHTML = '';
    var text = document.createElement("p");
    text.style.fontSize = "13px";
    text.innerHTML = "Time delay";
    sliderContent.appendChild(text);
    var sliderParent = document.createElement("div");
    sliderParent.className = "time-delay-slider-parent";
    var slider = document.createElement("div");
    slider.className = "time-delay-slider";
    slider.style.backgroundColor = colorDefault;
    sliderContent.appendChild(sliderParent);
    sliderParent.appendChild(slider);

    var sliderValueClass = sliderValue.className;
    var sliderValues = document.querySelectorAll("."+sliderValueClass);

    var inputAddresses = document.querySelectorAll(".input-address");

    thumbs = [];
    for (var i = 0; i<numberOfThumbs; i++) {
        var thumb = document.createElement("div");
        thumb.className = slider.className + "-thumb";
        if (numberOfThumbs == 1) {
            thumb.style.background = colorDefault;}            
        else {
            thumb.style.background = colors[i];}
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
        var value = min + 2 + 4*step*i;
        value = value.toFixed(stepDecimals);
        value = value*1;
        inputAddresses[i].delay = value;
        sliderValues[i].innerHTML = value + "h";
        thumbs[i].style.left = ((value-min)/step)*stepLength - thumb.offsetWidth/2 + 'px';        
        thumbs[i].style.top = -18*i -7 + 'px';
        thumbs[i].order = i;
        values.push(value);

    };
    var thumbCenters = defineCentersCoordinates(thumbs);

    var isMouseDownOnSlider = 0;
    var isMouseOverSlider = 0;

    var sliderMouseover = function(){
        isMouseOverSlider = 1;
        slider.style.opacity = 1;
    };

    var sliderMouseout = function(){
        isMouseOverSlider = 0;
        isMouseDownOnSlider ? slider.style.opacity = 1: slider.style.opacity = .7;
    };

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
            sliderValues[thumbs[closest].order].innerHTML = values[closest] + "h";
            inputAddresses[thumbs[closest].order].delay = values[closest]*1;
        }   
        controlDetailsCalculator();
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
        var shiftX = e.pageX - getCoords(thumbs[closest]).left;        
        var thumbStyle = thumbs[closest].style;

        slider.style.opacity = 1;

        function changeAtMove(e){ 
            isMouseDownOnSlider = 1;
            if (e.pageX !== 0) {
                e.pageX = e.pageX || e.touches[0].pageX;
            }            
            if((e.pageX - shiftX + thumb.offsetWidth/2) < sliderCoords.left){
                values[closest] = min;
                thumbCenters[closest] = 0;
                thumbStyle.left = - (thumb.offsetWidth/2) +'px';      
            } else if((e.pageX - shiftX + thumb.offsetWidth/2) > sliderCoords.right){
                values[closest] = max;
                thumbCenters[closest] = slider.offsetWidth;
                thumbStyle.left = slider.offsetWidth - (thumb.offsetWidth/2) + 'px';
            } else {
                var temp = Math.round((e.pageX - shiftX  + thumb.offsetWidth/2 - sliderCoords.left)/stepLength);
                thumbCenters[closest] = temp*stepLength;
                thumbStyle.left = temp*stepLength - thumb.offsetWidth/2 + 'px';
                values[closest] = min + step*temp;
                values[closest] = values[closest].toFixed(stepDecimals);
                values[closest] = values[closest]*1;    
            }   
            sliderValues[thumbs[closest].order].innerHTML = values[closest] + "h"; 
            inputAddresses[thumbs[closest].order].delay = values[closest]*1; 
            controlDetailsCalculator();
        }

        document.onmousemove = function(e){
            changeAtMove(e);
        }

        document.onmouseup = slider.onmouseup = function(){
            isMouseDownOnSlider = 0;
            isMouseOverSlider ? slider.style.opacity = 1: slider.style.opacity = .7;
            thumbs = makeElementFirst(thumbs, closest);
            thumbCenters = makeElementFirst(thumbCenters, closest);
            values = makeElementFirst(values, closest);
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
        var shiftX = e.pageX - getCoords(thumbs[closest]).left;        
        var thumbStyle = thumbs[closest].style;

        slider.style.opacity = 1;

        function changeAtMove(e){ 
            isMouseDownOnSlider = 1;  
            e.pageX = e.pageX || e.touches[0].pageX;         
            if((e.pageX - shiftX + thumb.offsetWidth/2) < sliderCoords.left){
                values[closest] = min;
                thumbCenters[closest] = 0;
                thumbStyle.left = - (thumb.offsetWidth/2) +'px';      
            } else if((e.pageX - shiftX + thumb.offsetWidth/2) > sliderCoords.right){
                values[closest] = max;
                thumbCenters[closest] = slider.offsetWidth;
                thumbStyle.left = slider.offsetWidth - (thumb.offsetWidth/2) + 'px';
            } else {
                var temp = Math.round((e.pageX - shiftX  + thumb.offsetWidth/2 - sliderCoords.left)/stepLength);
                thumbCenters[closest] = temp*stepLength;
                thumbStyle.left = temp*stepLength - thumb.offsetWidth/2 + 'px';
                values[closest] = min + step*temp;
                values[closest] = values[closest].toFixed(stepDecimals);
                values[closest] = values[closest]*1;    
            }   
            sliderValues[thumbs[closest].order].innerHTML = values[closest] + "h"; 
            inputAddresses[thumbs[closest].order].delay = values[closest]*1; 
            controlDetailsCalculator();
        }

        document.ontouchmove = function(e){
            changeAtMove(e);
        }

        document.ontouchend = slider.ontouchend = function(){
            isMouseDownOnSlider = 0;
            isMouseOverSlider ? slider.style.opacity = 1: slider.style.opacity = .7;
            thumbs = makeElementFirst(thumbs, closest);
            thumbCenters = makeElementFirst(thumbCenters, closest);
            values = makeElementFirst(values, closest);
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

    function makeElementFirst(Array, index){
        var change = 0;
        if (index == 0) {
            return Array;}
        else {
            for (var i = index; i>0; i--) {
                change = Array[i-1];
                Array[i-1] = Array[i];
                Array[i] = change;
            }
            return Array;
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

