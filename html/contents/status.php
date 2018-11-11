<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>

<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>Order status</p>
		    <div id = "js-enabled" style = "display:none">
		        <div class = "input-container wide">
		            <input class = "signup-input wide text-center" type="text" maxlength = "74" autocomplete="off" placeholder = "Generated incoming addresses">
		        </div>

		        <div class = "intro-start status-bottom-row">
		        	<div class = "bitcode-status-wrapper">
			            <input class = "input-bitcode" type = "text" maxlength = "6" placeholder = "BitWhisk code">
			        </div>
		            <button class = "continue-button-disabled status-button">Check</a>
		        </div>
		    </div>

		    <div id = "js-disabled">
		        <form action = "/operation/jsfreeStatus" target = "_blank" method = "post">
		        	<div class = "input-container wide">
			            <input class = "signup-input wide text-center" name="incomingAddress" type="text" maxlength = "74" autocomplete="off" placeholder = "Generated incoming addresses">
			        </div>

			        <div class = "intro-start status-bottom-row">
			        	<div class = "bitcode-status-wrapper">
				            <input class = "input-bitcode" type = "text" maxlength = "6" name = "code" placeholder = "BitWhisk code">
				        </div>
			            <button class = "continue-button status-button">Check</a>
			        </div>
		            <p class = "status-js-free-caption">JS-free version</p>
		        </form>
		    </div>

		    <script> 
		        document.querySelector("#js-enabled").style.display = "block";
		        document.querySelector("#js-disabled").style.display = "none";
		    </script>

		    <div class = "error"> 
		        <a>Wrong data</a>
		    </div>
		</div>
		<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>

		<div class = "too-many-requests-popup">
		    <div class = "too-many-requests-popup-content">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Too many requests</p>
		        <p class = "too-many-requests-main-text">                    
		        In order to prevent different kinds of DoS attacks on BitWhisk, we limit the number of 
		        requests made to our servers. It seems you have exceeded this limit. In a little while
		        you will be able to use our service in a regular mode.</p> 
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/too-many-requests.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Thank you for using BitWhisk.</p>
		    </div>
		</div>

		<div class = "status-error-popup">
		    <div class = "status-error-popup-content">
		        <span class = "close-status-error-popup"></span>
		        <p class = "status-error-please">Server error</p>
		        <p class = "status-error-main-text">                    
		        	Due to an internal error our server refused to define the status or your order. 
                    This happens quite rarely, there is no your fault here. 
                    We will be thankful if you notify us about this incident via 
                    <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>
		    	</p> 
		        <div class = "status-error-illustration-parent">
		            <img class = "status-error-illustration-content" src = "/images/server-error.svg">
		        </div>
		        <p class = "status-error-goodbye"><br>Thank you for using BitWhisk.</p>
		    </div>
		</div>

		<div class = "status-noorder-popup">
		    <div class = "status-noorder-popup-content">
		        <span class = "close-status-noorder-popup"></span>
		        <p class = "status-noorder-please">Order not found</p>
		        <p class = "status-noorder-main-text">                    
			        We completely delete all information about fully processed mixing requests. 
			        Thus, either your order has been wiped out or never existed. 
			        Open the Letter of Guarantee and check the search pattern for any mistypes. 
			        If you are still sure that something goes wrong, please write to our
			        <a href = "mailto:contact@bitwhisk.io" class = "faq-href">mailbox</a>.
		    	</p> 
		        <div class = "status-noorder-illustration-parent">
		            <img class = "status-noorder-illustration-content" src = "/images/notfound.svg">
		        </div>
		        <p class = "status-noorder-goodbye"><br>Thank you for using BitWhisk.</p>
		    </div>
		</div>

		<div class = "status-empty-order-popup">
		    <div class = "status-empty-order-popup-content">
		        <span class = "close-status-empty-order-popup"></span>
		        <p class = "status-empty-order-please">Nothing to mix</p>
		        <p class = "status-empty-order-main-text">
			        You haven't sent any coins to the generated address. Let us recall that
			        minimum incoming amount for your order is <span class = "empty-minIncome"></span> BTC, while current maximum 
			        incoming amount for your BitWhisk code is <span class = "empty-maxIncome"></span> BTC. Please mind that 
			        any payments to the generated address after <span class="empty-date-until"></span> will be ignored.
		    	</p> 
		        <div class = "status-empty-order-illustration-parent">
		            <img class = "status-noorder-illustration-content" src = "/images/empty-order.svg">
		        </div>
		        <p class = "status-empty-order-goodbye"><br>Thank you for using BitWhisk.</p>
		    </div>
		</div>

		<div class = "status-summary-popup">
		    <div class = "status-summary-popup-content">
		        <span class = "close-status-summary-popup"></span> 
		        <p class = "status-summary-please">Order summary</p>                             
		        <div class = "status-summary-main-text">
		            <a class = "some-error">Some error occured while handling your order. Don't worry, your coins are not lost, for some reason they've got stuck at our wallet. Please,
		            contact our support as soon as possible.</a>
		            <a class = "address-active">Please mind that any payments to the generated address after <span class="full-date-until"></span> will be ignored.</a>
		            <a class = "address-non-active-pending">The generated address is not active since <span class="full-date-until"></span>. The data will be deleted right after the execution of your delayed payments.</a>
		            <a class = "address-non-active-no-pending">Your order has been successfully completed, soon all the information regarding it will be deleted from our server.</a>
		        </div>

		        <table class="order-summary-table">
		            <thead>
		                <th class="order-summary-table-th" colspan="2">Incoming payments</th>
		            </thead>
		            <tbody>
		                <tr class ="row-unconfirmed">
		                    <td class="order-summary-table-td">Unconfirmed</td>
		                    <td class="order-summary-table-td"><span class="unconfirmed"></span> BTC</td>
		                </tr>
		                <tr class ="row-one-confirmation">
		                    <td class="order-summary-table-td">One confirmation</td>
		                    <td class="order-summary-table-td"><span class="one-confirmation"></span> BTC</td>
		                </tr>
		                <tr class = "row-received">
		                    <td class="order-summary-table-td">Received amount</td>
		                    <td class="order-summary-table-td"><span class="received"></span> BTC</td>
		                </tr>
		            </tbody>
		        </table>

		        <div class = "status-summary-main-text">
		            <a class = "max-ok">Let us recall that minimum incoming amount for your order is <span class="minimum-amount"></span> BTC, while current maximum incoming amount corresponding to your BitWhisk code is <span class="maximum-amount"></span> BTC. Miner's fee rate for outcoming transactions is <span class="customer-miner-fee-rate"></span> sat/B.</a>
		            <a class = "max-not-ok">Let us recall that minimum incoming amount for your order is <span class="minimum-amount"></span> BTC. You have exceeded the maximum incoming amount corresponding to your BitWhisk code.</a>
		        </div>

		        <div class = "outcoming-summary">
		            <div class = "status-summary-main-text">
		                Below is the summary of scheduled and executed payments.
		            </div>   
		        </div>
		        <div class = "status-summary-main-text not-assigned">
		            * Our system has not yet set the payment schedule for some of your addresses. No need to worry, the payments will be scheduled right away.
		        </div>  

		        <div class = "status-summary-main-text">
		            <a class = "unhandled-note">Attention, you sent us <span class = "unhandled-amount"></span> BTC which we will not handle. Please, contact our support.</a>
		        </div>                             

		        <p class = "status-summary-goodbye">Thank you for using BitWhisk.</p>
		    </div>
		</div>

		<div class = "load-in-progress">
		    <div class = "animation-content">
		        <img src = "/images/spinner.svg">
		    </div>
		</div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/status/header.js"></script>
<script src="/scripts/status/windowResize.js"></script>
<script src="/scripts/status/main.js"></script>

</body>
</html>
