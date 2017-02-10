<?php
// Directory

$dir_path = "temp/links_onekingslane";
function getDirPath($dir_path) {
	$directory1 = array_diff( scandir( $dir_path ), array(".", "..") );
	 $directory = preg_grep("/\.[html|jpg|gif|png|jpeg|zip|rar]/", $directory1, PREG_GREP_INVERT);
	
	sort($directory);
	print_r($directory);
	if(empty($directory)) {
		mkdir($dir_path . '/' . '1000',0755);
		$last_dir = '1000';
		}
	else {
		$last_dir = end($directory);
		}
	$target_path = $dir_path . '/' . $last_dir;

	$file_count = count( array_diff( scandir( $target_path ), array(".", "..") ) ); // exclude "." and ".."

	//large than 1000 or there is no folder
	if( $file_count > 2000){

		$new_name = $last_dir + 1;
		echo $new_name;
		$new_dir = $dir_path . '/' . $new_name;
		//echo $new_dir;
		if( !is_dir($new_dir) ) {
			mkdir($new_dir,0755);
	}
	}
	else {
		$new_dir = $target_path;
	}
	return $new_dir;
}
echo getDirPath($dir_path);
?>