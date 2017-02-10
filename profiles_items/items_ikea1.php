<?php
require 'config.php';

require 'C:\Users\Parser\vendor\autoload.php';
require 'items_functions.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$i = 1;
while($i <= 5) {
	echo $i . '<hr>';
	$sql1 = "SELECT id,link FROM ikea2_items WHERE reparse = '0' order by timestring ASC limit 1";
	//echo $sql1 . '<br>';
    $result1 = mysql_query($sql1) or die(mysql_error());
	$num_rows = mysql_num_rows($result1);
		if ($num_rows != 0) {
			while ($row1 = mysql_fetch_assoc($result1)) {
			$p_id = $row1['id'];
			$p_link = $row1['link'];
			
			$data = file_get_contents($p_link);
			$response = $http_response_header;
			$resp = $response[0];
			//if ($resp == 'HTTP/1.0 503 Service Unavailable') { $i++; }
			$i++;
			//echo $data;
			$data = delAll($data);
			preg_match('/jProductData = (.+?)var/i', $data, $parser_result);
			//print_r($parser_result);
			$parser_result = $parser_result[1];
			
			preg_match('@IRWStats.categoryLocal" content="(.+?)"@iu', $data, $categoryLocal);
			$categoryLocal = trim($categoryLocal[1]);
			preg_match('@IRWStats.subCategoryLocal" content="(.+?)"@iu', $data, $subCategoryLocal);
			$subCategoryLocal = trim($subCategoryLocal[1]);
			preg_match('@IRWStats.chapterLocal" content="(.+?)"@iu', $data, $chapterLocal);
			$chapterLocal = trim($chapterLocal[1]);
			$breadCrumb = $categoryLocal . ' / ' . $subCategoryLocal;
			if (isset($chapterLocal) && $chapterLocal != '') { $breadCrumb = $breadCrumb . ' / ' . $chapterLocal; }
			
			$parser_result = preg_replace('/;$/iu', '', trim($parser_result));
			$json_string = addslashes(preg_replace('/;$/iu', '', trim($parser_result)));
			$parser_result = json_decode($parser_result, TRUE);
			//echo $p_link . '<br/>';
			print_r($parser_result);
			$count_items = count($parser_result['product']['items']);
			$c = 0;
			while ($c < $count_items) {
				//echo $c . '<br>';
				$partNumber = $parser_result['product']['items'][$c]['partNumber'];
				$partNumberDt = preg_replace('/(^[a-z]{1})/iu', '', trim($partNumber));
				$partNumberDt = preg_replace('/(^[0-9]{3})/iu', "$0.", trim($partNumberDt));
				$partNumberDt = preg_replace('/(\.[0-9]{3})/iu', "$0.", trim($partNumberDt));
				$catEntryId = $parser_result['product']['items'][$c]['catEntryId'];
				$goodToKnow = $parser_result['product']['items'][$c]['goodToKnow'];
				$custBenefit = $parser_result['product']['items'][$c]['custBenefit'];
				$custMaterials = $parser_result['product']['items'][$c]['custMaterials'];
				$metric = $parser_result['product']['items'][$c]['metric'];
				$careInst = $parser_result['product']['items'][$c]['careInst'];
				$designer = $parser_result['product']['items'][$c]['designer'];
				$nopackages = $parser_result['product']['items'][$c]['nopackages'];
				$rawPrice = $parser_result['product']['items'][$c]['prices']['normal']['priceNormal']['rawPrice'];
				$FamilyPrice = $parser_result['product']['items'][$c]['prices']['familyNormal']['priceNormal']['value'];
				$FamilyPrice = preg_replace('/[^0-9]/iu', '', trim($FamilyPrice));
				$images = $parser_result['product']['items'][$c]['images']['zoom'];
				$url = 'http://ikea.com'.$parser_result['product']['items'][$c]['url'];
				$type = $parser_result['product']['items'][$c]['type'];
				$name = $parser_result['product']['items'][$c]['name'];
				$color = $parser_result['product']['items'][$c]['color'];
				$validDesign = $parser_result['product']['items'][$c]['validDesign'];
				$validDesign = implode(', ',$validDesign);
				$title = $type . ' ' . $name;
				if (isset($color) && $color != '') { $title = $title . ' ' . $color; }
				if (isset($validDesign) && $color == '') { $title = $title . ' ' . $validDesign; }
				$quantity = $parser_result['product']['items'][$c]['metricPackageInfo'][0]['quantity'];
				$length = $parser_result['product']['items'][$c]['metricPackageInfo'][0]['length'];
				$width = $parser_result['product']['items'][$c]['metricPackageInfo'][0]['width'];
				$weight = $parser_result['product']['items'][$c]['metricPackageInfo'][0]['weight'];
				$height = $parser_result['product']['items'][$c]['metricPackageInfo'][0]['height'];

				$packagePopupUrl = 'http://ikea.com'.$parser_result['product']['items'][$c]['packagePopupUrl'];
				$attachments = $parser_result['product']['items'][$c]['attachments'];
				
				foreach ($attachments as $at) {
					//echo $at['type'];
					if ($at['type'] == 'ASSEMBLY_INSTRUCTIONS') { $assembly = 'http://ikea.com'.$at['atcharray'][0]['attachmentPath']; }
					if ($at['type'] == 'MANUALS') { $manuals = 'http://ikea.com'.$at['atcharray'][0]['attachmentPath']; }

				}
		$GoodToKnow = addslashes(trim(preg_replace('@<br\s?\/\s?>\s?<br\s?\/\s?>$@iu', '', trim($GoodToKnow))));
		$CustBenefit = addslashes(trim(preg_replace('@<br\s?\/\s?>\s?<br\s?\/\s?>$@iu', '', trim($CustBenefit))));
		$CustMaterials = addslashes(trim(preg_replace('@<br\s?\/\s?>\s?<br\s?\/\s?>$@iu', '', trim($CustMaterials))));
		$Metric = addslashes(trim(preg_replace('@<br\s?\/\s?>\s?<br\s?\/\s?>$@iu', '', trim($Metric))));
		$careInst = addslashes(trim(preg_replace('@<br\s?\/\s?>\s?<br\s?\/\s?>$@iu', '', trim($careInst))));
				//echo $assembly;
				//print_r($parser_result['product']);

				if ($rawPrice != '') {
					$images = implode(',',$images);
					$data1 =	
					';' . $p_id . ';' .
					'"' . addslashes($partNumber) . '";' .
					'"' . addslashes($partNumberDt) . '";' .
					'"' . addslashes($title) . '";' .
					'"' . addslashes($type) . '";' .
					'"' . addslashes($name) . '";' .
					'"' . addslashes($color) . '";' .
					'"' . addslashes($validDesign) . '";' .
					'"' . addslashes($rawPrice) . '";' .
					'"' . addslashes($FamilyPrice) . '";' .
					'"' . addslashes($url) . '";' .
					'"' . addslashes($images) . '";' .
					'"' . addslashes($goodToKnow) . '";' .
					'"' . addslashes($custBenefit) . '";' .
					'"' . addslashes($custMaterials) . '";' .
					'"' . addslashes($metric) . '";' .
					'"' . addslashes($careInst) . '";' .
					'"' . addslashes($designer) . '";' .
					'"' . addslashes($quantity) . '";' .
					'"' . addslashes($nopackages) . '";' .
					'"' . addslashes($length) . '";' .
					'"' . addslashes($width) . '";' .
					'"' . addslashes($height) . '";' .
					'"' . addslashes($weight) . '";' .
					'"' . addslashes($breadCrumb) . '";' .
					'"' . addslashes($packagePopupUrl) . '";' .
					'"' . addslashes($manuals) . '";' .
					'"' . addslashes($assembly) . '";' .
					'"' . addslashes($json_string) . '";0;' .
					PHP_EOL;
					//echo '<hr>';
					//echo $data;
					//file_put_contents('ikea4.csv',$data1,FILE_APPEND);
					$sql2 = "UPDATE ikea2_items SET reparse = '1', timestring = now() WHERE link = '$url'";
					$result2 = mysql_query($sql2);
					
					$sql3 = "UPDATE ikea2_items SET title = '$title', type = '$type', name = '$name', color = '$color', validDesign = '$validDesign', breadCrumb = '$breadCrumb', packagePopupUrl = '$packagePopupUrl', 
					assembly_instructionUrl = '$assembly', manualsUrl = '$manuals', json_string = '$json_string' WHERE link = '$url'";
					//echo $sql1 . '<br>';
					$result3 = mysql_query($sql3);
				}
				$c++;
			}
			if ($data1 != '') {
			} else {
			$sql2 = "UPDATE ikea2_items SET reparse = '0', timestring = now() WHERE link = '$p_link'";
			$result2 = mysql_query($sql2);				
			}
		}
	}
	sleep(10);
}
?>