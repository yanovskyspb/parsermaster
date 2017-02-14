<?php
require 'config.php';
require 'links_functions.php';

	$counter = 0;
	$sql = "SELECT * FROM `!sites` where status = '1' LIMIT 5";
	//echo $sql;
	$result = mysql_query($sql);
	$sites = mysql_num_rows($result);
	while ($counter < $sites) {
	$sql1 = "SELECT * FROM `!sites` where status = '1' ORDER BY updated ASC LIMIT 1";
	//echo $sql1 . '<br>';
    $result1 = mysql_query($sql1) or die(mysql_error());
	$num_rows = mysql_num_rows($result1);
		if ($num_rows != 0) {
		while ($row1 = mysql_fetch_assoc($result1)) {
				$siteid = $row1['id'];
				$links_table = 'links_'.$row1['siteprefix'];
				$parser = $row1['parser'];
				$proxy = $row1['proxy'];
				//echo $proxy;
				$sql = "UPDATE `!sites` SET updated = now() WHERE id = '$siteid'";
				$result = mysql_query($sql);
				//echo $links_table;
				include_once('profiles_links/'.$links_table.'.php');
				if (!isset($trimurls)) { $trimurls = ''; }

				if (isset($itemsmode)) {
					$sql1 = "SELECT link FROM $links_table WHERE parsed not in ('1','2') and linktype = '1' ORDER BY prior DESC LIMIT 5";
					$result1 = mysql_query($sql1) or die(mysql_error());
					$num_rows = mysql_num_rows($result1);
				}
				elseif (isset($catsmode)) {
					$sql1 = "SELECT link FROM $links_table WHERE parsed not in ('1','2') and linktype = '2' ORDER BY prior DESC LIMIT 5";
					$result1 = mysql_query($sql1) or die(mysql_error());
					$num_rows = mysql_num_rows($result1);
				}
				else {
					$sql1 = "SELECT link FROM $links_table WHERE parsed not in ('1','2') ORDER BY prior DESC LIMIT 5";
					$result1 = mysql_query($sql1) or die(mysql_error());
					$num_rows = mysql_num_rows($result1);
				}
				if ($num_rows != 0) {
				while ($row1 = mysql_fetch_assoc($result1)) {
					$p_link = $row1['link'];
					if(isset($testmode)) { echo '<hr><strong>' . $p_link . '</strong><br>'; }
					if ($parser == 'apist') {
						//echo $p_link . '<br>';
						$api = new HabrApi;
						$parser_result = $api->getUrls($p_link);
						if (isset($parser_result['links']) && $parser_result['links'] != '') {
							$links = $parser_result['links'];
						} elseif ($parser_result['error']['status'] == 404 || $parser_result['error']['status'] == 0) {
						//echo 'ОШИБКА КАКАЯТО<br />';
						$sql = "UPDATE $links_table SET parsed = '2', timestring = now() WHERE link = '$p_link'";
						//echo $sql . '<br />';
						$result = mysql_query($sql);
						unset($p_link);
						}
					}
					elseif ($parser == 'native') {
						$links = native($p_link);
							foreach ($links as $link) {
								if ($link == 'return404<br />') {
									//echo 'return404';
									$sql = "UPDATE $links_table SET parsed = '1', timestring = now() WHERE link = '$p_link'";
									$result = mysql_query($sql);
								}
								elseif ($link == 'return301') {
									//echo 'return301<br />';
									$sql = "UPDATE $links_table SET parsed = '1', timestring = now() WHERE link = '$p_link'";
									$result = mysql_query($sql);
									//unset($p_link);
								} else {
									$link = addDomain($link);
									$link = ClearUrls($link);
									if ($trimurls != '') { $link = TrimUrls($link); }
									$newlinks[] = array('link' => $link);
								}
							}
							if (isset($newlinks)) {
								$links = $newlinks;
								unset($newlinks);
							} 
							else {
								$links = '';
							}
					}
					if (isset($links) && $links != '') {
						$links = array_filter($links);
						$links = array_unique($links, SORT_REGULAR);
						//print_r($links);

							foreach ($links as $link) {
								if (preg_match("@^$domain@i", $link['link'])) {
									if (preg_match("@$category@i", $link['link'])) {
										$prior = '1';
									} else {
										$prior = '0';
									}
								$link = $link['link'];
								$link = preg_replace('@^$domain@i', '$domain/', $link);
								$link = preg_replace('@^$domain//@i', '$domain/', $link);
								if (preg_match("@^$domain@i", $link) && $link != '') {
									$linktype = GetLinkType($link);
									if(isset($testmode)) { echo '<a href="' . $link . '">' . $link . '</a> - ' . $prior . ' - ' . $linktype . '<br />' . PHP_EOL; }
									$sql = "INSERT INTO $links_table VALUES ('','$link','$linktype','$prior','0','','',now())";
									//echo $sql . '<br>';
									//file_put_contents('insert-log.txt',$p_link . ' - ' . $link . PHP_EOL,FILE_APPEND);
									$result = mysql_query($sql);
									}
								}
							}
						$sql = "UPDATE $links_table SET parsed = '1', timestring = now() WHERE link = '$p_link'";
						$result = mysql_query($sql);
						unset($p_link);
						}
					unset($links);
					}
				}
			unset($domain);
			unset($filterurls);
			unset($trimurls);
			unset($item);
			unset($category);
			unset($links_table);
			}
		}
		$counter++;
	}
?>