<?php
if (isset($_GET['testmode'])) { $testmode = $_GET['testmode']; }
if (isset($_GET['items'])) { $itemsmode = $_GET['items']; }
if (isset($_GET['cats'])) { $catsmode = $_GET['cats']; }

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
	
	require 'C:\Users\Parser\vendor\autoload.php';
// ПАРАМЕТРЫ

	$proxy_url = 'http://173.0.156.113/px.php?purl=';

?>