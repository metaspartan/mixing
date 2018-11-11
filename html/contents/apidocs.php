<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "faq-content">
            <div class = "faq-header">API documentation</div>

            <div class = "invest-text">
                BitWhisk provides a simple public REST API to allow you to programatically use our service in <a class = "faq-href" href = "/faq#send-receive">send-receive mode</a>. The base url is <code class = "in-text">https://bitwhisk.io/api</code>. All requests use the <code class = "in-text">application/json</code> content type and go over <code class = "in-text">https</code>. All requests are GET requests and all responses come in JSON format. Always check the <code class = "in-text">success</code> flag to ensure that your API call succeeded.

                <p>We are currently restricting to 5 calls to our API procedures per minute (no burst). If you are affected by these limits, please contact our team via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>. We reserve the right to switch to using API keys.</p>

                <p>Below is the description of available API calls.</p>

                <p class = "api-call-header">/discount</p>
                <p>This is a short procedure used to define a discount on service commission for the given BitWhisk code.</p>
                <p class = "api-call-small-header">Input format</p>
                <table class = "api-table">
                    <thead>
                        <th class="api-table-th">Parameter</th>
                        <th class="api-table-th">Required</th>
                        <th class="api-table-th">Description</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="api-table-td">
                                <code>code</code>
                            </td>
                            <td class="api-table-td">required</td>
                            <td class="api-table-td">a 6-digit string representing a valid BitWhisk code</td>
                        </tr>
                    </tbody>
                </table>
                <p class = "api-call-small-header">Request example</p> 
                <div class = "request-example">
                    <code style = "margin-left: 15px">https://bitwhisk.io/api/discount?code=abcdef</code>
                </div>
                <p class = "api-call-small-header">Response</p>
                <div class = "request-example">
                <pre style = "margin-left: 15px"><code>{
    "success" : <code class = "not-string">true</code>,
    "error"   : <code class = "string">""</code>,
    "result"  : {
                    "discount" : <code class = "not-string">0</code>,
                    "minServiceCommission" : <code class = "not-string">0.5</code>
                }
}</code></pre>
                </div>
                <p class = "api-call-header">/order</p>
                <p>This is a procedure used to create mixing orders.</p>
                <p class = "api-call-small-header">Input format</p>

                <table class = "api-table">
                    <thead>
                        <th class="api-table-th">Parameter</th>
                        <th class="api-table-th">Required</th>
                        <th class="api-table-th">Description</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="api-table-td">
                                <code>code</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                a 6-digit string representing a valid BitWhisk code, if not present the system will generate a code for you
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>commission</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                a float number with no more than four digits after a point, if not present the system will randomly choose a commission between 0.5 and 3% 
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>minerRate</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                an integer between 1 and 999, represents a miner's fee rate our service will use for output transactions, if not present the system will choose an optimal one
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>address0</code>
                            </td>
                            <td class="api-table-td">required</td>
                            <td class="api-table-td">
                                a string representing a valid Bitcoin address you will receive funds on
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>delay0</code>
                            </td>
                            <td class="api-table-td">required</td>
                            <td class="api-table-td">
                                an integer between 0 and 48, representing delay time for <code>address0</code>
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>share0</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                an integer between 1 and 99, representing share of the outcome which needs to be sent to <code>address0</code>, if not present the system will interpret your order as containing only <code>address0</code> as output address
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td" colspan = "3" style = "text-align: center; font-weight: bold; font-size: 16px">...</td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>address9</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                a string representing a valid Bitcoin address you will receive funds on
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>delay9</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                an integer between 0 and 48, representing delay time for <code>address9</code>
                            </td>
                        </tr>
                        <tr>
                            <td class="api-table-td">
                                <code>share9</code>
                            </td>
                            <td class="api-table-td">optional</td>
                            <td class="api-table-td">
                                an integer between 1 and 99, representing share of the outcome which needs to be sent to <code>address9</code>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class = "api-call-small-header">Request example</p> 
                <div class = "request-example">
                    <code style = "margin-left: 15px">https://bitwhisk.io/api/order?address0=1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa&delay0=0</code>
                </div>
                <p class = "api-call-small-header">Response</p>
                <div class = "request-example">
                <pre style = "margin-left: 15px"><code>{
    "success" : <code class = "not-string">true</code>,
    "error"   : <code class = "string">""</code>,
    "result"  : {
                    "minInputAmount" : <code class = "not-string">0.00046574</code>,
                    "maxInputAmount" : <code class = "not-string">3.43162733</code>,
                    "inputAddress" : <code class = "string">"3LfhEyqC42on8YhbtwfPFwbZtyWGduxJ4D"</code>,
                    "code" : <code class = "string">"abcdef"</code>,
                    "commission" : <code class = "not-string">1.2345</code>,
                    "minerRate" : <code class = "not-string">15</code>,
                    "letter" : {
                                    "signingBitcoinAddress" : <code class = "string">"1BWhisku6FmdcWk776vrqb2KHs88r5oicp"</code>,
                                    "message" : <code class = "string">"We hereby confirm that WWW.BITWHISK.IO has generated the address ..."</code>,
                                    "digitalSignature" : <code class = "string">H/Jjp5rk+ksObPDf/epM4SjIZL5JmYcjA6ZRg6LxG/9dBdUPhcVbeGEy4MLjzBPrVQn89IKQoWkeCxoRxsfepzc="</code>
                               }
                }
}</code>
                </pre>
                </div>
                <p>Found a bug? Have any questions or suggestions regarding our API? You may contact us any time via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a> or post to our official <a class = "faq-href" href = "https://bitcointalk.org/index.php?topic=3206015.0">bitcointalk thread</a>.</p>
            </div>

        </div>
    </div>
    <?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/header.js"></script>
</body>
</html>