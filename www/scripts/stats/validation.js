calendar = {
	months: {
		0  : "January",
		1  : "February",
		2  : "March",
		3  : "April",
		4  : "May",
		5  : "June",
		6  : "July",
		7  : "August",
		8  : "September",
		9  : "October",
		10 : "November", 
		11 : "December"
	},

	today: new Date(),
	button: document.querySelector(".continue-button-disabled"),
	loadScreen: document.querySelector(".load-in-progress"),
	errorPopup: document.querySelector(".too-many-requests-popup"),
	closeErrorPopup: document.querySelector(".close-too-many-requests-popup"),
	statusPopup: document.querySelector(".status-summary-popup"),
	closeStatusPopup: document.querySelector(".close-status-summary-popup"),
	statsPeriod: document.querySelector("#stat-period"),
	statsSum: document.querySelector("#stat-sum"),

	Init: function() {
		this.from = document.querySelector("#calendar-from");
		this.from.context = "from";
		this.from.shown = false;
		this.from.month = this.today.getMonth();
		this.from.year = this.today.getFullYear();
		this.from.forward = document.querySelector("#calendar-from .month-forward-container");
		this.from.back = document.querySelector("#calendar-from .month-back-container");
		this.from.monthName = document.querySelector("#calendar-from .month-name");
		this.from.days = document.querySelector("#calendar-from .calendar-days");
		this.fromDate = document.querySelector("#from-date");

		this.to = document.querySelector("#calendar-to");
		this.to.context = "to";
		this.to.shown = false;
		this.to.month = this.today.getMonth();
		this.to.year = this.today.getFullYear();
		this.to.forward = document.querySelector("#calendar-to .month-forward-container");
		this.to.back = document.querySelector("#calendar-to .month-back-container");
		this.to.monthName = document.querySelector("#calendar-to .month-name");
		this.to.days = document.querySelector("#calendar-to .calendar-days");
		this.toDate = document.querySelector("#to-date");

		this.setupListeners();
	},

	setupListeners: function() {
		var _self = this;

		this.fromDate.addEventListener("focus", function() {
			var coords = getCoords(this);
			_self.toDate.disabled = false;
			_self.to.style.display = "none";
			fillCalendar(_self.from);
			_self.from.style.visibility = "hidden";
			_self.from.style.display = "block";
			_self.from.style.top = coords.top + "px";
			_self.from.style.left = coords.left + "px";
			_self.from.style.visibility = "visible";
			_self.from.shown = true;
			this.disabled = true;
		});

		this.toDate.addEventListener("focus", function() {
			var coords = getCoords(this);
			_self.fromDate.disabled = false;
			_self.from.style.display = "none";
			fillCalendar(_self.to); 
			_self.to.style.visibility = "hidden";
			_self.to.style.display = "block";
			_self.to.style.top = coords.top + "px";
			_self.to.style.left = coords.right - 210 + "px";
			_self.to.style.visibility = "visible";
			_self.to.shown = true;
			this.disabled = true;
		});

		this.from.forward.addEventListener("click", function() {
			var calendar = _self.from;
			calendar.month = (calendar.month+1).mod(12);
			if (calendar.month == 0) calendar.year += 1;
			fillCalendar(calendar);
		});

		this.from.back.addEventListener("click", function() {
			var calendar = _self.from;
			calendar.month = (calendar.month-1).mod(12);
			if (calendar.month == 11) calendar.year -= 1;
			fillCalendar(calendar);
		});

		this.to.forward.addEventListener("click", function() {
			var calendar = _self.to;
			calendar.month = (calendar.month+1).mod(12);
			if (calendar.month == 0) calendar.year += 1;
			fillCalendar(calendar);
		});

		this.to.back.addEventListener("click", function() {
			var calendar = _self.to;
			calendar.month = (calendar.month-1).mod(12);
			if (calendar.month == 11) calendar.year -= 1;
			fillCalendar(calendar);
		});

		window.addEventListener("click", function(event) {
			if (!_self.from.shown) {
				return;
			}

			if (!isDescendant(_self.from, event.target)) {
				_self.fromDate.disabled = false;
				_self.from.style.display = "none";
				if (_self.fromDate.value == "") {
					_self.from.month = _self.today.getMonth();
					_self.from.year = _self.today.getFullYear();
				} else {
					var parts = _self.fromDate.value.split("/"),
						month = parts[1]*1 - 1,
						year = parts[2]*1;

					_self.from.month = month;
					_self.from.year = year;
				}
				_self.from.shown = false;
				return;
			}

			if (event.target.classList.contains("active")) {
				_self.fromDate.disabled = false;
				_self.fromDate.value = event.target.dateString;
				_self.from.style.display = "none";
				_self.from.shown = false;
				_self.defineState();
			}
		});

		window.addEventListener("click", function(event) {
			if (!_self.to.shown) {
				return;
			}

			if (!isDescendant(_self.to, event.target)) {
				_self.toDate.disabled = false;
				_self.to.style.display = "none";
				if (_self.toDate.value == "") {
					_self.to.month = _self.today.getMonth();
					_self.to.year = _self.today.getFullYear();
				} else {
					var parts = _self.toDate.value.split("/"),
						month = parts[1]*1 - 1,
						year = parts[2]*1;

					_self.to.month = month;
					_self.to.year = year;
				}
				_self.to.shown = false;
				return;
			}

			if (event.target.classList.contains("active")) {
				_self.toDate.disabled = false;
				_self.toDate.value = event.target.dateString;
				_self.to.style.display = "none";
				_self.to.shown = false;
				_self.defineState();
			}
		});

		window.addEventListener("click", function(event) {
			if (event.target == _self.errorPopup) {
		        _self.errorPopup.style.display = "none";
		    }
		    if (event.target == _self.statusPopup) {
		        _self.statusPopup.style.display = "none";
		    }
		});

		this.closeErrorPopup.addEventListener("click", function() {
			_self.errorPopup.style.display = "none";
		});

		this.closeStatusPopup.addEventListener("click", function() {
			_self.statusPopup.style.display = "none";
		});

		window.addEventListener("resize", function(event) {
			if (!_self.from.shown) {
				return;
			}
			var coords = getCoords(_self.fromDate);
			_self.from.style.top = coords.top + "px";
			_self.from.style.left = coords.left + "px";
		});

		window.addEventListener("resize", function(event) {
			if (!_self.to.shown) {
				return;
			}
			coords = getCoords(_self.toDate);
			_self.to.style.top = coords.top + "px";
			_self.to.style.left = coords.right - 210 + "px";
			// 210px is a width of calendar
		});

		function fillCalendar(elem) {
			elem.monthName.innerHTML = _self.months[elem.month] + " " + elem.year;
			var firstDay = new Date(elem.year, elem.month, 1),
				weekDay = firstDay.getDay(),
				lastDay = new Date(elem.year, (elem.month + 1)%12, 0),
				monthDaysNumber = lastDay.getDate(),
				emptyDays = (weekDay+6)%7;

			while (elem.days.firstChild) {
			    elem.days.removeChild(elem.days.firstChild);
			}

			for (var i = 0; i < emptyDays; i++) {
				var divEmpty = document.createElement("div");
				divEmpty.classList.add("calendar-days-number");
				elem.days.appendChild(divEmpty);
			}

			for (i = 1; i <= monthDaysNumber; i++) {
				var divFull = document.createElement("div"),
					date = (i < 10) ? "0" + i : i,
					month = (elem.month < 9) ? "0" + (elem.month + 1) : elem.month + 1;
				divFull.innerHTML = i;

				if (checkDateAvailability(i, elem.month, elem.year, elem.context)) {
					divFull.dateString = date + "/" + month + "/" + elem.year;
					divFull.classList.add("calendar-days-number");
					divFull.classList.add("active");
				} else {
					divFull.classList.add("calendar-days-number");
					divFull.classList.add("non-active");
				}
				

				elem.days.appendChild(divFull);
			}

			function checkDateAvailability(day, month, year, context /*FROM or TO*/) {
				if (year > _self.today.getFullYear()) {
					return false;
				}
				if (year == _self.today.getFullYear() && month > _self.today.getMonth()) {
					return false;
				}
				if (year == _self.today.getFullYear() && month == _self.today.getMonth() && day > _self.today.getDate()) {
					return false;
				}

				if (context == "from") {
					if (_self.toDate.value == "") {
						return true;
					} else {
						var dateArr = _self.toDate.value.split("/"),
							toDate = new Date(dateArr[2], dateArr[1]-1, dateArr[0]),
							checkedDate = new Date(year, month, day);

						if (toDate.getTime() < checkedDate.getTime()) {
							return false;
						} else {
							return true;
						}
					}
				}

				if (context == "to") {
					if (_self.fromDate.value == "") {
						return true;
					} else {
						var dateArr = _self.fromDate.value.split("/");
							fromDate = new Date(dateArr[2], dateArr[1]-1, dateArr[0]),
							checkedDate = new Date(year, month, day);

						if (fromDate.getTime() > checkedDate.getTime()) {
							return false;
						} else {
							return true;
						}
					}
				}
			}
		};

		function isDescendant(parent, child) {
			var node = child.parentNode;
			while (node != null) {
				if (node == parent) {
				    return true;
				}
				node = node.parentNode;
			}
			return false;
		};

		function getCoords(elem) {
		    var box = elem.getBoundingClientRect();
		    return {
		        top:    box.top    + pageYOffset,
		        bottom: box.bottom + pageYOffset,
		        left: 	box.left + pageXOffset,
		        right: 	box.right + pageXOffset
		    };
		};

		this.button.addEventListener("click", function() {
			if (!_self.defineState()) {
				return;
			}
			_self.loadScreen.style.display = "block";
			var boundary       = String(Math.random()).slice(2),
				boundaryMiddle = '--' + boundary + '\r\n',
				boundaryLast   = '--' + boundary + '--\r\n';

			var body = ['\r\n'];	
			body.push('Content-Disposition: form-data; name="sdate"\r\n\r\n' + _self.fromDate.value + '\r\n');
			body.push('Content-Disposition: form-data; name="edate"\r\n\r\n' + _self.toDate.value + '\r\n');
			body = body.join(boundaryMiddle) + boundaryLast;
			
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/auth/showStats', true);
			xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
			xhr.onreadystatechange = function() {
				if (this.readyState != 4) return;
				_self.loadScreen.style.display = "none";
				if (this.status == 200) {
					var response = JSON.parse(this.responseText);
					if (!response.success && response.reason == "permissions") {
						window.location.replace("/403");
					}
					if (!response.success && response.reason == "internal") {
						_self.errorPopup.style.display = "block";
					}
					if (response.success) {
						if (_self.fromDate.value != _self.toDate.value) {
							_self.statsPeriod.innerHTML = _self.fromDate.value + " - " + _self.toDate.value;
						} else {
							_self.statsPeriod.innerHTML = _self.fromDate.value;
						}
						_self.fromDate.value = "";
						_self.toDate.value = "";
						_self.defineState();
						_self.statsSum.innerHTML = response.sum + " BTC";
						_self.statusPopup.style.display = "block";
					}
				} else {
					_self.errorPopup.style.display = "block";
				}
			}
			xhr.send(body);
		});
	},

	defineState: function() {
		var _self = calendar,
			dateRegex = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
		
		setDisabled();
		if (!dateRegex.test(_self.fromDate.value) || !dateRegex.test(_self.toDate.value)) {
			return false;
		}

		var dateArr = _self.fromDate.value.split("/"),
			fromDate = new Date(dateArr[2], dateArr[1]-1, dateArr[0]),
			dateArr = _self.toDate.value.split("/"),
			toDate = new Date(dateArr[2], dateArr[1]-1, dateArr[0]);

		if (fromDate.getTime() > toDate.getTime()) {
			return false;
		}

		setEnabled();
		return true;
		

		function setEnabled() {
			_self.button.classList.remove("continue-button-disabled");
			_self.button.classList.add("continue-button");
		}

		function setDisabled() {
			_self.button.classList.remove("continue-button");
			_self.button.classList.add("continue-button-disabled");
		}
	}
};

calendar.Init();

Number.prototype.mod = function(n) {
    return ((this%n)+n)%n;
};
