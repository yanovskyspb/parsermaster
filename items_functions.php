<?php
function delAll($string) { 
	$string = delLines($string);
	$string = delTabs($string);
	$string = delSpaces($string);
	return $string;
}

function delTabs($string) { 
	$string = preg_replace("/\t/"," ",trim($string));
	$string = preg_replace("/> </","><",$string);
	return $string;
}

function delLines($string) { 
	$string = preg_replace("/\t/"," ",trim($string));
	$string = preg_replace("/\n/","",trim($string));
	$string = preg_replace("/\r/","",trim($string));
	$string = preg_replace("/> </","><",$string);
	return $string;
}

function delSpaces($string) { 
	$string = preg_replace('/\s+/', ' ', trim($string));
	$string = preg_replace("/\s{2,}/"," ",trim($string));
	$string = preg_replace('/  /', ' ', trim($string));
	$string = preg_replace("/> </","><",$string);
	$string = preg_replace("@\s+</@","</",$string);
	return $string;
}

function delLinks($string) { 
	$string = preg_replace('@<.?/.?a.?>@i','', $string);
	$string = preg_replace('@<\s?a.*?>@i','', $string);
	return $string;
}

function Replace($string, $find, $replace) {
    return str_replace($find, $replace, $string);
}

function PregReplace($string, $find, $replace) {
    return preg_replace('@'.$find.'@i', $replace, $string);
}

function delBR($string) { 
	$string = preg_replace('@(<.?br.?/?.?>){2,}@i', '<br />', $string);
	return $string;
}

function UpWords($string) { 
	$string = ucwords($string);
	return $string;
}
?>