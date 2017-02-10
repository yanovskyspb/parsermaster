<?php
require 'config.php';

$path = "temp/links_onekingslane";
$files = scandir($path);

//print_r($files);

$c = 1;
$d = 1;
foreach ($files as $file) {
	//echo $file;
	if (preg_match("@html@i", $file)) {
		$link_id = preg_replace("@\.html@","",$file);
		$newdir = 1100000 + $d;
		$newpath = 'temp/links_onekingslane/' . $newdir . '/' . $file;
		$newfiles[] = array('oldpath' => $path . '/' . $file, 'newpath' => $newpath, 'newdir' => $newdir, 'link_id' => $link_id);
		$c++;
		if ($c > 1000) { $d++; $c = 1; }
	}
}

//print_r($newfiles);

foreach ($newfiles as $new) {
	$old_path = $new['oldpath'];
	$new_path = $new['newpath'];
	$new_dir = $new['newdir'];
	$link_id = $new['link_id'];
	$sql = "UPDATE links_onekingslane SET local_link = '$new_path', timestring = now() WHERE id = '$link_id'";
	//echo $sql . ';<br>';
	$result = mysql_query($sql);
	$dir_name = 'temp/links_onekingslane/' . $new_dir;
	if (!is_dir($dir_name)) { mkdir($dir_name,0755); }
	rename($old_path,$new_path);
}
?>