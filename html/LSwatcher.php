<?php
	if ($userOrderPage) {
		$pageGrants = $structure["userOrderPage"]["show"];
	} else {
		$pageGrants = $structure["dynamic"][$uri]["show"];
	}
?>
<script>
	var clientStatus = <?php echo $status;?>,
		pageGrants = <?php echo json_encode($pageGrants)?>;
</script>
<script src = "/scripts/status.js"></script>