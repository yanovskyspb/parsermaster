<?php
$url = 'http://www.madeindesign.co.uk';
// SET REQUEST HEADERS
		$opts = array(
		  'http'=>array(
			'header'=>"Accept-language: ru\r\n" .
					  "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"
		  )
		);
		 
	$context = stream_context_create($opts);
	echo $url;
	$links_content = file_get_contents($url, false, $context);
// ПОЛУЧАЕМ ЗАГОЛОВКИ НА СЛУЧАЙ ЕСЛИ ОТВЕТ БУДЕТ НЕ 200/ОК
	$headers = get_headers($url,1);
	$urlstatus = $headers[0]; //echo $urlstatus;
	
	//if(strpos($urlstatus, "200 OK")!= false) $status200 = $urlstatus;
	//if(strpos($urlstatus, "301 Moved Permanently")!= false) $status301 = $urlstatus;
	//if(strpos($urlstatus, "404 Not Found")!= false) $status404 = $urlstatus;
	//if(strpos($urlstatus, "503 Service Unavailable")!= false) $status503 = $urlstatus;
	
	//echo '<textarea style="width: 1024px; height: 400px;">' . $links_content . '</textarea>';	
	//preg_match_all("/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>/siU",$links_content, $links);
	preg_match_all("/<a[^>]*href=[\"']([^\"']*)[^>]*>/i",$links_content, $links);
	$links = $links[1];
	
	//echo $urlstatus . '<br />';
	if (isset($status301) && $urlstatus == $status301) { $links[] = 'return301'; }
	if (isset($status404) && $urlstatus == $status404) { $links[] = 'return404'; }
	print_r($links);
	return $links;
?>
