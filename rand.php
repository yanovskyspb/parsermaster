<?php
require 'config.php';

	$sql1 = "SELECT * FROM `items_onekingslane` ORDER BY RAND() LIMIT 1";
	$result1 = mysql_query($sql1);
	while ($row1 = mysql_fetch_assoc($result1)) {
		$start = $row1['title'];
		$brand = $row1['brand'];
		$options = $row1['keywords'];
		$skuid = $row1['site_id'];
	}


function keywordGenerator($start, $brand, $options, $skuid) {
	$start = preg_replace('@([^0-9a-zA-Z\s-&]+)@iu', '', $start);
	$brand = preg_replace('@([^0-9a-zA-Z\s-&]+)@iu', '', $brand);
	$options = preg_replace('@([^0-9a-zA-Z\s-,]+)@iu', '', $options);
	
	$keywords = array($start);
	$mod = $start;
	$words = str_word_count($start);
	$words2 = str_word_count($start);
	$ctr = str_word_count($start);
	while($words > 2) {
		$mod = preg_replace('@\s([0-9a-zA-Z-]+?)$@iu', '', $mod);
		$keywords[] = $mod;
		$words = $words-1;
	}

	foreach ($keywords as $key) {
		$twords = $words2;
		while($words2 >= 0) {
			$words_mod = explode(" ", $key);
			unset($words_mod[$words2]);
			$textWithoutLastWord = implode(" ", $words_mod);
			$keywords[] = $textWithoutLastWord;
			$words_mod = preg_replace('@\s([0-9a-zA-Z-]+?)$@iu', '', $textWithoutLastWord);
			$keywords[] = $words_mod;

			$words2 = $words2-1;
		}
		$words2 = $twords;
	}
	$keywords = array_unique($keywords, SORT_REGULAR);
	$keywords = array_values($keywords);

	$i = 0;
	foreach ($keywords as $key) {
		$ct = str_word_count($key);
		if ($ct < 3) { unset($keywords[$i]); }
		$i++;
	}

	$keywords = array_unique($keywords, SORT_REGULAR);
	$keywords = array_values($keywords);


// ЕСЛИ ЗАДАНЫ ОПЦИИ
	if ($options != '') {
		$options_arr = explode(",", $options);
		foreach ($keywords as $key) {
		$i = 0;
			foreach ($options_arr as $option) {
				if (strpos($key, $option) === false) {
					$keywords[] = $key . ' ' . $option;
				}
			}
		$i++;
		}
	}


// ЕСЛИ ЗАДАН БРЕНД
	if ($brand != '') {
		$i = 0;
		foreach ($keywords as $key) {
			$ct = str_word_count($key);
			if ($brand == $key) { unset($keywords[$i]); }
			/*if (!preg_match("@$brand@i", $key)) {*/
			if (strpos($key, $brand) === false) {
				$up_key = preg_replace('@\s[^a-z](\s|$){1,1}@iu', ' ', $key);
				$keywords = array_replace($keywords, array($i => $up_key));
				//echo $up_key . '<br />';
				unset($up_key);
				}
			$i++;
			if (strpos($key, $brand) === false) {
				$keywords[] = $brand . ' ' . $key;
			}
		}		
	}


// ЕСЛИ ЗАДАН SKU ИЛИ ДРУГОЙ ID
	if ($skuid != '') {
		$i = 0;
		foreach ($keywords as $key) {
			$ct = str_word_count($key);
			if ($ct < 4) {
					$up_key = $key . ' ' . $skuid;
					$keywords[] = $up_key;
					//echo $up_key . '<br />';
					unset($up_key);
				}
			$i++;
		}		
	}
	
// ПОСЛЕДНИЕ ШТРИХИ
	$keywords = preg_replace('@^[^a-z0-9]{1,1}\s@iu', '', $keywords);
	$keywords = preg_replace('@\s[^a-z0-9]{1,1}$@iu', '', $keywords);
	$keywords = preg_replace('@\s{2,}@iu', ' ', $keywords);
	$keywords = array_unique($keywords, SORT_REGULAR);
	$keywords = array_values($keywords);
	
	$i = 0;
	foreach ($keywords as $key) {
		$ct = str_word_count($key);
		if ($ct > $ctr) {
				unset($keywords[$i]);
			}
		$i++;
	}
	
	$keywords = array_unique($keywords, SORT_REGULAR);
	$keywords = array_values($keywords);

return $keywords;
}

$keywords = keywordGenerator($start, $brand, $options, $skuid);
print_r($keywords);
?>