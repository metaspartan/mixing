<?php include($structure["static"]["head"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
		<form class = "mix-page-content" action = "/operation/jsfreeOrder" method = "post">
		    <div class = "bitcode-content">                
		        <div class = "bitcode-wrapper">
		            <p class = "enter-code-jsfree">BitWhisk code</p>             
		            <input class = "input-bitcode" type = "text" maxlength = "6" placeholder = "6-digit, no O, 0, I, l" name = "code">
		            <p class = "enter-code-jsfree" style = "width:150px; margin-left: -11px">Service commission&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "6" autocomplete="off" placeholder = "from 0.5 to 3 %" required name = "commission">
		            <p class = "enter-code-jsfree">Miner's fee rate&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "3" autocomplete="off" placeholder = "from 1 to 999 sat/b" required name = "minerRate">
		        </div>                                 
		    </div>  

		    <div class = "mix-content">
		        <div class = "mix-address">
		            <p style = "font-size: 14px;">Output address</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address" required name = "address0">
		            <p style = "font-size: 14px;">Delay:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay0">
		            <input style = "display: none" type="text" required name = "share0" value = "100">
		            <input style = "display: none" type="text" required name = "outputsNumber" value = "1">
		        </div>
		    </div>
		   
		    <div class = "continue-button-parent" style="margin-top: 25px">
		        <button class = "continue-button">Continue</button>
		    </div>
		</form>
		<div class = "intro-info-jsfree">
		    <p style="text-align: center; font-size: 13px">You may change the number of output addresses <a class = "intro-faq-href" href = "/jsfree">here</a>.</p>
		</div> 
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
</body>
</html>