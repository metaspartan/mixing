<?php include($structure["static"]["head"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class= "intro-motto">
		    No Javascript here
		</div>

		<div class = "intro-logo-jsfree">
		    <img id="jsfree-logo" src="/images/coding.svg" alt = "" draggable="false">
		</div>

		<div class = "intro-info-jsfree">
		    We care about every aspect of our customers privacy. The following interface can be used with JS disabled. 
		    However, we strongly recommend to fully understand the content of mixing process before proceeding. 
		    If you have any questions, you may address them to <a class = "intro-faq-href" href = "/faq">FAQ</a> page.

		    <p style="text-align: center;">Please, choose the number of output addresses.</p>
		</div>        

		<form action = "/operation/redirect" method="post">
		    <div class = "intro-start">
		    <select class = "jfree-select" name="number">
		      <option value="1">One</option>
		      <option value="2">Two</option>
		      <option value="3">Three</option>
		      <option value="4">Four</option>
		      <option value="5">Five</option>
		      <option value="6">Six</option>
		      <option value="7">Seven</option>
		      <option value="8">Eight</option>
		      <option value="9">Nine</option>
		      <option value="10">Ten</option>
		    </select>
		    <p>
		    <button class = "continue-button">Proceed</button></p>
		    </div>            
		</form>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>
</body>
</html>
