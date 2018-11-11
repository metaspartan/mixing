<?php
    $code = $session["data"]["code"];
    $maxAmount = $session["data"]["maxAmount"];
    $depBalance = $session["data"]["depBalance"];
    include($structure["static"]["head"]);
    include($structure["static"]["LSwatch"]);
?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
        <?php if ($maxAmount > 0 and $depBalance > 0) {
            require_once(__DIR__."/../../php/mainLibrary.php");
            $discount = defineDiscount($code);
        ?>
    	<div class = "mix-page-content">
    		<p class = "text-center" style = "line-height: 32px; font-size: 30px">
    			Prepare a stash
    		</p>
            <div class = "auth-content">
                <p></p>
                <p>Here you may reserve Bitcoins for takeaway. We will reveal the private keys once your incoming deposit is confirmed.</p>
                <div class = "input-container wide" style = "position: relative; margin-top: -14px;">
                    <input style = "margin-top: 8px" class = "signup-input protect-input" id = "amount-to-mix" type = "text" placeholder = "Amount to mix (BTC)">
                </div>
            </div>
            <div class = "auth-content" style = "margin-top: -20px">
                <div class = "fee wide">
                    <p></p>
                    <p>Service commission:&nbsp;<span class = "fee-amount"></span></p>
                    <div class = "fee-slider-parent wide" style = "margin-top: -20px"><div class = "fee-slider"></div></div>
                </div>
                <div class = "continue-button-parent protect-button-parent">
                    <button class = "continue-button-disabled auth-button">Place an order</button>
                </div>
                <p style = "font-size: 13px;">
                    The maximum reserve is <span id = "maximum-amount"><?php echo numberFormat($maxAmount, 8);?> BTC</span>
                </p>
            </div>
    	</div>
        <?php } else if ($maxAmount == 0) {?>
        <div class = "mix-page-content">
            <div class = "auth-content">
                <p>Reserve is empty</p>
                <p>
                    Currently we cannot prepare a stash for you. Either our reserve is full of coins marked with your BitWhisk code or somebody else has reserved a big deposit for takeaway.
                </p>
                <div class = "input-container wide">
                    <div style = "margin-left: auto; margin-right: auto; width: 80px">
                        <img src = "/images/empty_reserve.svg" alt = "" height = "80">
                    </div>
                    <p class = "text-center" style = "margin-top: 25px;">You can always use our service in send-receive mode.</p>
                </div>
            </div>
        </div>
        <?php } else if ($depBalance == 0) {?>
        <div class = "mix-page-content">
            <div class = "auth-content">
                <p>Insufficient balance</p>
                <p>
                    To use this mixing mode you need to <a class = "faq-href" href = "/profile/deposit">top up</a> your account balance. These coins will be used to pay miner's fee while preparing a stash.
                </p>
                <div class = "input-container wide">
                    <div style = "margin-left: auto; margin-right: auto; width: 80px">
                        <a href = "/profile/deposit"><img src = "/images/deposit.svg" alt = "" height = "80"></a>
                    </div>
                    <p class = "text-center" style = "margin-top: 25px;">In a hurry? Send-receive mode is always at your service.</p>
                </div>
            </div>
        </div>
        <?php } ?>
        <script> 
            document.querySelector(".mix-page-content").style.visibility = "hidden";
        </script>
        <?php if ($maxAmount > 0 and $depBalance > 0) {?>
        <div class = "load-in-progress">
            <div class = "animation-content">
                <img src = "/images/spinner.svg">
            </div>
        </div>

        <div class = "accept-popup" id = "confirm-popup">
            <div class = "accept-popup-content">
                <span class = "close-popup" id = "close-confirm-popup"></span>
                <p class = "accept-popup-please">What happens further</p>
                <p class = "accept-popup-main-text">
                    We will create a transaction paying <b><span id = "specified-amount"></span> BTC</b> to our 
                    Bitcoin address. Miner's fee will be subtracted from your account balance. 
                    Next, we will generate two addresses waiting for <b><span id = "incoming-amount"></span> BTC</b> in total.
                    After your payment is confirmed you will get access to private key of the stash address.
                </p>
                <p>
                <label class="checkbox-container do-not-ask-check" style = "width: 130px">
                    <span>Don't show this popup</span>
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                </p>
                <div class = "accept-button-content">
                    <div class = "accept-button-parent">
                        <button class = "accept-button">Proceed</button>
                    </div>
                </div>
            </div>
        </div>

        <div class = "too-many-requests-popup" id = "error-popup">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-error-popup"></span>
                <p class = "too-many-requests-please">Server error</p>
                <p class = "too-many-requests-main-text">                    
                    Due to an internal error our server refused to prepare a stash for you. 
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

        <div class = "too-many-requests-popup" id = "insufficient-balance">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-insufficient-balance"></span>
                <p class = "too-many-requests-please">Insufficient balance</p>
                <p class = "too-many-requests-main-text">                    
                    Unfortunately, your current account balance is not sufficient to pay miner's fee 
                    for transaction preparing your stash.
                </p> 
                <div class = "too-many-requests-illustration-parent" style = "margin-top: 25px">
                    <a href = "/profile/deposit"><img height = "60" class = "too-many-requests-illustration-content" src = "/images/deposit.svg"></a>
                </div>
                <p class = "too-many-requests-goodbye">
                    <br><br>Please, <a class = "faq-href" href = "/profile/deposit">top up</a> the balance.
                </p>
            </div>
        </div>

        <div class = "too-many-requests-popup" id = "unconfirmed-output">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-unconfirmed-output"></span>
                <p class = "too-many-requests-please">Unconfirmed outputs problem</p>
                <p class = "too-many-requests-main-text">                    
                    Unfortunately, we cannot prepare your stash due to unconfirmed 
                    transactions outputs on our side. We never spend them to prevent collisions. 
                    Our reserve is rather limited, so sometimes such situations happen, there is
                    no your fault here.
                </p> 
                <div class = "too-many-requests-illustration-parent">
                    <img class = "too-many-requests-illustration-content" src = "/images/depressed.svg">
                </div>
                <p class = "too-many-requests-goodbye"><br>Please, try again later or choose smaller amount.</p>
            </div>
        </div>

        <div class = "too-many-requests-popup" id = "maximum-amount-changed">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-maximum-amount-changed"></span>
                <p class = "too-many-requests-please">Maximum amount changed</p>
                <p class = "too-many-requests-main-text">                    
                    Unfortunately, we cannot prepare a stash because maximum possible amount  
                    has changed. Most likely, another customer has reserved coins for takeaway.
                    As a consequence we are unable to handle your request right now. 
                </p> 
                <div class = "too-many-requests-illustration-parent">
                    <img class = "too-many-requests-illustration-content" src = "/images/depressed.svg">
                </div>
                <p class = "too-many-requests-goodbye"><br>Please, try again later or choose smaller amount.</p>
            </div>
        </div>
        <?php } ?>    
    </div>
	<?php include($structure["static"]["footer"]);?>
</div>
<script src="/scripts/mixing/header.js"></script>
<script src="/scripts/mixing/windowResize.js"></script>
<?php if ($maxAmount > 0 and $depBalance > 0) {?>
<script>
    var maxAmount = <?php echo $maxAmount+0;?>,
        discount = <?php echo $discount+0;?>;
</script>
<script src="/scripts/mixing/main.js"></script>
<?php } else if ($maxAmount == 0) {?>
<script>
    document.title = "BitWhisk \u2014 Reserve is empty";
</script>
<?php } else if ($depBalance == 0) {?>
<script>
    document.title = "BitWhisk \u2014 Insufficient balance";
</script>
<?php } ?>

</body>
</html>