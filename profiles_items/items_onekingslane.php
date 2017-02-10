<?php
require 'C:\Users\Parser\vendor\autoload.php';

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
	return 'http://localhost/parser/';
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

	public function getPost($url)
	{
		return $this->get($url, [
		 'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'
    ],
			'vendor_id' => Apist::filter('div button.favorite')->attr('data-product-id'),
			'title' => Apist::filter('div h1.product-name')->text()->trim()->delAll(),
			'description' => Apist::filter('div div.first-col')->html()->trim()->delLinks()->delAll(),
			'description2' => Apist::filter('div div.brand-bio')->html()->trim()->delLinks()->delAll(),
			'description3' => Apist::filter('div div.actual-description')->html()->trim()->delLinks()->delAll(),
			//'selectedVariant' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.groupSelectors div.variationSelectors div#mpVariationSelectBox div#variationSelect_c.variationOptions a.variationOption.selected')->text()->trim(),
			//'brand' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.productSpec dl.hzAttributes.horizontal-list.normal-text dd.value span.productManufacturer')->text()->trim(),
			'json' => Apist::filter('html head')->html()->delAll()->trim()->PregReplace('^(.+?)OKL\.var', 'OKL.var')->PregReplace(';<\/script>(.+)$', '')->PregReplace('OKL\.vars=', ''),
			'price' => Apist::filter('html head')->html()->delAll()->trim()->PregReplace('^(.+?)"price":"\$', '')->PregReplace('<\/script>(.+)$', '')->PregReplace('[^0-9\.]', ''),
			//'oldPrice' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.buyContainer div.clearfix div#vlPrices.priceBox div.price2 span.msrp')->text()->trim(),			
			//'specification' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.productSpec dl.hzAttributes.horizontal-list.normal-text')->html()->delAll()->delLinks()->delAll(),
			//'variations' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.groupSelectors div.variationSelectors div#mpVariationSelectBox a')->each(Apist::filter('*')->text()),
			//'categories' => Apist::filter('div.container div.leftSideContentNarrow div.navigationTopicBreadcrumbs div ul.breadcrumb')->text()->delLinks()->delAll()->Replace('All Products / ', ''),
			//'related' => Apist::filter('div.container div.rightSideBarWide div#relatedSearches.r-sidebar')->text()->Replace('Related Searches:', '')->Replace(' · ', ','),
			//'keywords' => Apist::filter('div.container div.rightSideBarWide div#keywordsDiv.r-sidebar')->text()->DelSpaces()->Replace(' · ', ', ')->Replace('Keywords ', '')->UpWords(),
			'mainimg' => Apist::filter('div div img#main-image')->attr('src'),
			'imgs' => Apist::filter('div#scrollImage')->text()
		]);
	}
}

function postProd($parser_result)
{
	global $mark1, $mark2, $p_site_id, $p_title, $p_brand, $p_description, $p_description2, $p_price, $p_msrp, $p_main_image;
	//echo $parser_result['json'];
	$js = json_decode($parser_result['json'], TRUE);
	$p_site_id = $js['tealiumData']['product_id'];
	if ( !preg_match("@$parser_result\['title'\]@i", $js['tealiumData']['product_brand']) && $js['tealiumData']['product_brand'] != '') { $p_title = $js['tealiumData']['product_brand'] . ' ' . $parser_result['title']; }
	else { $p_title = $parser_result['title']; }
	$p_brand = $js['tealiumData']['product_brand'];
	$p_description = $parser_result['description3'] . '<p>' . $parser_result['description2'] . '</p>' . $parser_result['description'];
	$p_description2 = $parser_result['description'];
	$p_price = $js['tealiumData']['product_okl_price'];
	$p_msrp = $js['tealiumData']['product_msrp_price'];
	$p_main_image = $parser_result['mainimg'];
	
	$mark1 = $p_title;
	$mark2 = $p_main_image;
	
	return;
}
?>