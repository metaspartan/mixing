var signoutDesktop = document.querySelector("#desktop-signout"),
	signoutMobile = document.querySelector("#mobile-signout"),
	signoutButton = document.querySelector(".signout-button"),
	popup = document.querySelector(".signout-popup"),
	closePopup = document.querySelector(".close-signout-popup");

window.addEventListener("click", function(event) {
								    if (event.target == popup) {
								        popup.style.display = "none";
								    }
								});

closePopup.onclick = function() {
    popup.style.display = "none";
}

signoutMobile.onclick = function(event) {
	event.preventDefault();
	popup.style.display = "block";
}

signoutDesktop.onclick = function(event) {
	event.preventDefault();
	popup.style.display = "block";
}

signoutButton.onclick = function() {
	if (lsTest()) {
		localStorage.status = 0;
		localStorage.statusChanged = "yes";
	}
	window.location.replace("/auth/signout");
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

