<?php
require 'config.php';

require 'C:\Users\Parser\vendor\autoload.php';
require 'items_functions.php';

//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

	$sql1 = "SELECT partNumberDt, title, type, name, color, validDesign, price, familyPrice, images, GoodToKnow, CustBenefit, CustMaterials, Metric, careInst, Designer, breadCrumb
	FROM ikea2_items LIMIT 100";
	//echo $sql1 . '<br>';
    $result1 = mysql_query($sql1);
	$num_rows = mysql_num_rows($result1);
		if ($num_rows != 0) {
			while ($row1 = mysql_fetch_assoc($result1)) {
			$title = $row1['title'];
			//echo $title . '<br>';
			if ($row1['CustBenefit'] != '') { $description = $row1['CustBenefit']; }
			if ($row1['GoodToKnow'] != '') { $description = $description . $row1['GoodToKnow']; }
			if ($row1['Metric'] != '') { $description = $description . $row1['Metric']; }
			if ($row1['CustMaterials'] != '') { $description = $description . $row1['CustMaterials']; }
			$description = preg_replace('@<cbs>@iu', '<p>', $description);
			$description = preg_replace('@</cbs>@iu', '</p>', $description);
			echo $description . '<br><hr><br>' . PHP_EOL . PHP_EOL;
		}
	}
?>