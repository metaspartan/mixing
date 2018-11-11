<?php include($structure["static"]["head"]);?>
<?php include($structure["static"]["LSwatch"]);?>
<body>   
<div class="wrapper">
    <div class="content">
    	<?php echo file_get_contents($structure["static"]["header_{$status}"]);?>
    	<div class = "auth-content">
		    <p>
		    	BitWhisk stats
		    </p>
		    <p>
		    	We do not save any data that can identify the 
		    	transactions of our customers. All we save after 
		    	processing each mixing request is the current date and
		    	the profit we gained.
		    </p>
		    <div class = "invest-calculator" style = "margin-bottom: 80px">
		    	<div>
		    		<input type = "text" class = "signup-input" id = "from-date" placeholder = "From date">
		    	</div>
		    	<div>
		    		<input type = "text" class = "signup-input" id = "to-date" placeholder = "To date">
		    	</div>
		    </div>
		    
		    <div class = "continue-button-parent protect-button-parent">
		        <button class = "continue-button-disabled auth-button">Request statistics</button>
		    </div>

		    

		    <div class = "calendar" id = "calendar-to">
		    	<div class = "calendar-month">
		    		<div class = "month-back-container">
		    			<div class = "month-back"></div>
		    		</div>
		    		<div class = "month-forward-container">
		    			<div class = "month-forward"></div>
		    		</div>
		    		<div class = "month-name"></div>
		    	</div>
		    	<div class = "calendar-week">
		    		<div class = "calendar-week-day">MN</div><div class = "calendar-week-day">TU</div><div class = "calendar-week-day">WD</div><div class = "calendar-week-day">TH</div><div class = "calendar-week-day">FR</div><div class = "calendar-week-day">ST</div><div class = "calendar-week-day">SN</div>
		    	</div>
		    	<div class = "calendar-days"></div>
		    </div>

		    <div class = "calendar" id = "calendar-from">
		    	<div class = "calendar-month">
		    		<div class = "month-back-container">
		    			<div class = "month-back"></div>
		    		</div>
		    		<div class = "month-forward-container">
		    			<div class = "month-forward"></div>
		    		</div>
		    		<div class = "month-name"></div>
		    	</div>
		    	<div class = "calendar-week">
		    		<div class = "calendar-week-day">MN</div><div class = "calendar-week-day">TU</div><div class = "calendar-week-day">WD</div><div class = "calendar-week-day">TH</div><div class = "calendar-week-day">FR</div><div class = "calendar-week-day">ST</div><div class = "calendar-week-day">SN</div>
		    	</div>
		    	<div class = "calendar-days"></div>
		    </div>
		</div>

		<div class = "load-in-progress">
		    <div class = "animation-content">
		        <img src = "/images/spinner.svg">
		    </div>
		</div>

		<div class = "too-many-requests-popup">
		    <div class = "too-many-requests-popup-content">
		        <span class = "close-too-many-requests-popup"></span>
		        <p class = "too-many-requests-please">Server error</p>
		        <p class = "too-many-requests-main-text">                    
		        Due to an internal error our server failed to select a statistics. This happens 
		        quite rarely, there is no your fault here. We will be thankful if you notify us 
		        about this incident via <a class="faq-href", href="mailto:contact@bitwhisk.io">contact@bitwhisk.io</a></p> 
		        <div class = "too-many-requests-illustration-parent">
		            <img class = "too-many-requests-illustration-content" src = "/images/server-error.svg">
		        </div>
		        <p class = "too-many-requests-goodbye"><br>Please, try again later.</p>
		    </div>
		</div>

		<div class = "status-summary-popup">
		    <div class = "status-summary-popup-content">
		        <span class = "close-status-summary-popup"></span>
		        <p class = "status-summary-please">Mixer statistics</p>
		        <p class = "status-summary-main-text">                    
		        	Please note, the date format below is dd/mm/yyyy.
		        </p> 

		        <table class="order-summary-table" id = "stat-table">
	                <thead>
	                    <th class="order-summary-table-th">Period</th>
	                    <th class="order-summary-table-th">Total profit</th>
	                </thead>
	                <tbody>
	                    <tr class ="row-unconfirmed">
	                        <td class="order-summary-table-td" id = "stat-period"></td>
	                        <td class="order-summary-table-td" id = "stat-sum"></td>
	                    </tr>
	                </tbody>
	            </table>
		        <p class = "status-summary-goodbye"><br>Thank you for using BitWhisk.</p>
		    </div>
		</div>
		<script> 
		    document.querySelector(".auth-content").style.visibility = "hidden";
		</script>
	</div>
	<?php include($structure["static"]["footer"]);?>
</div>

<script src="/scripts/stats/header.js"></script>
<script src="/scripts/stats/windowResize.js"></script>
<script src="/scripts/stats/validation.js"></script>

</body>
</html>