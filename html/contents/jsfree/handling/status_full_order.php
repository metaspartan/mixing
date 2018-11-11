<!DOCTYPE html>
<html lang="en">
<head>
    <title>BitWhisk &#x2014 Order status</title>
    <meta charset="utf-8" />
    <meta name = "viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" type = "text/css" href="/style/style.css"> 
    <link rel = "icon"       type = "image/x-icon" href = "/images/whisk_icon.ico">       
</head>
<body>
	<div class = "status-summary-popup" style = "display: block">
        <div class = "status-summary-popup-content" style = "display: block">
            <p class = "status-summary-please">Order summary</p>                             
            <div class = "status-summary-main-text">
                <a class = "some-error" style = "display: <?php echo $block1;?>">
                	Some error occured while handling your order. Don't worry, your coins are not lost, for some reason they've got stuck at our wallet. Please, contact our support as soon as possible.
                </a>
                <a class = "address-active" style = "display: <?php echo $block2;?>">
                	Please mind that any payments to the generated address after <?php echo $activeUntil;?> will be ignored.
                </a>
                <a class = "address-non-active-pending" style = "display: <?php echo $block3;?>">
                	The generated address is not active since <?php echo $activeUntil;?>. The data will be deleted right after the execution of your delayed payments.
                </a>
                <a class = "address-non-active-no-pending" style = "display: <?php echo $block4;?>">
                	Your order has been successfully completed, soon all the information regarding it will be deleted from our server.
                </a>
            </div>

            <table class="order-summary-table">
                <thead>
                    <th class="order-summary-table-th" colspan="2">Incoming payments</th>
                </thead>
                <tbody>
                    <tr class ="row-unconfirmed">
                        <td class="order-summary-table-td">Unconfirmed</td>
                        <td class="order-summary-table-td"><?php echo $unconfirmedAmount;?> BTC</td>
                    </tr>
                    <tr class ="row-one-confirmation">
                        <td class="order-summary-table-td">One confirmation</td>
                        <td class="order-summary-table-td"><?php echo $confirmedAmount;?> BTC</td>
                    </tr>
                    <tr class = "row-received">
                        <td class="order-summary-table-td">Received amount</td>
                        <td class="order-summary-table-td"><?php echo $receivedAmount;?> BTC</td>
                    </tr>
                </tbody>
            </table>

            <div class = "status-summary-main-text">
                <a class = "max-ok" style = "display: <?php echo $max_ok_display;?>">Let us recall that minimum incoming amount for your order is <?php echo $minimum;?> BTC, while current maximum incoming amount corresponding to your BitWhisk code is <?php echo $maximum;?> BTC. Miner's fee rate for outcoming transactions is <?php echo $minerRate;?> sat/B.</a>
                <a class = "max-not-ok" style = "display: <?php echo $max_not_ok_display;?>">Let us recall that minimum incoming amount for your order is <?php echo $minimum;?> BTC. You have exceeded the maximum incoming amount corresponding to your BitWhisk code.</a>
            </div>
	        <?php 
            if ($summaryNeeded == "yes") {?>
                <div class = "outcoming-summary" style = "display: block">
                    <div class = "status-summary-main-text">
                        Below is the summary of scheduled and executed payments.
    				    <table class = "order-summary-table">

                        <?php 
                            for ($i = 0; $i < $outputsNumber; $i++) {?>
                	            <thead>
                			    	<th class = "order-summary-table-th" colspan = "2"> 
                			      		Output #<?php echo $i+1;?>
                			      	</th>
                			    </thead>
                	            <tbody>
                			      	<tr class = "row-address">
                			      		<td class = "order-summary-table-td">
                			      			Address
                			      		</td>
                			      		<td class = "order-summary-table-td">
                			      			<?php 
                                                echo $info["output{$i}"]["address"];?>
                			      		</td>
                			      	</tr>
                	                <?php  
                                    for ($j = 0; $j < $info["output{$i}"]["numOfPend"]; $j++) {
                                        $amountToSend = number_format($info["output{$i}"]["amountToSend{$j}"], 8, '.', '');?>
                    		            <tr class = "row-pending">
                    						<td class = "order-summary-table-td">
                    			      			Pending
                    			      		</td>
                    			      		<td class = "order-summary-table-td">
                    			      			<?php echo $amountToSend;?> BTC
                    			      		</td>
                    		            </tr>
                                        <?php 
                                        if ($info["output{$i}"]["tempDelayed{$j}"] == "yes") {?>
                        		            <tr>
                        						<td class = "order-summary-table-td">
                        			      			Scheduled after
                        			      		</td>
                        			      		<td class = "order-summary-table-td">
                        			      			<?php 
                                                        echo $info["output{$i}"]["timeToSend{$j}"];?>
                        			      		</td>
                        		            </tr>
                        		            <tr>
                        						<td class = "row-delayed order-summary-table-td" colspan = "2" style = "text-align: justify">
                        			      			The payment has been delayed. Most likely, this is because of unconfirmed change. We will process your order as soon as necessary change is confirmed.
                        			      		</td>
                        		            </tr>
                                        <?php 
                                        } else {?>
                    			            <tr class = "row-schedule">
                    			  		   	    <td class = "order-summary-table-td">
                    			           			Scheduled after
                    			           		</td>
                    			           		<td class = "order-summary-table-td">
                    			           			<?php echo $info["output{$i}"]["timeToSend{$j}"];?>
                    			           		</td>
                    		                </tr>
                                        <?php 
                                        }
                                    }
                                    if ($info["output{$i}"]["sentAmount"] > 0) {
                                    	$sentAmount = number_format($info["output{$i}"]["sentAmount"], 8, '.', '');
                                    } else {
                                    	$sentAmount = "0";
                                    }?>
                                    <tr class = "row-sent">
                						<td class = "order-summary-table-td">
                			      			Sent
                			      		</td>
                			      		<td class = "order-summary-table-td">
                			      			<?php echo $sentAmount;?> BTC
                    			      	</td>
                                    </tr>
                                </tbody> <?php
                            }?>
                        </table>
        			</div>   
                </div>
        <?php 
            if ($notAssigned == "yes") {?>
            	<div class = "status-summary-main-text not-assigned" style = "display: block">
                    * Our system has not yet set the payment schedule for some of your addresses. No need to worry, the payments will be scheduled right away.
                </div>
        <?php    
            }
        }

        if ($unhandledAmount > 0) {
        	$unhandledAmount = number_format($response["unhandledAmount"], 8, '.', '');?>
        	<div class = "status-summary-main-text" style = "display: block">
                <a class = "unhandled-note">Attention, you sent us <?php echo $unhandledAmount;?> BTC which we will not handle. Please, contact our support.</a>
            </div>
        <?php }?>
            <p class = "status-summary-goodbye">Thank you for using BitWhisk.</p>
        </div>
    </div>
</body>
</html>