<?php
require 'config.php';
require 'items_functions.php';

	$counter = 0;
	$sql = "SELECT * FROM `!sites` where status = '1' LIMIT 1";
	//echo $sql;
	$result = mysql_query($sql);
	$sites = mysql_num_rows($result);
	while ($counter < $sites) {
	$sql1 = "SELECT * FROM `!sites` WHERE id = 7 AND status = '1' ORDER BY updated ASC LIMIT 1";
	//echo $sql1 . '<br>';
    $result1 = mysql_query($sql1) or die(mysql_error());
	$num_rows = mysql_num_rows($result1);
		if ($num_rows != 0) {
		while ($row1 = mysql_fetch_assoc($result1)) {
				$siteid = $row1['id'];
				$links_table = 'links_'.$row1['siteprefix'];
				$items_profile = 'items_'.$row1['siteprefix'];
				$parser = $row1['parser'];
				$local = $row1['local'];
				include_once('profiles_items/'.$items_profile.'.php');
				if ($local == 'YES') {
				$sql2 = "SELECT * FROM $links_table WHERE linktype = '1' AND downloaded = '1' AND parsed = '0' and local_link != '' LIMIT 1";
				echo $sql2 . '<br>';
				$result2 = mysql_query($sql2) or die(mysql_error());
				$num_rows = mysql_num_rows($result2);
					if ($num_rows != 0) {
						while ($row2 = mysql_fetch_assoc($result2)) {
						$p_id = $row2['id'];
						$link = $row2['link'];
						$p_link = $row2['local_link'];
						//$p_link = 'temp/links_onekingslane/1100003/409216.html';
						if (isset($testmode)) { echo $p_link . '<br />'; }
						
						$api = new HabrApi;
						$parser_result = $api->getPost($p_link);


							if (isset($testmode)) {
								print_r($parser_result);
								echo '<br /><hr />';
								echo '<textarea cols="120" rows="10">';
								echo $parser_result['specification'];
								echo '</textarea>';
							}
						
						postProd($parser_result);
						
						$p_site_id = addslashes($p_site_id);
						$p_title = addslashes($p_title);
						$p_brand = addslashes($p_brand);
						$p_description = addslashes($p_description);
						$p_description2 = addslashes($p_description2);
						$p_price = addslashes($p_price);
						$p_msrp = addslashes($p_msrp);
						$p_main_image = addslashes($p_main_image);
						
						echo $p_title;
						echo $p_main_image;
						echo $mark1 . '<br />';
						if ($mark1 != '' && $mark2 != '') {
							$sql_insert = "INSERT INTO $items_profile VALUES ('','$p_site_id','$p_id','$link','$p_link','$p_title','$p_brand','$p_description','$p_description2','','$p_price','$p_msrp','$p_main_image','','',now(),now())";
							//echo $sql_insert . '<br>';
							//file_put_contents('insert-log.txt',$p_link . ' - ' . $link . PHP_EOL,FILE_APPEND);
							//$result = mysql_query($sql_insert);
						
							$sql_update = "UPDATE $links_table SET parsed = '1', timestring = now() WHERE link = '$link'";
							//echo $sql_update . '<br>';
							//file_put_contents('insert-log.txt',$p_link . ' - ' . $link . PHP_EOL,FILE_APPEND);
							//$result = mysql_query($sql_update);
						} else {
							$sql_update = "UPDATE $links_table SET parsed = '2', timestring = now() WHERE link = '$link'";
							//$result = mysql_query($sql_update);
						}
						
						unset($p_site_id);
						unset($p_title);
						unset($p_brand);
						unset($p_description);
						unset($p_description2);
						unset($p_price);
						unset($p_msrp);
						unset($p_main_image);
						}
					}
				}
						
			unset($mark1);
			unset($mark2);
			unset($p_id);
			unset($link);
			unset($p_link);
			unset($links_table);
			unset($items_profile);
			}
		}
		$counter++;
	}
?>