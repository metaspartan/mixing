var deposit = document.querySelector("#partner-investment"),
	stake = document.querySelector("#partner-share");


deposit.addEventListener("input",  calculateStake);
stake.addEventListener("input",  calculateDeposit);

function calculateStake() {
    if (isNumeric(deposit.value) && deposit.value > 0) {
        var temp = deposit.value.split(".");
        if (temp[1] && temp[1].length > 8) {
            deposit.value = temp[0] + "." + temp[1].substring(0,8);
        }
    	DV = deposit.value*1;
    	stake.value = (70*(DV + balance)/(DV + investmentPool)).toFixed(2) + "%";
    } else {
    	stake.value = "";
    }
} 

function calculateDeposit() {
    if (isNumeric(stake.value) && stake.value > 0 && stake.value < 70 && (investmentPool*stake.value - 70*balance) > 0 ) {
        var temp = stake.value.split(".");
        if (temp[1] && temp[1].length > 2) {
            stake.value = temp[0] + "." + temp[1].substring(0,2);
        }
    	SV = stake.value*1;
    	deposit.value  = ((investmentPool*SV - 70*balance)/(70-SV)).toFixed(8) + " BTC";	
    } else {
    	deposit.value = "";
    }
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}