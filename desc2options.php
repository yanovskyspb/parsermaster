<?php
require 'config.php';

	$sql1 = "SELECT * FROM `items_onekingslane` WHERE keywords = '' ORDER BY RAND() LIMIT 50";
	$result1 = mysql_query($sql1);
	while ($row1 = mysql_fetch_assoc($result1)) {
		$id = $row1['id'];
		$start = $row1['title'];
		$brand = $row1['brand'];
		$description2 = $row1['description2'];
		$skuid = $row1['site_id'];

		//echo $start;
		//echo $description2;
		preg_match_all('@(Color:|Made of:|Materials:|Era:|Country of Origin:|Format:|Imprint:|Style:|Made in:|Construction:|Author\(s\):|Author:|Authors:)(.+?)<\/dd>@iu', $description2, $out,PREG_PATTERN_ORDER);
		//print_r($out);
		//echo '<hr>' . PHP_EOL . PHP_EOL . PHP_EOL;
		$options = array();
		foreach ($out[0] as $ot) {
			$ot = preg_replace('@^(.+?)<dd>@iu', '', $ot);
			$ot = preg_replace('@<.+?>@iu', ' ', $ot);

			$ot = preg_replace('@,\s@iu', ',', $ot);
			$ot = preg_replace('@ ,@iu', ',', $ot);
			
			$ot = preg_replace('@(USA|China|MDF|polyurethane foam|Polyurethane|polyester Foam|Polyurethane/polyester Foam|Polyester|Polypropylene)@iu', '', $ot);
			$ot = preg_replace('@(front|back|top|fill|frame|upholstery|base)@iu', '', $ot);
			
			$ot = preg_replace('@;@iu', ',', $ot);
			$ot = preg_replace('@,\s@iu', ',', $ot);
			$ot = preg_replace('@\s,@iu', ',', $ot);
			$ot = ucwords($ot);
			$options[] = $ot;
		}

		$options = implode(',', $options);
		$options = explode(',', $options);

		$options = array_unique($options, SORT_REGULAR);
		$options = array_values($options);

		$i = 0;
		foreach($options as $o) {
			$o = trim($o);
			$o = preg_replace('@(^\s|\s$)@iu', '', $o);
			$o = ucwords($o);
			$o = ucfirst($o);
			$o = preg_replace('@(^\\|^/|\\$|/$)@iu', '', $o);
			$o = preg_replace('@/{2,}@iu', '/', $o);
			$o = preg_replace('@\{2,}@iu', '\\', $o);
			$o = trim($o);
			array_replace($options, array($i => $o));
			
			//Удаляем то что не катит
			$ct = str_word_count($o);
			if ($ct > 4) { unset($options[$i]); }
			$ct2 = strlen($o);
			if ($ct2 < 2) { unset($options[$i]); }
			if ($o == '') { unset($options[$i]); }
			if (preg_match('@([0-9-]+)@',$o)) { unset($options[$i]); }
			if (preg_match('@^cover$@',$o)) { unset($options[$i]); }
			if (preg_match('@^insert$@',$o)) { unset($options[$i]); }
			$i++;
		}
		//print_r($options);
		$options = implode(', ', $options);
		$options = ucwords($options);
		$options = ucfirst($options);
		$options = trim($options);
		$options = preg_replace('@ ,@iu', ',', $options);
		$options = preg_replace('@/$@iu', '', $options);
		$options = preg_replace('@^/@iu', '', $options);
		$options = preg_replace('@/{2,}@iu', '/', $options);
		$options = preg_replace('@insert, @iu', '', $options);
		$options = preg_replace('@/, @iu', '', $options);
		$options = preg_replace('@\s{2,}@iu', ' ', $options);
		$options = preg_replace('@\s/@iu', ' ', $options);
		$options = trim($options);
		//echo $options . PHP_EOL;
		$options = addslashes($options);
		
		if ($options == '') { $options = '###'; }
		
		$sql_update = "UPDATE `items_onekingslane` SET keywords = '$options' WHERE id = '$id'";
		//echo $sql_update . '<br>';
		//file_put_contents('insert-log.txt',$p_link . ' - ' . $link . PHP_EOL,FILE_APPEND);
		$result = mysql_query($sql_update);
		unset($options);

	}
?>