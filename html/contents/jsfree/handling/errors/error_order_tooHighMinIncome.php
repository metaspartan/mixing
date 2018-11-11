<!DOCTYPE html>
<html lang="en">
<head>
    <title>BitWhisk &#x2014 High minimum income</title>
    <meta charset="utf-8" />
    <meta name = "viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" type = "text/css"  href = "/style/style.css">
    <link rel = "icon"       type = "image/x-icon" href = "/images/whisk_icon.ico">       
</head>
<body>
<div class = "high-min-income-error-popup" style = "display: block">
    <div class = "high-min-income-error-popup-content">
        <p class = "high-min-income-error-popup-please">Please reduce minimum income</p>
        <p class = "high-min-income-error-popup-main-text">
        Unfortunately, we are unable to register your order. The minimum incoming amount for details 
        you specified is <?php echo $minimum;?> BTC, while the maximum
        incoming amount we can correctly handle with your BitWhisk code is <?php echo $maximum;?> BTC.
        Please consider changing distribution of coins along target addresses. This will decrease
        minimum incoming amount.</p> 
        <div class = "high-min-income-error-illustration-parent">
            <img class = "high-min-income-error-illustration-content" src = "/images/shuffle.svg">
        </div>
        <p class = "high-min-income-error-goodbye">We are working to make our reserve bigger.<br>Thank you for using BitWhisk.</p>
    </div>
</div>
</body>
</html>