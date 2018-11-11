<?php
    $incomingAddress1 = $orderInfo["incomingAddress1"];
    $incomingAddress2 = $orderInfo["incomingAddress2"];
    $unlockAmount = $orderInfo["unlockAmount"];
    $creationTime = $orderInfo["creationTime"];
    $stashAddress = $orderInfo["stashAddress"];
    $stashAmount = $orderInfo["stashAmount"];
    $orderStatus = $orderInfo["status"];
    $commission = $orderInfo["commission"];
    $stashKey = $orderInfo["stashKey"];
    $minerFee = $orderInfo["minerFee"];
    $TXID = $orderInfo["TXID"];
    $date = date("j F Y, H:i:s", $creationTime + 12*60*60);
    include($structure["static"]["head"]);
    include($structure["static"]["LSwatch"]);
?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<?php if ($orderStatus == "locked") {?>
    	<div class = "auth-content">
		    <p>
		    	Waiting for payment
		    </p>
		    <p> 
		    	Your stash has been successfully prepared, namely we sent <?php echo numberFormat($stashAmount, 8);?> BTC
		    	to the following address:
		    </p>
		    <div class = "input-container wide gray stash-address" style = "margin-top: -10px">
		        <?php echo $stashAddress;?>
		    </div>
		    <p>
		    	To unlock the private key, please forward the total of
		    	<?php echo numberFormat($unlockAmount, 8);?> BTC (service commission is 
		    	<?php echo numberFormat($commission, 4);?>%) to the following addresses:
		    </p>
		    <div class = "deposit-address"> 
		        <div class = "list-incoming">
		        	<li class = "el-list-incoming">
		        		<span class="generated-address unclickable-address" id = "address1"><?php echo $incomingAddress1;?></span>
		        	</li>
		        	<li class = "el-list-incoming">
		        		<span class="generated-address clickable-address" id = "address2"><?php echo $incomingAddress2;?></span>
		        	</li>
		        	<button class = "add-incoming-address" style = "margin-top: 10px; margin-bottom: -10px">Letter of Guarantee</button>
		        </div>
		    </div>
		    <div class = "qr-codes">
		        <img class = "qr-img" src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl=<?php echo $incomingAddress1;?>">
		    </div>
		    <p>
		    	Why two addresses? We advise to divide the unlock amount in arbitrary proportion and send each part separately.
		    	Though, you can send the whole amount to one of the addresses. With us you choose your mixing strategy yourself.
		    </p>
		    <p>
		    	The system will wait for your payment until <?php echo $date;?> UTC. 
		    	The ID of transaction paying to the stash address is displayed below:
		    </p>
		    <div class = "input-container wide gray stash-txid" style = "margin-top: -10px; overflow: hidden">
		        <?php echo $TXID;?>
		    </div>
		    <p>
		    	Your account balance is subtracted <?php echo numberFormat($minerFee, 8);?> BTC to cover miner fee costs
		    	of preparing a stash.
		    </p>
		    <p class = "text-center">
		    	This page is always available through your <a class = "faq-href" href = "/profile">profile</a>.
		    </p>
		</div>
    	<?php } elseif ($orderStatus == "open") {?>
    	<div class = "auth-content">
    		<p>
		    	Private key is yours
		    </p>
		    <p>
		    	We have successfully accepted your payment. 
		    	Please, import the below private key into your wallet. 
		    </p>
		    <div class = "input-container wide gray stash-key" style = "margin-top: -10px">
		        <?php echo $stashKey;?>
		    </div>
		    <div class = "continue-button-parent protect-button-parent">
		        <button class = "continue-button auth-button">Purge order info</button>
		    </div>
		    <p>
		    	
		    </p>
    	</div>
    	<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>

		<div class = "load-in-progress">
            <div class = "animation-content">
                <img src = "/images/spinner.svg">
            </div>
        </div>

        <div class = "too-many-requests-popup" id = "error-popup">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-error-popup"></span>
                <p class = "too-many-requests-please">Server error</p>
                <p class = "too-many-requests-main-text">                    
                    Due to an internal error our server refused to delete your order. 
                    This happens quite rarely, there is no your fault here. 
                    We will be thankful if you notify us about this incident via 
                    <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>
                </p> 
                <div class = "too-many-requests-illustration-parent">
                    <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
                </div>
                <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
            </div>
        </div>

		<div class = "accept-popup" id = "confirm-popup">
            <div class = "accept-popup-content">
                <span class = "close-popup" id = "close-confirm-popup"></span>
                <p class = "accept-popup-please">Please confirm action</p>
                <p class = "accept-popup-main-text">
                    All information about this order will be automatically purged from our servers
		    		after <?php echo $date;?> UTC. However, you may delete it right now.
		    		Please make sure you have successfully saved the private key of the stash address,
		    		as this operation is irreversible.
                </p>
                <div class = "accept-button-content">
                    <div class = "accept-button-parent">
                        <button class = "accept-button">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class = "too-many-requests-popup" id = "delete-success">
            <div class = "too-many-requests-popup-content">
                <p class = "too-many-requests-please">Order is successfully deleted</p>
                <p class = "too-many-requests-main-text">                    
                    You will be redirected to your profile page in <span id = "timer">3</span>&#8230;
                </p> 
                <div class = "too-many-requests-illustration-parent">
                    <img class = "too-many-requests-illustration-content" src = "/images/redirecting.svg">
                </div>
                <p class = "too-many-requests-goodbye"><br>Thank you for using BitWhisk.</p>
            </div>
        </div>
    	<?php }?>
    </div>
	<?php include($structure["static"]["footer"]);?>
</div>
<?php if ($orderStatus == "locked") {?>
<script src="/scripts/header.js"></script>
<script src="/scripts/userOrder/locked.js"></script>
<?php } elseif ($orderStatus == "open") {?>
<script src="/scripts/userOrder/header.js"></script>
<script src="/scripts/userOrder/windowResize.js"></script>
<script src="/scripts/userOrder/open.js"></script>
<?php }?>
</body>
</html>