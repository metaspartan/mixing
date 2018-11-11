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
	}
})();