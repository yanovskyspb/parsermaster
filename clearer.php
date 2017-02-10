<?php
// НАСТРОЙКИ PHP
	date_default_timezone_set("Europe/Moscow");

	ini_set('memory_limit', '-1');
	ini_set("max_execution_time", "0");

// ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ

	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASSWORD', '');
	define('NAME_BD', 'parser_master');

	$connect = mysql_connect(HOST, USER, PASSWORD);
	mysql_select_db(NAME_BD, $connect);

	mysql_query("SET NAMES 'utf8';");
	mysql_query("SET CHARACTER SET 'utf8';");
	mysql_query("SET SESSION collation_connection = 'utf8_general_ci';");

	$sql1 = "SELECT * FROM `!sites` WHERE status = '1' ORDER BY id DESC";
	$result1 = mysql_query($sql1) or die(mysql_error());
	$num_rows = mysql_num_rows($result1);

	while ($row1 = mysql_fetch_assoc($result1)) {
		$siteprefix = $row1['siteprefix'];
		$siteurl = $row1['siteurl'];

		$sql = "DELETE from links_$siteprefix where link not like '$siteurl%'";
		//echo $sql . '<br>';
		$result = mysql_query($sql);
		sleep(3);
	}
?>