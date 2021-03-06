﻿<?php
require 'C:\Users\Dmitriy\vendor\autoload.php';
require 'items_functions.php';

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

	public function getPost($url)
	{
		return $this->get($url, [
		 'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'
    ],
	'titl' => Apist::filter('div.price')->text()->trim(),
			'title' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div header.productTitle.light-rule h1.large-header')->text()->trim(),
			'description' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.description')->html()->trim()->delLinks()->delBR(),
			'description2' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.vendorDesc div.descContent')->html()->trim()->delLinks()->delBR(),
			'selectedVariant' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.groupSelectors div.variationSelectors div#mpVariationSelectBox div#variationSelect_c.variationOptions a.variationOption.selected')->text()->trim(),
			'brand' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.productSpec dl.hzAttributes.horizontal-list.normal-text dd.value span.productManufacturer')->text()->trim(),
			'price' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.buyContainer div.clearfix div#vlPrices.priceBox div#vlPrice.price.ms300')->text()->trim(),
			'oldPrice' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.buyContainer div.clearfix div#vlPrices.priceBox div.price2 span.msrp')->text()->trim(),			
			'specification' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.detailBox div.productSpec dl.hzAttributes.horizontal-list.normal-text')->html()->delAll()->delLinks()->delAll(),
			'variations' => Apist::filter('div.container div.rightSideBarWide div#hzProductInfo.marketplace.mp.hzProduct div div.buyBox div.groupSelectors div.variationSelectors div#mpVariationSelectBox a')->each(Apist::filter('*')->text()),
			'categories' => Apist::filter('div.container div.leftSideContentNarrow div.navigationTopicBreadcrumbs div ul.breadcrumb')->text()->delLinks()->delAll()->Replace('All Products / ', ''),
			'related' => Apist::filter('div.container div.rightSideBarWide div#relatedSearches.r-sidebar')->text()->Replace('Related Searches:', '')->Replace(' · ', ','),
			'keywords' => Apist::filter('div.container div.rightSideBarWide div#keywordsDiv.r-sidebar')->text()->DelSpaces()->Replace(' · ', ', ')->Replace('Keywords ', '')->UpWords(),
			'mainimg' => Apist::filter('div.container div.leftSideContentNarrow div.spaceContent div.viewSpaceImage img#mainImage.viewImage')->attr('src'),
			'imgs' => Apist::filter('div#scrollImage')->text()
		]);
	}
}

$p_link = 'http://www.houzz.com/photos/7240516/Fresca-Sesia-Widespread-Chrome-Bathroom-Faucet-modern-bathroom-faucets';
$api = new HabrApi;
$parser_result = $api->getPost($p_link);



print_r($parser_result);
echo '<br /><hr />';
echo '<textarea cols="120" rows="10">';
echo $parser_result['specification'];
echo '</textarea>';


?>