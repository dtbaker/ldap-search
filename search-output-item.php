
<h3><?php echo htmlspecialchars($result["cn"][0]);?></h3>
<div>
	Description: <?php echo isset($result["description"][0]) ? htmlspecialchars($result["description"][0]) : 'N/A';?>
</div>
<div>
	Email: <?php echo isset($result["email"][0]) ? htmlspecialchars($result["email"][0]) : 'N/A';?>
</div>
<div>
	Phone: <?php echo isset($result["telephonenumber"][0]) ? htmlspecialchars($result["telephonenumber"][0]) : 'N/A';?>
</div>
<div class="debug">
	Keys: <?php
	$available_keys = array();
	foreach($result as $key=>$val){
		if(!is_numeric($key))$available_keys[] = $key;
	}
	echo implode(', ',$available_keys);?>
</div>