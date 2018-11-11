(function() {
    headerButton = document.querySelector(".header-button");
    headerButton.addEventListener("click", headerMenuButton);

    function headerMenuButton() {
        var x = document.querySelector(".header-mobile-right-menu"),
            z = document.querySelector(".header");

        if (!headerButton.classList.contains("responsive")){
            x.classList.add("responsive");
            z.classList.add("responsive");
            menuPoints = document.querySelectorAll(".mobile-menu-element");
            for (var i = 0; i < menuPoints.length; i++) {
                menuPoints[i].className += " responsive";
            }
            headerButton.classList.add("responsive");
        } else {    
            x.classList.remove("responsive");
            menuPoints = document.querySelectorAll(".mobile-menu-element");
            for (var i = 0; i < menuPoints.length; i++) {
                menuPoints[i].className = "mobile-menu-element";
            }
            headerButton.classList.remove("responsive");
            setTimeout(function(){ z.className = "header"; }, 300);
        }

        var n = 1;
        var int = setInterval(function () {    	
                if (n >= 300) {
                    clearInterval(int);
                }
                n = n + 1;
                var donationContentCoords = getCoords(document.querySelector(".auth-content")),
        			headerCoords          = getCoords(document.querySelector(".header-mobile-right-menu")),
        			footerCoords          = getCoords(document.querySelector(".footer"));

                if ((window.innerHeight - headerCoords.bottom - (footerCoords.bottom-footerCoords.top)) - (donationContentCoords.bottom - donationContentCoords.top) > 10) {
        			document.querySelector(".auth-content").style.marginTop = ((window.innerHeight - headerCoords.bottom - (footerCoords.bottom-footerCoords.top)) - (donationContentCoords.bottom - donationContentCoords.top))/2 + "px"; 
        		} else {
        			document.querySelector(".auth-content").style.marginTop = ((footerCoords.top - headerCoords.bottom) - (donationContentCoords.bottom - donationContentCoords.top))/2 + "px"; 
        		}

        		function getCoords(elem){
        	        var box = elem.getBoundingClientRect();
        	        return {
        	            top:    box.top    + pageYOffset,
        	            bottom: box.bottom + pageYOffset
        	        };
        	    }
            }, 1);
    }
})();

