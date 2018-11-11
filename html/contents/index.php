<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "intro">
		    <div class= "intro-motto">Mix Bitcoins with Whisk</div>

		    <div class = "intro-logo closing-ann">
		        Peace for everyone of you! We need around <b>0.05 BTC</b> to cover server costs for the next three months. If you like our service and want to use it further you may donate any sum of bitcoins to our <a class = "spec-href" href = "/donation">official bitcoin address</a>. If we do not collect the needed amount we will stop the operation soon after 5-th November. 
		    </div>

		    <div class = "intro-logo">
		        <img id="doughnut" src="images/girls_main.png" alt = "" draggable="false">
		    </div>



		    <div class = "intro-info">
		        BitWhisk has started its path as a very simple application providing only 
		        basic functionality of mixing service. Since then the project 
		        had a great deal of development. Please remember, we are always happy to 
		        tell you about our <a class = "faq-href" href = "/features">features</a>
		        and answer all your <a class = "faq-href" href = "/faq">FAQ</a>.
		    </div>

		    <div class = "intro-info text-center">
		        Let's transform Blockchain into complete mess together!
		    </div>

		    <div class = "intro-start" style="display: none;" id = "js-enabled">
		        <button class = "start-button" >Start</button>
		    </div>
		    <div class = "intro-start" id = "js-disabled">
		        <a href="/jsfree">
		            <button class = "start-button">Start</button>
		        </a>
		    </div>
		    <script> 
		        document.querySelector("#js-enabled").style.display = "block";
		        document.querySelector("#js-disabled").style.display = "none";
		    </script>
		</div>

		<div class = "start">
		    <div class = "mix-page-content">
		        <div class = "bitcode-content">
		            <p class = "enter-code">Enter BitWhisk code<span><img class = "question-bitcode" src = "/images/question-mark-gray.svg"></span></p>
		            <div class = "bitcode-wrapper">
		                <input class = "input-bitcode" type = "text" maxlength = "6">
		            </div>

		            <div class = "bitcode-tooltip-content">
		                Don't worry, you will receive a BitWhisk code after your first order. See FAQ for details. <br><br>
		                This code ensures that your previous transactions will never be mixed with new ones. 
		                It also gives you discount on service commission. See Fees for details.</div>
		            <div class = "bitcode-tooltip-arrow">
		            </div>                                   
		        </div>  

		        <div class = "mix-page-invitation">
		            <a>Please specify the details</a>
		        </div>

		        <div class = "mix-content-control">
		            <a class = "add-address">Add address</a> 
		            <a class = "add-delay">Add delay</a>
		        </div>
		        <div class = "mix-content">
		            <div class = "mix-address">
		                <input class = "input-address" type="text" maxlength = "74" autocomplete="off"><span class = "time-delay-declaration"></span><span class = "time-delay-value"></span><span class = "percentage-value"></span>
		            </div>
		        </div>
		        
		        <div class = "sliders">
		            <div class = "fee">
		                <p>Service commission:&nbsp;<span class = "fee-amount"></span><span><img class = "question-fee" src = "/images/question-mark-gray.svg"></span></p>
		                <div class = "fee-tooltip-content">
		                    It is very important to set arbitrary service commission
		                    to prevent amount-based blockchain analysis. See FAQ for details.<br><br>
		                    If you use BitWhisk often, you get the discount. 
		                    See Fees for details.</div>
		                <div class = "fee-tooltip-arrow">
		                </div>
		                <div class = "fee-slider-parent"><div class = "fee-slider"></div></div>
		            </div>

		            <div class="percentage">
		            </div>

		            <div class="delay">
		            </div> 
		        </div>   

		        <div class = "calculator">
		            <a class = "show-calculator">Calculator</a>
		            <p class = "calculator-details"><span class = "currency-switch">Switch to USD</span></p>
		            <div class = "send-block-calculator">
		                <p>You send:</p>
		                <input class = "input-send" type = "text"><span class = "input-send-details"></span>
		            </div>

		            <div class = "receive-block-calculator">
		                <p>You receive:</p>
		                <div class = "receive-address-block">
		                    <input class = "input-receive" type = "text"><span class = "input-receive-details"></span>
		                </div>
		            </div>
		        </div>

		        <table class="calculator-table">
		            <thead>
		                <th class="calculator-table-th"><a class = "satperbyte-th">Miner's fee rate</a></th>
		                <th class="calculator-table-th"><a class = "output-address-fee-th">Output address fee</a></th>
		                <th class="calculator-table-th"><a class = "minimum-calculator-th">Min. incoming amount</a></th>
		            </thead>
		            <tbody>
		                <tr>
		                    <td class="calculator-table-td"><input class = "input-miner-rate" type = "text" maxlength = "3"> sat/B</td>
		                    <td class="calculator-table-td"><span class = "output-address-fee"></span></td>
		                    <td class="calculator-table-td"><span class = "minimum-calculator"></span></td>
		                </tr>
		            </tbody>
		        </table>

		        <div class = "miner-fee-summary">
		            Next block miner's fee rate is <span class = "optimal-miner-rate"></span> sat/B; 1 BTC = <span class = "exchange-rate"></span> USD.                   
		        </div>
		       
		        <div class = "satperbyte-tooltip-content">
		            Adjust the miner's fee rate to your needs. 
		            Set it high or low, depending on how quick you need output transactions to be confirmed.</div>
		        <div class = "satperbyte-tooltip-arrow">
		        </div>

		        <div class = "output-address-fee-tooltip-content">
		            As an approximation, our calculator assumes each target address pays miner's fee 
		            for standard transaction with one input and two outputs (140 B).</div>
		        <div class = "output-address-fee-tooltip-arrow">
		        </div>

		        <div class = "minimum-calculator-tooltip-content">
		            This restriction prevents from creation of dust payments and depends on service commission, 
		            miner's fee rate and percentage distribution along target addresses.</div>
		        <div class = "minimum-calculator-tooltip-arrow">
		        </div>
		        
		        <div class = "continue-button-parent">
		            <button class = "continue-button-disabled">Continue</button>
		        </div>

		        <div class = "error"> 
		            <a>Incorrect order</a>
		        </div>
		    </div>  

		    <div class = "accept-popup">
		        <div class = "accept-popup-content">
		            <span class = "close-popup"></span>
		            <p class = "accept-popup-please">Please check and accept important terms</p>
		            <p class = "accept-popup-main-text">
		            Incoming address is valid only for 24 hours. All further payments will be ignored. 
		            We do not store links between incoming and target addresses after operation is proceeded. 
		            Please, download the Letter of Guarantee before you send us coins. 
		            This will be a proof of your transaction.</p>
		            <p>
		            <label class="checkbox-container do-not-ask-check" style = "width: 110px">
		            	<span>Don't ask me again</span>
		                <input type="checkbox">
		                <span class="checkmark"></span>
		            </label>
		            </p>
		            <div class = "accept-button-content">
		                <div class = "accept-button-parent">
		                    <button class = "accept-button">Accept</button>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class = "high-min-income-error-popup">
		        <div class = "high-min-income-error-popup-content">
		            <span class = "close-high-min-income-error-popup"></span>
		            <p class = "high-min-income-error-popup-please">Please reduce minimum income</p>
		            <p class = "high-min-income-error-popup-main-text">
		            Unfortunately, we are unable to register your order. The minimum incoming amount for details 
		            you specified is <span class = "high-min-income-error-popup-min"></span>, while the maximum
		            incoming amount we can correctly handle with your BitWhisk code is 
		            <span class = "high-min-income-error-popup-max"></span>.
		            Please consider changing distribution of coins along target addresses. This will decrease
		            minimum incoming amount.</p> 
		            <div class = "high-min-income-error-illustration-parent">
		                <img class = "high-min-income-error-illustration-content" src = "/images/shuffle.svg">
		            </div>
		            <p class = "high-min-income-error-goodbye">We are working to make our reserve bigger.<br>Thank you for using BitWhisk.</p>
		        </div>
		    </div>

		    <div class = "no-coins-error-popup">
		        <div class = "no-coins-error-popup-content">
		            <span class = "close-no-coins-error-popup"></span>
		            <p class = "no-coins-error-popup-please">Insufficient funds</p>
		            <p class = "no-coins-error-popup-main-text">                    
		            Our project is young and coins reserve is rather limited. Unfortunately we cannot register an
		            order with your BitWhisk code. It means that coins you previously put in our system constitute
		            major part of our balance. After a while your coins will be substituted by other users funds.</p> 
		            <div class = "no-coins-error-illustration-parent">
		                <img class = "no-coins-error-illustration-content" src = "/images/empty_reserve.svg">
		            </div>
		            <p class = "no-coins-error-goodbye">We are working to make our reserve bigger.<br>Thank you for using BitWhisk.</p>
		        </div>
		    </div>

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

		    <div class = "load-in-progress">
		        <div class = "animation-content">
		            <img src = "/images/spinner.svg">
		        </div>
		    </div>
		</div>

		<div class = "status-error-popup">
	        <div class = "status-error-popup-content">
	            <span class = "close-status-error-popup"></span>
	            <p class = "status-error-please">Leaving order page</p>
	            <p class = "status-error-main-text">                    
	            Leaving now, you will lose all the data on this page. Are you sure you want to continue?
	            </p> 
	            <div class = "status-error-illustration-parent">
	                <img class = "status-error-illustration-content" src = "/images/door.svg">
	            </div>
	            <p class = "status-error-goodbye"><br><br><a class = "faq-href" id = "leave-ref">Click to leave</a></p>
	        </div>
	    </div>

		<div class = "order-done">
			<p>Order registered</p>
		    <p class = "please-letter">We generated the <a download = "Letter of Guarantee" class="letter-inside">Letter of Guarantee</a> for you, please save it.</p>
		    <ul class = "list-letters">
		    </ul>
		    <p class = "send-coins">Send your coins (min: <span class = "minimum"></span> BTC, max: <span class = "maximum"></span> BTC) to:</p>
		    <div class = "incoming-addresses"> 
		        <div class = "list-incoming">
		        </div>
		        <button class = "add-incoming-address">Add incoming address</button>
		    </div>

		    <div class = "qr-codes">
		        <img class = "qr-img">
		    </div>

		    <div class = "bitcode-information">
		        <p>Your BitWhisk code is <span class = "bitcode-value"></span>. It ensures that your coins 
		           will never be mixed with ones you previously put in our reserve.
		           Moreover, using BitWhisk with the same code gives discount. 
		           See <a href = "/fees" target = "_blank">Fees</a> for details.</p>
		        <p>You can <a href = "/status" target = "_blank">check</a> the status of your order at any time.</p>
		        <p>Thank you for using BitWhisk.</p>
		    </div>
		</div>
	</div>
    <?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/header.js"></script>
<script src="/scripts/main/start/feeSliderConstructor.js"></script> 
<script src="/scripts/main/start/timeSliderConstructor.js"></script> 
<script src="/scripts/main/start/percentageSliderConstructor.js"></script>
<script src="/scripts/main/intro/startButton.js"></script>  
<script src="/scripts/main/start/calculator.js"></script>
<script src="/scripts/main/start/inputForms.js"></script>
<script src="/scripts/main/start/validation.js"></script> 
<script src="/scripts/main/start/longArithmetics.js"></script>
<script src="/scripts/main/start/addressValidation.js"></script>  
<script src="/scripts/main/start/windowResize.js"></script> 
<script src="/scripts/main/start/wholeHandler.js"></script>
<script src="/scripts/main/start/initialization.js"></script>  
<script src="/scripts/main/order/addNewAddress.js"></script> 
<script src="/scripts/main/start/tooltips.js"></script>
</body>
</html>