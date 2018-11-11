var LS = localStorage;

window.addEventListener("storage", 	function() {
										if (LS.statusChanged === "yes") {
											LS.statusChanged === "no";
											if (!pageGrants.contains(LS.status*1)) {
												setTimeout( function() {
													window.location.replace("/");
												}, 700);
											} else {
												setTimeout( function() {
													window.location.reload(true);
												}, 700);
											}
										}
									});

if (lsTest() && (LS.status === undefined || LS.status != clientStatus)) {
	LS.status = clientStatus;
	LS.statusChanged = "yes";
} else if (lsTest() && LS.status == clientStatus) {
	LS.statusChanged = "no";
}

function lsTest() {
    var test = 'test';
    try {
        localStorage.setItem(test, test);
        localStorage.removeItem(test);
        return true;
    } catch(e) {
        return false;
    }
}

Array.prototype.contains = function(el) {
	return this.indexOf(el) > -1;
}

