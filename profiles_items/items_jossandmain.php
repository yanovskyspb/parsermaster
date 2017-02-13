<?php

use SleepingOwl\Apist\Apist;
	class HabrApi extends Apist
	{
	public function getBaseUrl()
	{
	global $environment;
	if ($environment === 'local')
	{
	return 'http://localhost/p_tests/parsermaster/';
	} else
	{
	return 'http://localhost/parsermaster/';
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
			'vendor_id' => Apist::filter('html head')->html()->trim()->delAll()->PregReplace('^(.+?),"sku":"', '')->PregReplace('"(.+?)$', ''),
			'title' => Apist::filter('div h1')->text()->trim()->delAll()->PregReplace('&reg;', ''),
			'description' => Apist::filter('div#information')->html()->trim()->delLinks()->delAll()->PregReplace('<div class="js-product-feedback-div(.+)$', '')->PregReplace(' class="(.+?)"', '')->PregReplace('<h2>(.+?)</h2>', '')->PregReplace('(<div>|</div>)', '')->PregReplace('^<p>Features</p>', ''),
			'description2' => Apist::filter('div div.brand-bio')->html()->trim()->delLinks()->delAll(),
			'description3' => Apist::filter('div div.actual-description')->html()->trim()->delLinks()->delAll(),
			//'selectedVariant' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.groupSelectors div.variationSelectors div#mpVariationSelectBox div#variationSelect_c.variationOptions a.variationOption.selected')->text()->trim(),
			'brand' => Apist::filter('html head')->html()->trim()->delAll()->PregReplace('^(.+?),"brand":"', '')->PregReplace('"(.+?)$', '')->PregReplace('&reg;', ''),
			//'json' => Apist::filter('html head')->html()->delAll()->trim()->PregReplace('^(.+?)wf\.extend\({"wf":{"config', 'wf.extend({"wf":{"config')->PregReplace(';<\/script>(.+)$', '')->PregReplace('wf\.extend', ''),
			'price' => Apist::filter('html body')->html()->trim()->delAll()->PregReplace('^(.+?),"unit_sale_price":', '')->PregReplace(',"(.+?)$', ''),
			'oldPrice' => Apist::filter('html body')->html()->trim()->delAll()->PregReplace('^(.+?),"regular_price":', '')->PregReplace(',"(.+?)$', ''),
			//'oldPrice' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.buyContainer div.clearfix div#vlPrices.priceBox div.price2 span.msrp')->text()->trim(),			
			//'specification' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.productSpec dl.hzAttributes.horizontal-list.normal-text')->html()->delAll()->delLinks()->delAll(),
			//'variations' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.groupSelectors div.variationSelectors div#mpVariationSelectBox a')->each(Apist::filter('*')->text()),
			'categories' => Apist::filter('nav.Breadcrumbs')->html()->Replace('</li>', ',')->delAll()->delLinks()->delAll()->PregReplace('<(.+?)>', '')->delAll()->Replace(' , ', ',')->PregReplace(' ,$', ''),
			//'related' => Apist::filter('div.container div.rightSideBarWide div#relatedSearches.r-sidebar')->text()->Replace('Related Searches:', '')->Replace(' · ', ','),
			//'keywords' => Apist::filter('div.container div.rightSideBarWide div#keywordsDiv.r-sidebar')->text()->DelSpaces()->Replace(' · ', ', ')->Replace('Keywords ', '')->UpWords(),
			'mainimg' => Apist::filter('a img.ProductDetailImagesBlock-carousel-image')->attr('src'),
			'imgs' => Apist::filter('img.ProductDetailImagesThumbnails-item')->each(Apist::filter('*')->attr('src'))
		]);
	}
}

function postProd($parser_result)
{
	global $mark1, $mark2, $p_site_id, $p_title, $p_brand, $p_description, $p_description2, $p_price, $p_msrp, $p_main_image, $p_images;
	//echo $parser_result['json'];
	//$js = json_decode($parser_result['json'], TRUE);
	//echo $js;
	$p_site_id = $parser_result['vendor_id'];
	$p_title = $parser_result['title'];
	if (!preg_match("@$parser_result\['brand'\]@i", $p_title) && $parser_result['brand'] != '') { $p_title = $parser_result['brand'] . ' ' . $parser_result['title']; }
	$p_brand = $parser_result['brand'];
	$p_description = $parser_result['description'];
	$p_description2 = $parser_result['categories'];
	//echo $p_description2;
	$p_price = $parser_result['price'];
	$p_msrp = $parser_result['oldPrice'];
	$p_main_image = $parser_result['mainimg'];
	$p_images = implode($parser_result['imgs'],',');
	//echo $p_images;
	
	$mark1 = $p_title;
	$mark2 = $p_main_image;
	
	return;
}
?>