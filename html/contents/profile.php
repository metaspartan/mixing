<?php
	$login = $session["data"]["login"];
	$email = $session["data"]["email"];
	$code = $session["data"]["code"];
	$depBalance = $session["data"]["depBalance"];
	$invBalance = $session["data"]["invBalance"];
	$twoFactor = $session["data"]["twoFactorUI"];
	include($structure["static"]["head"]);
	include($structure["static"]["LSwatch"]);
?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
	    <div class = "auth-content">
	    	<p>
	        	Profile
	    	</p>
	    	<div class = "profile-block">
	    		<div class = "profile-block-icon">
	    			<div class = "profile-block-img">
	    				<img src="/images/profile.svg" alt = "" height = 40>
	    			</div>
	    		</div>
	    		<div class = "profile-block-text">
	    			Login: <?php echo $login;?><hr>
	    			E-mail: <?php echo $email;?>
	    		</div>
	    	</div>
	    	<div class = "profile-block">
	    		<div class = "profile-block-icon">
	    			<div class = "profile-block-img">
	    				<img src="/images/cart.svg" alt = "" height = 40>
	    			</div>
	    		</div>
	    		<div class = "profile-block-text">
	    			BitWhisk code: <?php echo $code;?><hr>
	    			<a class = "faq-href" id = "watch-orders">Watch your mixing orders</a>
	    		</div>
	    	</div>
	    	<div class = "profile-block">
	    		<div class = "profile-block-icon">
	    			<div class = "profile-block-img">
	    				<img src="/images/deposit.svg" alt = "" height = 40>
	    			</div>
	    		</div>
	    		<div class = "profile-block-text">
	    			<a>Account balance: <?php echo numberFormat($depBalance, 8);?> BTC</a><hr>	    			
	    			<a class = "faq-href" href = "/profile/deposit">Manage your deposit</a>
	    		</div>
	    	</div>
	    	<div class = "profile-block">
	    		<div class = "profile-block-icon">
	    			<div class = "profile-block-img">
	    				<img src="/images/investment.svg" alt = "" height = 40>
	    			</div>
	    		</div>
	    		<div class = "profile-block-text">
	    			<a>Investment: <?php echo numberFormat($invBalance, 8);?> BTC</a><hr>  			
	    			<?php if ($invBalance > 0) {?>
	    				<a class = "faq-href" href = "/partner">Invest in BitWhisk</a><hr>
	    				<a class = "faq-href" href = "/partner/withdraw">Request a withdraw</a>
	    			<?php } else {?>
	    				<a class = "faq-href" href = "/partner">Become a partner</a>
	    			<?php }?>
	    		</div>
	    	</div>
	    	<div class = "profile-block">
	    		<div class = "profile-block-icon">
	    			<div class = "profile-block-img">
	    				<img src="/images/profit.svg" alt = "" height = 40>
	    			</div>
	    		</div>
	    		<div class = "profile-block-text">
	    			<a>BitWhisk is open for you</a><hr>
	    			<a class = "faq-href" href = "/stats">Monitor our results</a>
	    		</div>
	    	</div>
	    	<div class = "profile-block">
	    		<div class = "profile-block-icon">
	    			<div class = "profile-block-img">
	    				<img src="/images/protected_<?php echo $twoFactor;?>.svg" alt = "" height = 40>
	    			</div>
	    		</div>
	    		<div class = "profile-block-text">
	    			<?php if ($twoFactor == "no") {?>
	    				<a class = "faq-href" href = "/profile/protect">Enable two-factor authorization</a><hr>
	    			<?php } else {?>
	    				<a>Two-factor authorization is set</a><hr>
	    			<?php }?>	
	    			<a class = "faq-href" href = "/profile/password">Change password</a><hr>
	    			<a class = "faq-href" id = "complete-signout">Sign out from all devices</a>
	    		</div>
	    	</div>
		</div>
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
                    Due to an internal error our server refused to select your orders list. 
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

        <div class = "too-many-requests-popup" id = "no-orders-popup">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-no-orders-popup"></span>
                <p class = "too-many-requests-please">No orders on your account</p>
                <?php if ($depBalance > 0) {?>
                <p class = "too-many-requests-main-text">                    
                    Seems like you don't have any open mixing requests right now.
                    You can always create one <a class = "faq-href" href = "/mixing">here</a>.
                </p>
                <div class = "too-many-requests-illustration-parent">
                    <img class = "too-many-requests-illustration-content" src = "/images/empty-order.svg">
                </div>
                <p class = "too-many-requests-goodbye"><br>Thank you for using BitWhisk.</p>
                <?php } else {?>  
                <p class = "too-many-requests-main-text">                    
                    Seems like you don't have any open mixing requests right now.
                    To create a prepare-takeaway order you need to
                <a class = "faq-href" href = "/profile/deposit">top up</a> your account balance.
                </p>
                <div class = "too-many-requests-illustration-parent">
                    <a class = "faq-href" href = "/profile/deposit"><img height = "60" class = "too-many-requests-illustration-content" src = "/images/deposit.svg"></a><br>
                </div>
                <p class = "too-many-requests-goodbye"><br><br>Thank you for using BitWhisk.</p>
                <?php }?>
            </div>
        </div>

        <div class = "too-many-requests-popup" id = "order-list-popup">
            <div class = "too-many-requests-popup-content">
                <span class = "close-too-many-requests-popup" id = "close-order-list-popup"></span>
                <p class = "too-many-requests-please">Order list</p>
                <p class = "too-many-requests-main-text">                    
                    Below is the list of prepare-takeaway orders for your account. 
                    The detailed information on each mixing request is available on its own page
                    (will open in a new tab).
                </p>
                <table class = "order-summary-table wide">
                	<thead>
    			    	<th class = "order-summary-table-th"> 
    			      		Reference
    			      	</th>
    			      	<th class = "order-summary-table-th"> 
    			      		Stash
    			      	</th>
    			      	<th class = "order-summary-table-th"> 
    			      		Status
    			      	</th>
    			    </thead>
    			    <tbody id = "tbody-orders-list">
    			    </tbody>
                </table>
                <p class = "too-many-requests-goodbye"><br><br>Thank you for using BitWhisk.</p>
            </div>
        </div>

		<div class = "accept-popup">
	        <div class = "accept-popup-content">
	            <span class = "close-popup"></span>
	            <p class = "accept-popup-please">Destroy all your sessions</p>
	            <p class = "accept-popup-main-text" style = "line-height: 18px">
		            You may destroy your authorization sessions on all devices where you
		        	are logged in. This action is appropriate if, for example, you losed a device 
		        	with an active BitWhisk session, or if someone stole your session cookie.
	        	</p>
	            <div class = "accept-button-content">
	                <div class = "accept-button-parent">
	                	<form action="/auth/totalSignout">						
	                    	<button class = "accept-button">Destroy</button>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
<script src="/scripts/header.js"></script>
<script>
	var login = "<?php echo $login;?>";
</script>
<script src="/scripts/profile/main.js"></script>

</body>
</html>