<?php
require 'config.php';

	$sql = "SELECT * FROM `!sites` where status = '1'";
	//echo $sql;
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
	$siteid = $row['id'];
	$links_table = 'links_'.$row['siteprefix'];
		$sql4 = "UPDATE `$links_table` SET parsed = '0' WHERE prior > '1'";
		if(isset($testmode)) { echo $sql4 . '<br>'; }
		$result4 = mysql_query($sql4);
	}

?>