<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class="fees-content">
		    <div class="fees-header">Fees</div>
		    <div class="fees-text">Our minimum service commission is 0.5% + miner's fee for every transaction made by our service. We do not put fixed fee per target address because this system is extremely inefficient. Please mind that calculator provided to you on the order page computes only approximate amount of coins you receive. To estimate it we assume that each target address is taxed with some constant fee which depends on miner's fee rate you specify. The detailed information is available during the order process.            

		    <p>We advice you to set a custom service commission to slow down amount-based Blockchain analysis. Remember, when you use BitWhisk regularly with the same code you get a discount. More you mix less you pay.</div>
		    <table class="fees-table">
		        <thead>
		            <th class="fees-table-th">Mixed amount</th>
		            <th class="fees-table-th">Min. service commission</th>
		        </thead>
		        <tbody>
		            <tr>
		                <td class="fees-table-td">1 &#8211 4 BTC</td>
		                <td class="fees-table-td">0.45%</td>
		            </tr>
		            <tr>
		                <td class="fees-table-td">4 &#8211 8 BTC</td>
		                <td class="fees-table-td">0.40%</td>
		            </tr>
		            <tr>
		                <td class="fees-table-td">8 &#8211 16 BTC</td>
		                <td class="fees-table-td">0.35%</td>
		            </tr>
		            <tr>
		                <td class="fees-table-td">16 &#8211 32 BTC</td>
		                <td class="fees-table-td">0.30%</td>
		            </tr>
		            <tr>
		                <td class="fees-table-td">32 BTC and more</td>
		                <td class="fees-table-td">0.25%</td>
		            </tr>
		        </tbody>
		    </table>
		    <div class = "fees-wish">Have a nice and safe mixing with us!</div>
		</div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/header.js"></script>
</body>
</html>