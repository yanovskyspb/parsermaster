<?php
require 'config.php';

	$sql = "SELECT * FROM `!sites` where status = '1' and parser_loader = 'native' ORDER BY updated2 ASC LIMIT 1";
	//echo $sql;
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
	$siteid = $row['id'];
	$links_table = 'links_'.$row['siteprefix'];
	$parser_loader = $row['parser_loader'];
	if(isset($testmode)) { $sql1 = "SELECT id,link FROM $links_table WHERE linktype = '1' and local_link = '' ORDER BY id DESC LIMIT 5"; }
	else { $sql1 = "SELECT id,link FROM $links_table WHERE linktype = '1' and local_link = '' ORDER BY id DESC LIMIT 10"; }
	//echo $sql1 . '<br>';
    $result1 = mysql_query($sql1);
	$num_rows = mysql_num_rows($result1);
	//echo $num_rows;
		if ($num_rows != 0) {
		while ($row1 = mysql_fetch_assoc($result1)) {
				$link_id = $row1['id'];
				$p_link = $row1['link'];
				
				// SET REQUEST HEADERS
				$opts = array(
					  'http'=>array(
						'header'=>"Accept-language: ru\r\n" .
								  "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"
					  )
					);
					 
				$context = stream_context_create($opts);
				
				$url_content = file_get_contents($p_link, false, $context);
			// ПОЛУЧАЕМ ЗАГОЛОВКИ НА СЛУЧАЙ ЕСЛИ ОТВЕТ БУДЕТ НЕ 200/ОК
				$headers = get_headers($p_link,1);
				$urlstatus = $headers[0];
				if(isset($testmode)) { echo $urlstatus . '<br>'; }

				if(strpos($urlstatus, "200 OK")!= false) $status200 = $urlstatus; else $status200 = '';
				if(strpos($urlstatus, "301 Moved Permanently")!= false) $status301 = $urlstatus;
				if(strpos($urlstatus, "404 Not Found")!= false) $status404 = $urlstatus;
				if(strpos($urlstatus, "503 Service Unavailable")!= false) $status503 = $urlstatus;
				
				if ($urlstatus == $status200) {
				$url_name = 'temp/' . $links_table . '/' . $link_id . '.html';
				$dir_name = 'temp/' . $links_table;
				if (!is_dir($dir_name)) { mkdir($dir_name,0755); }
				//echo $url_name;
				file_put_contents($url_name,$url_content);
				$sql3 = "UPDATE $links_table SET local_link = '$url_name', downloaded = '1' WHERE link = '$p_link'";
				if(isset($testmode)) { echo $sql3 . '<br>'; }
				$result3 = mysql_query($sql3);
				} else {
				$sql3 = "UPDATE $links_table SET downloaded = '1' WHERE link = '$p_link'";
				if(isset($testmode)) { echo $sql3 . '<br>'; }
				$result3 = mysql_query($sql3);
				}
			}
		}
		$sql4 = "UPDATE `!sites` SET updated2 = now() where id = '$siteid'";
		if(isset($testmode)) { echo $sql4 . '<br>'; }
		$result4 = mysql_query($sql4);
	}

?>