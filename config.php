<?php

	if ( $_SERVER["SERVER_NAME"] == "dannegm" ){
		define("domain", $_SERVER['SERVER_NAME'] . "/s");
		define("db_server", "localhost");
		define("db_user", "root");
		define("db_password", "");
		define("db_bdata", "short_url");
	}else{
		define("domain", $_SERVER['SERVER_NAME']);
		define("db_server", "localhost");
		define("db_user", "root");
		define("db_password", "");
		define("db_bdata", "short_url");
	}

	//Base de datos
	define("tb_short", "links");

?>