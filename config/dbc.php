<?php
// ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
	if (strpos($_SERVER['REQUEST_URI'],'/p_tests/') === false) {
		// БОЕВАЯ СРЕДА
		define('HOST', 'localhost');
		define('USER', 'root');
		define('PASSWORD', '');
		define('NAME_BD', 'parser_master');
		
		require 'C:\Users\Parser\vendor\autoload.php';

	} else {
		//ТЕСТОВАЯ СРЕДА
		define('HOST', 'localhost');
		define('USER', 'root');
		define('PASSWORD', '');
		define('NAME_BD', 'parser_master_tests');
		
		require 'C:\Users\dm.ian\vendor\autoload.php';

	}
?>