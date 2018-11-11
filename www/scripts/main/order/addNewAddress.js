function addNewIncomingAddress() {
	if (!start && incomingAddressesNumber <= maxIncomingAddresses) {
		document.querySelector(".add-incoming-address").onclick = function() {return;};
		this.innerHTML = "<img class = 'add-address-animation' src = '/images/spinner_small.svg'>";
		var boundary       = String(Math.random()).slice(2);
		var boundaryMiddle = '--' + boundary + '\r\n';
		var boundaryLast   = '--' + boundary + '--\r\n'

		var body = ['\r\n'];
		for (var key in order) {
			body.push('Content-Disposition: form-data; name="' + key + '"\r\n\r\n' + order[key] + '\r\n');
		}

		body = body.join(boundaryMiddle) + boundaryLast;	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/operation/handleClientOrder', true);

		xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
		xhr.onreadystatechange = function() {
			if (this.readyState != 4) return;
			if (xhr.status === 200) {
				if (this.responseText !== "Incorrect order") {
					var response = JSON.parse(this.responseText);

					if (response["orderStatus"] == "tooHighMinIncome" || 
						response["orderStatus"] == "noAvailableCoins") {
						document.querySelector(".send-coins").innerHTML = "Seems like you have sent us a lot of coins. " + 
					                                                      "Please do not send more, we are not able to correctly " + 
					                                                      "handle any additional transactions with your BitWhisk code.";
						document.querySelector(".incoming-addresses").removeChild(document.querySelector(".add-incoming-address"));
					}

					if (response["orderStatus"] == "somethingWrong") {
						document.querySelector(".send-coins").innerHTML = "Due to internal error occured on our servers " + 
						                                                  "the generation of a new incoming address has failed. " + 
						                                                  "Repair crew is on the way!";
						document.querySelector(".incoming-addresses").removeChild(document.querySelector(".add-incoming-address"));
					}

					if (response["orderStatus"] == "OK") {
						document.querySelector(".add-incoming-address").innerHTML = "Add incoming address";			
					    var newLi 	      = document.createElement("li"),
						    newSpan 	  = document.createElement("span");

						newLi.className   = "el-list-incoming";				    
						newSpan.className = "generated-address";

						newSpan.minimum   = response["minimumIncome"].toFixed(8);
						newSpan.address   = response[  "newAddress" ];
						newSpan.letter    = response[   "letter"    ];
						newSpan.success   = false;
						newSpan.active    = true;
						newSpan.innerHTML = newSpan.address;

						newSpan.onmouseover = function() {
							if (this.active) {
								this.style.cursor = "text";
							} else {
								this.style.color  = "#EBE8E8";
								this.style.cursor = "pointer";
							}
						}

						newSpan.onmouseout = function() {
							if (this.active) {return;}
							else {
								this.style.color  = "#0d1111";
								this.style.cursor = "text";
							}
						}

						newSpan.onclick = function() {
							if (this.active) {return;}
							if (this.success) {
								document.querySelector(".qr-img").src = "/images/success.svg";
							} else {
								document.querySelector(".qr-img").src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=" + this.address;	
							}				
							var incomingAddresses = document.querySelectorAll(".generated-address");
							for (var i = 0; i<incomingAddresses.length; i++) {
								incomingAddresses[i].active      = false;
								incomingAddresses[i].style.color = "#0d1111";
							}
							this.style.cursor = "text";
							this.style.color = "#EBE8E8";
							this.active = true;
							if (document.querySelector(".minimum") !== null) {
								document.querySelector(".minimum").innerHTML = this.minimum;
							}
						}

						document.querySelector(".list-incoming").appendChild(newLi);
						newLi.appendChild(newSpan);
						
						var incomingAddresses = document.querySelectorAll(".generated-address");

						for (var i = 0; i<incomingAddresses.length-1;i++) {
							incomingAddresses[i].active 	 = false;
							incomingAddresses[i].style.color = "#0d1111";
						}

						if (incomingAddresses.length == 2) {
							document.querySelector(".please-letter").innerHTML = "We generated the letters of guarantee for you, please save it:";
							var newLiLetter1       = document.createElement("li"),
								newLiLetter2       = document.createElement("li"),
								newLetterHr1       = document.createElement("a"),
								newLetterHr2       = document.createElement("a");

							newLiLetter1.className = "el-list-letters";
							newLiLetter2.className = "el-list-letters";
							newLetterHr1.className = "letter-outside";
							newLetterHr2.className = "letter-outside";

							newLetterHr1.innerHTML = "Letter of Guarantee #1";
							newLetterHr2.innerHTML = "Letter of Guarantee #2";
							newLetterHr1.download  = "Letter of Guarantee #1";
							newLetterHr2.download  = "Letter of Guarantee #2";
							newLetterHr1.href      = window.URL.createObjectURL(new Blob([incomingAddresses[0].letter], {type: "text/plain"}));
							newLetterHr2.href      = window.URL.createObjectURL(new Blob([incomingAddresses[1].letter], {type: "text/plain"}));

							document.querySelector(".list-letters").appendChild(newLiLetter1);
							newLiLetter1.appendChild(newLetterHr1);
							document.querySelector(".list-letters").appendChild(newLiLetter2);
							newLiLetter2.appendChild(newLetterHr2);

						} else {
							var newLiLetter       = document.createElement("li"),
								newLetterHr       = document.createElement("a");

							newLiLetter.className = "el-list-letters";
							newLetterHr.className = "letter-outside";

							newLetterHr.innerHTML = "Letter Of Guarantee #" + incomingAddresses.length;
							newLetterHr.download  = "Letter Of Guarantee #" + incomingAddresses.length;
							newLetterHr.href      = window.URL.createObjectURL(new Blob([incomingAddresses[incomingAddresses.length-1].letter], {type: "text/plain"}));

							document.querySelector(".list-letters").appendChild(newLiLetter);
							newLiLetter.appendChild(newLetterHr);
						}

						document.querySelector(".qr-img").src         = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=" + newSpan.address;
						document.querySelector(".minimum").innerHTML  = newSpan.minimum;
						document.querySelector(".maximum").innerHTML  = response["balance"].toFixed(8);
						document.querySelector(".add-incoming-address").onclick = addNewIncomingAddress;
						incomingAddressesNumber++;
						if (incomingAddressesNumber == maxIncomingAddresses) {
							document.querySelector(".incoming-addresses").removeChild(document.querySelector(".add-incoming-address"));
						}
					}
				}
			} else {
				if (xhr.status === 429) {
					document.querySelector(".send-coins").innerHTML = "It seems that you have made too many requests " + 
				                                                  	  "to our server. Please take a break.";
					document.querySelector(".incoming-addresses").removeChild(document.querySelector(".add-incoming-address"));
				} else {
					document.querySelector(".send-coins").innerHTML = "Due to internal error occured on our servers " + 
				                                                  	  "the generation of a new incoming address has failed. " + 
				                                                      "Repair crew is on the way!";
					document.querySelector(".incoming-addresses").removeChild(document.querySelector(".add-incoming-address"));
				}
				
			}       
		}
		xhr.send(body);
	} else {
		return;
	}
}

