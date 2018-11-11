var ref1  = document.querySelector("#ref-1");
	ref2  = document.querySelector("#ref-2");
	ref3  = document.querySelector("#ref-3");
	ref4  = document.querySelector("#ref-4");
	ref5  = document.querySelector("#ref-5");
	ref6  = document.querySelector("#ref-6");
	desc1 = document.querySelector("#fast-and-secure");
	desc2 = document.querySelector("#best-practices");
	desc3 = document.querySelector("#two-mixing-regimes");
	desc4 = document.querySelector("#no-javascript");
	desc5 = document.querySelector("#provable-obligations");
	desc6 = document.querySelector("#api");

ref1.onclick = function(event) {
	var isShown = desc2.visible || desc3.visible || desc4.visible || desc5.visible || desc6.visible;
	desc2.style.maxHeight = "0px";
	desc2.visible = false;
	desc3.style.maxHeight = "0px";
	desc3.visible = false;
	desc4.style.maxHeight = "0px";
	desc4.visible = false;
	desc5.style.maxHeight = "0px";
	desc5.visible = false;
	desc6.style.maxHeight = "0px";
	desc6.visible = false;
	if (isShown) {
		setTimeout(function() {
			promise = expand();
			promise.then(
				result => {
					if (result == "delete") {
						ref1.removeAttribute("href");
					} else {
						var stateObj = { foo: "bar" };
						history.replaceState(stateObj, "", "https://bitwhisk.io/features");
						ref1.href = "#" + desc1.id;
					}
				}
			)
		}, 800);
	} else {
		promise = expand();
		promise.then(
			result => {
				if (result == "delete") {
					ref1.removeAttribute("href");
				} else {
					var stateObj = { foo: "bar" };
					history.replaceState(stateObj, "", "https://bitwhisk.io/features");
					ref1.href = "#" + desc1.id;
				}
			}
		)
	}

	function expand() {
		var promise = new Promise((resolve, reject) => {
			if (!desc1.visible) {
				setTimeout(function() {
					resolve("delete");
				}, 800);
				desc1.style.maxHeight = "400px";
				desc1.visible = true;
			} else {
				setTimeout(function() {
					resolve("add");
				}, 800);
				desc1.style.maxHeight = "0px";
				desc1.visible = false;
			}
		});
		return promise;
	}
}

ref2.onclick = function(event) {
	var isShown = desc1.visible || desc3.visible || desc4.visible || desc5.visible || desc6.visible;
	desc1.style.maxHeight = "0px";
	desc1.visible = false;
	desc3.style.maxHeight = "0px";
	desc3.visible = false;
	desc4.style.maxHeight = "0px";
	desc4.visible = false;
	desc5.style.maxHeight = "0px";
	desc5.visible = false;
	desc6.style.maxHeight = "0px";
	desc6.visible = false;
	if (isShown) {
		setTimeout(function() {
			promise = expand();
			promise.then(
				result => {
					if (result == "delete") {
						ref2.removeAttribute("href");
					} else {
						var stateObj = { foo: "bar" };
						history.replaceState(stateObj, "", "https://bitwhisk.io/features");
						ref2.href = "#" + desc2.id;
					}
				}
			)
		}, 800);
	} else {
		promise = expand();
		promise.then(
			result => {
				if (result == "delete") {
					ref2.removeAttribute("href");
				} else {
					var stateObj = { foo: "bar" };
					history.replaceState(stateObj, "", "https://bitwhisk.io/features");
					ref2.href = "#" + desc2.id;
				}
			}
		)
	}

	function expand() {
		var promise = new Promise((resolve, reject) => {
			if (!desc2.visible) {
				setTimeout(function() {
					resolve("delete");
				}, 800);
				desc2.style.maxHeight = "400px";
				desc2.visible = true;
			} else {
				setTimeout(function() {
					resolve("add");
				}, 800);
				desc2.style.maxHeight = "0px";
				desc2.visible = false;
			}
		});
		return promise;
	}
}

ref3.onclick = function(event) {
	var isShown = desc1.visible || desc2.visible || desc4.visible || desc5.visible || desc6.visible;
	desc1.style.maxHeight = "0px";
	desc1.visible = false;
	desc2.style.maxHeight = "0px";
	desc2.visible = false;
	desc4.style.maxHeight = "0px";
	desc4.visible = false;
	desc5.style.maxHeight = "0px";
	desc5.visible = false;
	desc6.style.maxHeight = "0px";
	desc6.visible = false;
	if (isShown) {
		setTimeout(function() {
			promise = expand();
			promise.then(
				result => {
					if (result == "delete") {
						ref3.removeAttribute("href");
					} else {
						var stateObj = { foo: "bar" };
						history.replaceState(stateObj, "", "https://bitwhisk.io/features");
						ref3.href = "#" + desc3.id;
					}
				}
			)
		}, 800);
	} else {
		promise = expand();
		promise.then(
			result => {
				if (result == "delete") {
					ref3.removeAttribute("href");
				} else {
					var stateObj = { foo: "bar" };
					history.replaceState(stateObj, "", "https://bitwhisk.io/features");
					ref3.href = "#" + desc3.id;
				}
			}
		)
	}

	function expand() {
		var promise = new Promise((resolve, reject) => {
			if (!desc3.visible) {
				setTimeout(function() {
					resolve("delete");
				}, 800);
				desc3.style.maxHeight = "400px";
				desc3.visible = true;
			} else {
				setTimeout(function() {
					resolve("add");
				}, 800);
				desc3.style.maxHeight = "0px";
				desc3.visible = false;
			}
		});
		return promise;
	}
}

