<?php
use SleepingOwl\Apist\Apist;
	class HabrApi extends Apist
	{
	public function getBaseUrl()
	{
	$environment = '';
	if ($environment === 'local')
	{
	return 'http://habrahabr.my';
	} else
	{
	return 'http://habrahabr.ru';
	}
	}
	public function index()
	{
	return $this->get('/', [
	'title' => Apist::filter('.page_head')->exists()->then(
	Apist::filter('.page_head .title')->trim()
	)->else(
	'Title not found'
	),
	'title_updated' => Apist::filter('.page_head .title')->text()->call(function ($title)
	{
	return 'Modified Title: ' . $title;
	}),
	'posts_list' => Apist::filter('.posts .post')->each(function ($node, $i)
	{
	return ($i + 1) . '. ' . $node->filter('.title a')->text();
	}),
	'posts' => Apist::filter('.posts .post')->each([
	'title' => Apist::filter('h1.title a')->text(),
	'link' => Apist::filter('h1.title a')->attr('href'),
	'hubs' => Apist::filter('.hubs a')->each(Apist::filter('*')->text()),
	'views' => Apist::filter('.pageviews')->intval(),
	'favs_count' => Apist::filter('.favs_count')->intval(),
	'content' => Apist::filter('.content')->html(),
	'author' => [
	'username' => Apist::filter('.author a'),
	'profile_link' => Apist::filter('.author a')->attr('href'),
	'rating' => Apist::filter('.author .rating')->text()
	]
	]),
	]);
	}
	public function get404()
	{
	return $this->get('/unknown-page', 'this-will-be-ignored');
	}

	public function getUrls($url)
	{
		return $this->get($url, [
			'links' => Apist::filter('a')->each([
			'link' => Apist::filter('*')->attr('href')->addDomain()->clearUrls()
			])
		]);
	}
}

function addDomain($string) { 
global $domain, $p_link;
	if (!preg_match("@^$domain@i", $string) && preg_match("@^$domain@i", $p_link) && !preg_match("@https?://@i", $string) && !preg_match("@#@i", $string)) {
	$string = $domain . $string;
	}
	$string = trim($string);
	return $string;
}

function ClearUrls($string) { 
global $filterurls;
	if (preg_match("@$filterurls@i", $string)) {
	$string = '';
	}
	$string = trim($string);
	return $string;
}

function TrimUrls($string) { 
global $trimurls;
	$string = preg_replace("@$trimurls@i", '', $string);
	$string = trim($string);
	return $string;
}

function GetLinkType($link) {
global $item, $category;
	if (preg_match("@$category@i", $link)) {
	$linktype = '2';
	}
	elseif (preg_match("@$item@i", $link) && !preg_match("@$category@i", $link)) {
	$linktype = '1';
	}
	else {
	$linktype = '0';
	}
return $linktype;
}

function native($url) {
global $proxy, $proxy_url;
// SET REQUEST HEADERS
		$opts = array(
		  'http'=>array(
			'header'=>"Accept-language: ru\r\n" .
					  "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"
		  )
		);
		 
	$context = stream_context_create($opts);
	//echo $url;
	if ($proxy == 'NO') {
		$links_content = file_get_contents($url, false, $context);
	} else {
		$url = urlencode($url);
		$url = $proxy_url . $url;
		$links_content = file_get_contents($url, false, $context);
	}
// ПОЛУЧАЕМ ЗАГОЛОВКИ НА СЛУЧАЙ ЕСЛИ ОТВЕТ БУДЕТ НЕ 200/ОК
	$headers = get_headers($url,1);
	$urlstatus = $headers[0]; //echo $urlstatus;

	if(strpos($urlstatus, "200 OK")!= false) $status200 = $urlstatus;
	if(strpos($urlstatus, "301 Moved Permanently")!= false) $status301 = $urlstatus;
	if(strpos($urlstatus, "404 Not Found")!= false) $status404 = $urlstatus;
	if(strpos($urlstatus, "503 Service Unavailable")!= false) $status503 = $urlstatus;
	
	if ($proxy == 'YES') {
		//$links_content = preg_replace('@\"@iu', '"', $links_content);
		$links_content = stripslashes($links_content);
	}
	//echo '<textarea style="width: 1024px; height: 400px;">' . $links_content . '</textarea>';	
	//preg_match_all("/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>/siU",$links_content, $links);
	preg_match_all("/<a[^>]*href=[\"']([^\"']*)[^>]*>/i",$links_content, $links);
	$links = $links[1];
	
	//echo $urlstatus . '<br />';
	if (isset($status301) && $urlstatus == $status301) { $links[] = 'return301'; }
	if (isset($status404) && $urlstatus == $status404) { $links[] = 'return404'; }
	
	return $links;
}
?>