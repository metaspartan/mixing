<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "faq-content">
		    <div class = "faq-header">FAQ</div>
		    <div class = "faq-answer">
		    	BitWhisk provides a lot of functionality: two mixing modes, API, Javascript-free version, authorization system and many more. Hence, we advice our customers to carefully read this document to fully understand how to use our service with ease and comfort.
		    </div>

		    <div class = "faq-question" id="why-mixing">Why should I mix my coins?</div>
		    <div class = "faq-answer">
		    	Bitcoin activities are recorded and available publicly via the Blockchain; a comprehensive database which keeps a record of all Bitcoin transactions. In turn, all exchanges require the user to scan ID documents, and large transactions must be reported to the proper governmental authority. When you use Bitcoin to pay for goods and services, you will of course need to provide your name and address to the seller for delivery purposes.

		    	<p>
		    	This means that a third party with an interest in tracking your activities can use your visible balance and ID information as a basis from which to track your future transactions or to study previous activity. In short, you have compromised your security and privacy.
		    	</p>

		    	<p>
		    	To avoid this, we recommend using a quality mixing service such as the one we provide to periodically exchange your Bitcoins for different ones which cannot be associated with the original owner.
		    	</p>
			</div>

		    <div class = "faq-question" id="how-does-it-work">How does it work?</div>
		    <div class = "faq-answer">
		    	Well, it is not a rocket science but takes some time to carefully explain. To begin with, we provide two different mixing modes: <a class = "faq-href" href = "/faq#send-receive">send-receive</a> and <a class = "faq-href" href = "/faq#prepare-takeaway">prepare-takeaway</a>. Both of them make it almost impossible to track your transaction history, but they operate differently.	
		    	<p>
		    	Besides, the first mode is available instantly, without registration. On the contrary, the second one can be used only by registered users. Hence, to explore the full power of our service you need to <a class = "faq-href" href = "/faq#account-deposit">have an account</a>.
		    	</p>
			</div><hr>	    

		    <div class = "faq-question" id="send-receive">What is send-receive mixing mode?</div>
		    <div class = "faq-answer">
		    	The essential scheme is very simple. We generate a unique incoming address waiting for your deposit. Once your coins arrive, we send the same amount minus service commission to your addresses. You receive your BTC from sources that have absolutely no Blockchain relation to your previous transactions. To increase your privacy our service also provides <a class = "faq-href" href = "#custom-commission">custom commission</a>, multiple target addresses and time delays.
			</div>

			<div class = "faq-question" id = "randomize-time-delays">Do you randomize the time delays?</div>
		    <div class = "faq-answer">
		    	Yes, we randomize long time delays with short intervals up to 10 minutes. This is done in order to increase complexity of our transaction history and exclude the situations where several of your target addresses are included in the same transaction. In turn, urgent payments are processed right away after your incoming transaction has been received. Please note, you can <a class = "faq-href" href = "/status">request</a> the detailed summary of your order at any time.
		    </div>

		    <div class = "faq-question" id="how-long">How long does the mixing process take?</div>
		    <div class = "faq-answer">
		    	The answer depends on time delays you specified during the order process. Note that the delays are counted from the moment of your incoming transaction getting <a class = "faq-href" href = "#confirmations">enough</a> confirmations, not from the moment of creation of your order. Once the specified delays are over our backend code automatically sends your coins back to the target addresses. 

		    	<p>
		    	The only possible reason for extra delay put on your payments is our BTC change may stuck in mempool due to other users transaction not being confirmed. Since we <a class = "faq-href" href = "#adjust-miner-fee">allow</a> to set miner's fee rate for outcoming transactions such situations may take place in theory. However, this may only happen under very big load on our service. If your payments are extra delayed by our fault we will refund service commission, just notify us via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>.
		    	</p>
		    </div>

		    <div class = "faq-question" id = "several-transactions">Can I send several transactions paying to the incoming address?</div>
		    <div class = "faq-answer">
		    	Well, technically you can: our backend will correctly handle this case. However, Bitcoin addresses are one-off, using them multiple times is commonly considered a bad practice. Only if you accidentaly sent less than <a class = "faq-href" href = "#minimum-amount">minimum incoming amount </a>corresponding to your order, you can create additional transactions paying to the same address.
		    </div>

		    <div class = "faq-question" id = "adjust-miner-fee">Can I adjust miner's fee for outcoming transactions?</div>
		    <div class = "faq-answer">
		    	Yes, we provide our customers with a free choice of miner's fee rate for outcoming transactions made by our server. Please note, if your transaction gets stuck in mempool for 5 blocks and unconfirmed change is needed to process other customers payment we will resend it with higher miner's fee.
		    </div>

		    <div class = "faq-question" id = "sat/B-rate">Miner's fee rate is measured in sat/B, what is it exactly?</div>
		    <div class = "faq-answer">
		    	This stands for satoshis (one satoshi equals 0.00000001 BTC) per byte of the transaction size. The greater this rate the faster transaction gets confirmed. However, since introduction of the segregated witness concept there is a little mess concerning the measurement of a transaction size itself. Following <a href = "https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki#transaction-size-calculations" class = "faq-href" target="_blank">BIP141</a>:
			    <ul>
			        <li><i>Base transaction size</i> (BS) is the size of the transaction serialised with the witness data stripped;</li>
			        <li style ="margin-top: 4px"><i>Total transaction size</i> (TS) is the transaction size in bytes serialized as described in BIP144, including base data and witness data;</li>
			        <li style ="margin-top: 4px"><i>Transaction weight</i> (TW) is defined as BS&middot3 + TS;</li>
			        <li style ="margin-top: 4px"><i>Virtual transaction size</i> is defined as TW/4 (rounded up to the next integer).</li>
			    </ul> 
		    	In the calculation of miner's fee for outcoming transactions we use the base size measure. Meanwhile, block explorers show fee rates calculated according to different measures of transaction size, just do not let this confuse you.
		    </div>

		    <div class = "faq-question" id = "closed-browser">What if I accidentally closed the browser window before getting enough confirmations of my transfer?</div>
		    <div class = "faq-answer">
		    	There is no need for concern. You do not have to stay at the page once the incoming address is delivered and the <a class = "faq-href" href = "#letter-of-guarantee">Letter of Guarantee</a> is saved. Transfers are automatically processed according to the order lot over 24 hours.
		    </div><hr>

			<div class = "faq-question" id="prepare-takeaway">What is prepare-takeaway mode?</div>
		    <div class = "faq-answer">
		    	Here you choose an amount to mix first. In turn, we prepare a transaction paying the specified amount to a stash address in our wallet and generate two incoming addresses to accept your payment. Once your coins arrive we reveal the private key of the stash address. So with us you can effectively transfer your funds to the past.

		    	<p>
		    	We need to clarify the best practices when using this mixing mode. First, we advise to make a payment after a transaction transfering coins to the stash address gets several confirmations. Second, it is better to divide a payment in arbitrary proportion and send each part to one of the incoming addresses separately.
		    	</p>
		    </div>

		    <div class = "faq-question" id="account-deposit">Why do I need to create an account?</div>
		    <div class = "faq-answer">
		    	Basically, to use a prepare-takeaway mixing mode. Because in this case we spend first: the system creates a transaction and miner's fee is paid from our pocket. Authorization solves this problem easily. We subtract miner's fee from your account balance each time you create a prepare-takeaway order.
		    </div>

		    <div class = "faq-question" id="authorization-versus-anonimity">Does authorization harms my anonimity?</div>
		    <div class = "faq-answer">
		    	If you use it wisely, no. Just do not create an account with e-mail address linked to your identity. The authorization itself is based upon cookies, they are small files saved on your hard drive by the browser. Each time you make a request to our servers your browser sends a cookie along with other information. That's how the server selects appropriate content associated with your account. We do not collect your personal data like IP addresses, location or user-agent information.

		    	<p>
		    	Authorization opens up even more functionality. Inside of account you will be able to monitor our earnings statistics and invest in BitWhisk.
		    	</p>
		    </div>

		    <div class = "faq-question" id = "logs">What logs do you keep?</div>
		    <div class = "faq-answer">
		    	The only information we save after completing each mixing request is how much profit we gained. That's all. Logs of any other nature are not maintained. We do not store any information that can be used to identify the users either. All logs are wiped out on a routine basis to add to organizational efficiency and security of the users that rely upon us to maintain their anonymity.
			</div>

			<div class = "faq-question" id="account-protection">How about account protection?</div>
			<div class = "faq-answer">
		    	First of all, we advise you to choose a strong random password for your account. However, it is reasonable to consider password protection not too strong. Hence, you may set up a two-factor authorization: equip your profile with Bitcoin address that only you know the private key of. After password check you will be prompted to sign a random string with this address.

		    	<p>
		    	Be careful, once installed two-factor authorization cannot be cancelled or changed. If you lose the private key you lose the access to your BitWhisk data.
		    	</p>
			</div><hr>

		    <div class = "faq-question" id="coins-loop">Can I obtain my own coins after several mixings?</div>
		    <div class = "faq-answer">
		    	No, this is never the case. We mark the coins sent to us by a special BitWhisk code. This ensures that customer never gets back BTC he previously put in our reserve.
			</div>

			<div class = "faq-question" id = "what-is-bitwhisk-code">What is a BitWhisk code?</div>
		    <div class = "faq-answer">
		    	The first time you create a send-receive mixing request or register an account, you are given a code. This code is then used to ensure your coins are never mixed with ones you previously put in our system. This is a key component of what allows us to ensure your privacy and anonymity. Moreover, using BitWhisk with the same code gives you a discount. See <a href = "/fees" class = "faq-href">Fees</a> for details.
		    </div>

		    <div class = "faq-question" id = "own-bitwhisk-code">Can I choose my own BitWhisk code?</div>
		    <div class = "faq-answer">
		    	Yes, partly. You can freely choose a code while creating a send-receive mixing order or registering an account, the last one cannot be modified later. Also, you cannot choose a code while creating a prepare-takeaway order, because the system uses your account code by default. 

		    	<p>
		    	Please note, a valid code consists of exactly six random digits and uppercase and lowercase letters, with the exception that the uppercase letter "O", uppercase letter "I", lowercase letter "l", and the digit "0" are never used to prevent visual ambiguity.
		    	</p>
		    </div>

		    <div class = "faq-question" id = "custom-commission">Why should I set custom service commission?</div>
		    <div class = "faq-answer">
		    	This is done in order to make Blockchain analysis more difficult. If a third party knows your service commission, they will be able to analyse the publicly available transaction history and figure out what are your destination accounts. Custom service commission and miner's fee rate make Blockchain tracing almost impossible, so you can rely upon us to maintain your privacy and anonimity.
		    </div>

			<div class = "faq-question" id = "address-valid">How long are incoming addresses valid for?</div>
		    <div class = "faq-answer">
		    	For send-receive order an incoming address provided to you on the order page is valid for 24 hours. For prepare-takeaway order this limit is 12 hours. All transactions paying to the addresses after aforementioned periods will be ignored. 
			</div>

			<div class = "faq-question" id = "minimum-amount">Is there a minimum transaction size?</div>
		    <div class = "faq-answer">
		    	Well, each send-receive order is equipped with its own minimum incoming amount. We provide you with this info during the order process. Prepare-takeaway mode does not have this restriction.
		    </div>

		    <div class = "faq-question" id = "maximum-amount">What is the maximum transaction size?</div>
		    <div class = "faq-answer">
		    	The maximum transaction size that we can correctly handle depends on your <a class = "faq-href" href = "#what-is-bitwhisk-code">BitWhisk code</a>, hence this question does not have uniform answer. Our service provides you with the information on maximum incoming amount after you specify order details.
		    </div>

		    <div class = "faq-question" id = "letter-of-guarantee">What is a Letter of Guarantee?</div>
		    <div class = "faq-answer">At the time a Bitcoin address is generated to accept your deposit, we provide a digitally signed confirmation to verify that the address belongs to our server. This helps you confirm the legitimacy of the transaction and be confident about the coins being sent to the right address. To take things further and ensure user confidence this is signed from our official <a class = "faq-href" href = "/donation" target = "_blank">Bitcoin account</a> and can be used to verify the digital sign from your own wallet.  This sign is the proof of our obligations and users are expected to save it before sending us coins. Since your data is deleted from our servers this is the only proof of us transacting with you and helps future verifications for support or related functions.</div>

		    <div class = "faq-question" id = "letter-verify">How do I verify the Letter of Guarantee?</div>
		    <div class = "faq-answer">
		        <a>1. Head over to your Bitcoin Wallet;</a><br class = "faq-line-break">
		        <a>2. Select Verify Message. For example,</a><br class = "faq-line-break">
		        <ul>
		            <li>using Bitcoin-Qt: File &#8594 Verify Message,</li>
		            <li>using Electrum: Tools &#8594 Verify Message;</li>
		        </ul>           
		        <a>3. Paste data from the Letter of Guarantee;</a><br class = "faq-line-break">
		        <a>4. Click Verify.</a><br class = "faq-line-break">
		        <p>Note that there are number of resources which allow you to verify messages online. However, for the sake of your privacy we do not recommend using such services because you never know if they collect your information. If a third party has access to your Letter of Guarantee then the whole thing with mixing becomes worthless.</p>
		    </div> <hr>

		    <div class = "faq-question" id = "confirmations">How many confirmations do you need to accept transactions?</div>
		    <div class = "faq-answer">
		    	We accept all incoming transactions after 2 confirmations.
		    </div>

		    <div class = "faq-question" id="js-free">Can I use your service without Javascript?</div>
		    <div class = "faq-answer">
		    	Send-receive mode fully works with <a class = "faq-href" href = "/jsfree">Javascript disabled</a>. Authorization system curently requires Javascript to be enabled. Hence, prepare-takeaway mode does not work without Javascript. This is an important subject for further development.
		    </div>

		    <div class = "faq-question" id = "segwit">Do you use segwit addresses?</div>
		    <div class = "faq-answer">
		    	Yes, to reduce miner's fee for outcoming transactions made by our service all incoming payments are accepted to p2sh-segwit addresses. Moreover, with us you can forward your BTC to bech-32 addresses.
		    </div>

		    <div class = "faq-question" id = "api">Do you provide API?</div>
		    <div class = "faq-answer">
		    	Yes, we provide a public API for handling send-receive mixing orders, the details can be found <a class = "faq-href" href = "/api/docs">here</a>.
		    </div>
		    <br>

		    <div class = "faq-answer text-center">If you have any questions not answered here, please do not hesitate to contact us via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a></div><br>
		</div>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/header.js"></script>
</body>
</html>