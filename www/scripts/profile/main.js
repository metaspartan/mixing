var errorPopup = document.querySelector("#error-popup"),
    closeErrorPopup = document.querySelector("#close-error-popup"),
    emptyOrderList = document.querySelector("#no-orders-popup"),
    closeEmptyOrderList = document.querySelector("#close-no-orders-popup"),
    orderList = document.querySelector("#order-list-popup"),
    closeOrderList = document.querySelector("#close-order-list-popup"),
    buttonOrders = document.querySelector("#watch-orders"),
	buttonPopup = document.querySelector("#complete-signout"),
	completeSignoutPopup = document.querySelector(".accept-popup"),
	completeSignoutPopupClose = document.querySelector(".close-popup"),
    tbodyList = document.querySelector("#tbody-orders-list"),
	load = document.querySelector(".load-in-progress");

buttonPopup.addEventListener("click", function() {
	completeSignoutPopup.style.display = "block";
});

buttonOrders.addEventListener("click", function() {
	load.style.display = "block";
    var boundary       = String(Math.random()).slice(2),
        boundaryMiddle = '--' + boundary + '\r\n',
        boundaryLast   = '--' + boundary + '--\r\n';

    var body = ['\r\n'];

    body.push('Content-Disposition: form-data; name="login"\r\n\r\n' + login + '\r\n');
    body = body.join(boundaryMiddle) + boundaryLast;
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/operation/listTakeaways', true);
    xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
    xhr.onreadystatechange = function() {
        if (this.readyState != 4) return;
        load.style.display = "none";
        if (this.status === 200) {
            var response = JSON.parse(this.responseText);
            if (!response.success && response.reason == "permissions") {
                window.location.replace("/403");
            }
            if (!response.success && response.reason == "internal") {
                errorPopup.style.display = "block";
            }
            if (response.success && response.description == "empty") {
                emptyOrderList.style.display = "block";
            }
            if (response.success && response.description == "full") {
                tbodyList.innerHTML = "";
                var orders = response.orders,
                    tr,
                    td1,
                    td2,
                    td3,
                    a,
                    b;
                for (var i = 0; i < orders.length; i++) {
                    tr = document.createElement("tr");
                    td1 = document.createElement("td");
                    td2 = document.createElement("td");
                    td3 = document.createElement("td");
                    a = document.createElement("a");
                    b = document.createElement("b");

                    tr.classList.add("row-address");
                    td1.classList.add("order-summary-table-td");
                    a.classList.add("faq-href");
                    a.href = "/mixing/" + orders[i].id;
                    a.target = "_blank";
                    a.innerHTML = orders[i].id.substring(0,3) + "&#8230;" + orders[i].id.substring(orders[i].id.length - 3);
                    b.appendChild(a);
                    td1.appendChild(b);
                    td2.classList.add("order-summary-table-td");
                    td2.innerHTML = orders[i].stash*1 + " BTC";
                    td3.classList.add("order-summary-table-td");
                    td3.innerHTML = orders[i].status == "locked" ? "Waiting for payment" : "Private key is yours";
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tbodyList.appendChild(tr);
                }
                orderList.style.display = "block";
            }
        } else {
            errorPopup.style.display = "block";
        }
    }
    xhr.send(body);
});

window.addEventListener("click", function(event) {
	if (event.target == completeSignoutPopup) {
		completeSignoutPopup.style.display = "none";
	}
	if (event.target == errorPopup) {
		errorPopup.style.display = "none";
	}
	if (event.target == emptyOrderList) {
		emptyOrderList.style.display = "none";
	}
    if (event.target == orderList) {
        orderList.style.display = "none";
    }
});

completeSignoutPopupClose.onclick = function() {
    completeSignoutPopup.style.display = "none";
}

closeErrorPopup.onclick = function() {
    errorPopup.style.display = "none";
}

closeEmptyOrderList.onclick = function() {
    emptyOrderList.style.display = "none";
}

closeOrderList.onclick = function() {
    orderList.style.display = "none";
}