ref4.onclick = function(event) {
	var isShown = desc1.visible || desc2.visible || desc3.visible || desc5.visible || desc6.visible;
	desc1.style.maxHeight = "0px";
	desc1.visible = false;
	desc2.style.maxHeight = "0px";
	desc2.visible = false;
	desc3.style.maxHeight = "0px";
	desc3.visible = false;
	desc5.style.maxHeight = "0px";
	desc5.visible = false;
	desc6.style.maxHeight = "0px";
	desc6.visible = false;
	if (isShown) {
		setTimeout(function() {
			promise = expand();
			promise.then(
				result => {
					if (result == "delete") {
						ref4.removeAttribute("href");
					} else {
						var stateObj = { foo: "bar" };
						history.replaceState(stateObj, "", "https://bitwhisk.io/features");
						ref4.href = "#" + desc4.id;
					}
				}
			)
		}, 800);
	} else {
		promise = expand();
		promise.then(
			result => {
				if (result == "delete") {
					ref4.removeAttribute("href");
				} else {
					var stateObj = { foo: "bar" };
					history.replaceState(stateObj, "", "https://bitwhisk.io/features");
					ref4.href = "#" + desc4.id;
				}
			}
		)
	}

	function expand() {
		var promise = new Promise((resolve, reject) => {
			if (!desc4.visible) {
				setTimeout(function() {
					resolve("delete");
				}, 800);
				desc4.style.maxHeight = "400px";
				desc4.visible = true;
			} else {
				setTimeout(function() {
					resolve("add");
				}, 800);
				desc4.style.maxHeight = "0px";
				desc4.visible = false;
			}
		});
		return promise;
	}
}

ref5.onclick = function(event) {
	var isShown = desc1.visible || desc2.visible || desc3.visible || desc4.visible || desc6.visible;
	desc1.style.maxHeight = "0px";
	desc1.visible = false;
	desc2.style.maxHeight = "0px";
	desc2.visible = false;
	desc3.style.maxHeight = "0px";
	desc3.visible = false;
	desc4.style.maxHeight = "0px";
	desc4.visible = false;
	desc6.style.maxHeight = "0px";
	desc6.visible = false;
	if (isShown) {
		setTimeout(function() {
			promise = expand();
			promise.then(
				result => {
					if (result == "delete") {
						ref5.removeAttribute("href");
					} else {
						var stateObj = { foo: "bar" };
						history.replaceState(stateObj, "", "https://bitwhisk.io/features");
						ref5.href = "#" + desc5.id;
					}
				}
			)
		}, 800);
	} else {
		promise = expand();
		promise.then(
			result => {
				if (result == "delete") {
					ref5.removeAttribute("href");
				} else {
					var stateObj = { foo: "bar" };
					history.replaceState(stateObj, "", "https://bitwhisk.io/features");
					ref5.href = "#" + desc5.id;
				}
			}
		)
	}

	function expand() {
		var promise = new Promise((resolve, reject) => {
			if (!desc5.visible) {
				setTimeout(function() {
					resolve("delete");
				}, 800);
				desc5.style.maxHeight = "400px";
				desc5.visible = true;
			} else {
				setTimeout(function() {
					resolve("add");
				}, 800);
				desc5.style.maxHeight = "0px";
				desc5.visible = false;
			}
		});
		return promise;
	}
}

ref6.onclick = function(event) {
	var isShown = desc1.visible || desc2.visible || desc3.visible || desc4.visible || desc5.visible;
	desc1.style.maxHeight = "0px";
	desc1.visible = false;
	desc2.style.maxHeight = "0px";
	desc2.visible = false;
	desc3.style.maxHeight = "0px";
	desc3.visible = false;
	desc4.style.maxHeight = "0px";
	desc4.visible = false;
	desc5.style.maxHeight = "0px";
	desc5.visible = false;
	if (isShown) {
		setTimeout(function() {
			promise = expand();
			promise.then(
				result => {
					if (result == "delete") {
						ref6.removeAttribute("href");
					} else {
						var stateObj = { foo: "bar" };
						history.replaceState(stateObj, "", "https://bitwhisk.io/features");
						ref6.href = "#" + desc6.id;
					}
				}
			)
		}, 800);
	} else {
		promise = expand();
		promise.then(
			result => {
				if (result == "delete") {
					ref6.removeAttribute("href");
				} else {
					var stateObj = { foo: "bar" };
					history.replaceState(stateObj, "", "https://bitwhisk.io/features");
					ref6.href = "#" + desc6.id;
				}
			}
		)
	}

	function expand() {
		var promise = new Promise((resolve, reject) => {
			if (!desc6.visible) {
				setTimeout(function() {
					resolve("delete");
				}, 800);
				desc6.style.maxHeight = "400px";
				desc6.visible = true;
			} else {
				setTimeout(function() {
					resolve("add");
				}, 800);
				desc6.style.maxHeight = "0px";
				desc6.visible = false;
			}
		});
		return promise;
	}
}