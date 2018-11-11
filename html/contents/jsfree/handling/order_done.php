<!DOCTYPE html>
<html lang="en">
<head>
    <title>BitWhisk &#x2014 Mix Bitcoins with Whisk</title>
    <meta charset="utf-8" />
    <meta name = "viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" type = "text/css"  href = "/style/style.css">
    <link rel = "icon"       type = "image/x-icon" href = "/images/whisk_icon.ico">       
</head>
<body>   
<div class="wrapper">
    <div class="content">
        <?php echo file_get_contents($structure["static"]["header_{$status}"]);?>

        <div class = "order-done" style = "display: block">
            <p class = "please-letter">Order registered</p>
        	<p class = "please-letter">Be careful, clicking F5 will destroy this page forever.</p>
            <p class = "please-letter">Letter of Guarantee will open in a new tab</p>
            <div style = "width: 140px; margin-left:auto; margin-right: auto">
	            <form target="_blank" method = "post" action = "letter">
	            	<input style="display:none" value = "<?php echo $letter;?>" name = "letter">
	            	<button class="continue-button">Click</button>
	            </form>
            </div>
            <p class = "send-coins">Send your coins (min: <span class = "minimum"><?php echo $minimum; ?></span>BTC, max: <span class = "maximum"><?php echo $maximum; ?></span>BTC) to:</p>
            <div class = "incoming-addresses"> 
                <div class = "list-incoming">
                    <li class="el-list-incoming">
                        <span class="generated-address" style="cursor: text;"><?php echo $newAddress;?></span>
                    </li>
                </div>
            </div>

            <div class = "qr-codes">
                <img class = "qr-img" src = "https://chart.googleapis.com/chart?chs=185x185&cht=qr&chl='<?php echo $newAddress;?>'">
            </div>

            <div class = "bitcode-information">
                <p>Your BitWhisk code is <span class = "bitcode-value"><?php echo $code;?></span>. It ensures that your coins 
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
</body>
</html>