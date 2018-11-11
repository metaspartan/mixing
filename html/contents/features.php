<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
        <div class = "intro">
            <div class= "intro-motto">Our features</div>
        </div>
    	<div class = "slideshow-container" style = "<?php if ($status == 3) { echo "margin-top: 50px"; }?>">
            <div class = "slide">
    			<div>
    				<img src = "/images/target.svg" alt="" height = "70">
    			</div>
    			<p class = "slide-header"><a class = "uderscore" id = "ref-1" href = "#fast-and-secure">Fast and secure</a></p>
    			<p class = "slide-prop">You can always trust us your financial security</p>
    		</div>
    		<div class = "slide">
    			<div>
    				<img src = "/images/goal.svg" alt="" height = "70">
    			</div>
    			<p class = "slide-header"><a class = "uderscore" id = "ref-2" href = "#best-practices">Best practices</a></p>
    			<p class = "slide-prop">We stick to the highest standards of coins anonimization</p>
    		</div>
    		<div class = "slide">
    			<div>
    				<img src = "/images/competition.svg" alt="" height = "70">
    			</div>
    			<p class = "slide-header"><a class = "uderscore" id = "ref-3" href = "#two-mixing-regimes">Two mixing regimes</a></p>
    			<p class = "slide-prop">Send and receive or prepare and take away</p>
    		</div>
    		<div class = "slide">
    			<div>
    				<img src = "/images/programming.svg" alt="" height = "70">
    			</div>
    			<p class = "slide-header"><a class = "uderscore" id = "ref-4" href = "#no-javascript">No Javascript</a></p>
    			<p class = "slide-prop">Send and receive mixing mode works without JS</p>
    		</div>
    		<div class = "slide">
    			<div>
    				<img src = "/images/contract.svg" alt="" height = "70">
    			</div>
    			<p class = "slide-header"><a class = "uderscore" id = "ref-5" href = "#provable-obligations">Provable obligations</a></p>
    			<p class = "slide-prop">All operations are confirmed via Letters of Guarantee</p>
    		</div>
    		<div class = "slide">
    			<div>
    				<img src = "/images/analytics.svg" alt="" height = "70">
    			</div>
    			<p class = "slide-header"><a class = "uderscore" id = "ref-6" href = "#api">API for developers</a></p>
    			<p class = "slide-prop">We support those who want to use our service programatically</p>
    		</div>
    	</div>
        <div class = "auth-content hidden-content" id = "fast-and-secure">
            <p></p>
            <p style = "line-height: 22px">
                We guarantee to carry out your mixing requests without any unnecessary delays. 
                No doubt, your order will be processed in exact accordance with the configuration you specified.<br>
                Moreover, we pay a lot of attention to security. The clearnet traffic goes over <code class = "in-text">https</code>, meaning all your sensitive data is encrypted and nobody can sniff it. For those who doesn't want to trust clearnet we have a Tor-mirror.<br>Our business runs on your trust and our first priority task is to gain an excellent reputation. 
            </p>
        </div>
        <div class = "auth-content hidden-content" id = "best-practices">
            <p></p>
            <p style = "line-height: 22px">
                With us you can enjoy the full pack of well-tested mixing features: arbitrary service commission, multiple target addresses and time delays up to 48 hours. Long time delays are randomized with short intervals up to 10 minutes. Moreover, with us you can control the miner's fee for outcoming transactions.<br>
                Besides, we mark the coins sent to us by a special BitWhisk code and this ensures that user never gets back its own BTC from our reserve.
            </p>
        </div>
        <div class = "auth-content hidden-content" id = "two-mixing-regimes">
            <p></p>
            <p style = "line-height: 22px">
                Our service supports two mixing modes. The first one is pretty classic, so-called send and receive. We generate a unique incoming address for your order, you send your coins to this address and after two confirmations we process your request. This mixing regime is available without registration.<br>
                The second mode may be called prepare and take away. Here you tell us the amount you want to mix, our backend code sends a transaction with given amount to our address and generates a unique address for you. After some time you send coins to the generated address and we reveal the private key from the address with prepared funds. Note, that in this case you are sending coins to the past. To use this mixing regime you need to create an account.<br>
            </p>
        </div>
        <div class = "auth-content hidden-content" id = "no-javascript">
            <p></p>
            <p style = "line-height: 22px">
                We care about our customers security, hence the basic send-receive mixing mode works without Javascript. This means you may disable Javascript and create an order, download a Letter of Guarantee and check the status of your mixing request any time.
            </p>
        </div>
        <div class = "auth-content hidden-content" id = "provable-obligations">
            <p></p>
            <p style = "line-height: 22px">
                No centralized mixing service can prove that it will not run with your coins. As Bitcoin showed, to exclude trust between parties one needs to introduce some kind of decentralization. The compromise here is that every incoming payment is accompanied by so-called Letter of Guarantee.<br>
                This letter consists of message explicitly stating our obligations before you and Bitcoin signature by our official Bitcoin address <i>1BWhisku6FmdcWk776vrqb2KHs88r5oicp</i>. We advice to always save and check the Letter of Guarantee before sending any coins to our accounts.
            </p>
        </div>
        <div class = "auth-content hidden-content" id = "api">
            <p></p>
            <p style = "line-height: 22px">
                BitWhisk provides a simple public REST API to allow you to programatically use our mixer in send-receive mode.
            </p>
        </div>
    </div>
    <?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/header.js"></script>
<script src="/scripts/features/main.js"></script>
</body>
</html>