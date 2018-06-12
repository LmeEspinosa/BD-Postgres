<?php

	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.
	
	//define('DBHOST', 'localhost');
	//define('DBUSER', 'lucasespinosa');
	//define('DBPASS', 'shakadvirgo-1981');
	//define('DBNAME', 'lucasespinosa');
	
	//$conn = pg_connect(DBHOST,DBNAME,DBUSER,DBPASS);
	
	pg_connect("host=localhost dbname=lucasespinosa user=lucasespinosa password=lme")or die('ERROR AL CONECTAR: ' . pg_last_error());
	
	//if ( !$conn ) {
	//	die("Connection failed : " . pg_last_error());
	//}
	
	//if ( !$dbcon ) {
		//die("Database Connection failed : " . pg_last_error());
	//}
