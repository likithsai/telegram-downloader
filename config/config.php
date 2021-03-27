<?php
    require_once './class/Database.php';

    define('APP_NAME', 'Telegram Manager');
    define('APP_VERSION', 'V 1.0.0');
	define('APP_HIDE_ERROR', 'FALSE');
	
    //  Database configure
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBNAME', 'telegram_manager');
	
	//	Logic for hiding errors in PHP
	if(APP_HIDE_ERROR == "TRUE") {
		error_reporting(0);
    }

    //  Setup Database
    $db = new MysqliDB(DBHOST, DBUSER, DBPASS, DBNAME);

?>