<h3><?php echo htmlspecialchars($result["cn"][0]);?></h3>
<div>
	<?php echo isset($result["title"][0]) ? htmlspecialchars($result["title"][0]) : '';?>
</div>
<div>
	Department: <?php echo isset($result["department"][0]) ? htmlspecialchars($result["department"][0]) : 'N/A';?>
</div>
<div>
	State: <?php echo isset($result["st"][0]) ? htmlspecialchars($result["st"][0]) : 'N/A';?>
</div>
<div>
	Email: <?php echo isset($result["mail"][0]) ? htmlspecialchars($result["mail"][0]) : 'N/A';?>
</div>
<div>
	Phone: <?php echo isset($result["telephonenumber"][0]) ? htmlspecialchars($result["telephonenumber"][0]) : 'N/A';?>
</div>
