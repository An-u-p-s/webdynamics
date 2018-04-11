<?php 

 /* Logger Declaration in JSON */ 
	 include('..\..\log4php\Logger.php'); 
	 Logger::configure('..\..\conf\config.xml'); 

 /* Database Credentials */ 
	 define("SERVER_NAME","localhost:3306", true); 
	 define("DB_NAME","ws_mware", true); 
	 define("DB_USER","root", true); 
	 define("DB_PASSWORD","", true); 
