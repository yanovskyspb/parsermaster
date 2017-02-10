<?php
// ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
	if (strpos($_SERVER['REQUEST_URI'],'/p_tests/') === false) {
		// БОЕВАЯ СРЕДА
		define('HOST', 'localhost');
		define('USER', 'root');
		define('PASSWORD', '');
		define('NAME_BD', 'parser_master');
	} else {
		//ТЕСТОВАЯ СРЕДА
		define('HOST', 'localhost');
		define('USER', 'root');
		define('PASSWORD', '');
		define('NAME_BD', 'parser_master_tests');
	}
?>