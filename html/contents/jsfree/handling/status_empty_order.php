<!DOCTYPE html>
<html lang="en">
<head>
    <title>BitWhisk &#x2014 Empty order</title>
    <meta charset="utf-8" />
    <meta name = "viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" type = "text/css" href="/style/style.css"> 
    <link rel = "icon"       type = "image/x-icon" href = "/images/whisk_icon.ico">       
</head>

<body>
	<div class = "status-empty-order-popup" style = "display: block">
        <div class = "status-empty-order-popup-content">
            <p class = "status-empty-order-please">
            	Nothing to mix
            </p>
            <p class = "status-empty-order-main-text">
                You havent sent any coins to the generated address. Let us recall that
                minimum incoming amount for your order is <?php echo $minimum;?> BTC, while current maximum 
                incoming amount for your BitWhisk code is <?php echo $maximum;?> BTC. Please mind that 
                any payments to the generated address after <?php echo $activeUntil;?> will be ignored.
            </p> 
            <div class = "status-empty-order-illustration-parent">
                <img class = "status-noorder-illustration-content" src = "/images/empty-order.svg">
            </div>
            <p class = "status-empty-order-goodbye"><br>
            	Thank you for using BitWhisk.
            </p>
        </div>
    </div>
</body>
</html>