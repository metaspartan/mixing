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
		            <p style = "font-size: 14px;">Output address #1</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #1" required name = "address0">
		            <p style = "font-size: 14px;">Delay #1:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay0">
		            <p style = "font-size: 14px;">Share #1:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share0">

		            <p style = "font-size: 14px;">Output address #2</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #2" required name = "address1">
		            <p style = "font-size: 14px;">Delay #2:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay1">
		            <p style = "font-size: 14px;">Share #2:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share1">

		            <p style = "font-size: 14px;">Output address #3</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #3" required name = "address2">
		            <p style = "font-size: 14px;">Delay #3:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay2">
		            <p style = "font-size: 14px;">Share #3:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share2">

		            <p style = "font-size: 14px;">Output address #4</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #4" required name = "address3">
		            <p style = "font-size: 14px;">Delay #4:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay3">
		            <p style = "font-size: 14px;">Share #4:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share3">

		            <p style = "font-size: 14px;">Output address #5</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #5" required name = "address4">
		            <p style = "font-size: 14px;">Delay #5:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay4">
		            <p style = "font-size: 14px;">Share #5:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share4">

		            <p style = "font-size: 14px;">Output address #6</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #6" required name = "address5">
		            <p style = "font-size: 14px;">Delay #6:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay5">
		            <p style = "font-size: 14px;">Share #6:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share5">

		            <p style = "font-size: 14px;">Output address #7</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #7" required name = "address6">
		            <p style = "font-size: 14px;">Delay #7:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay6">
		            <p style = "font-size: 14px;">Share #7:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share6">

		            <p style = "font-size: 14px;">Output address #8</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #8" required name = "address7">
		            <p style = "font-size: 14px;">Delay #8:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay7">
		            <p style = "font-size: 14px;">Share #8:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share7">

		            <p style = "font-size: 14px;">Output address #9</p>
		            <input class = "input-address" type="text" maxlength = "74" autocomplete="off" placeholder = "your Bitcoin address #9" required name = "address8">
		            <p style = "font-size: 14px;">Delay #9:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 0 to 48 hours" required name = "delay8">
		            <p style = "font-size: 14px;">Share #9:&nbsp;</p>
		            <input class = "input-bitcode" type="text" maxlength = "2" autocomplete="off" placeholder = "from 1 to 99 %" required name = "share8">

		            <input style = "display: none" type="text" required name = "outputsNumber" value = "9">
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