<?php 
require_once '../api/app.filesAndFolder.php';

if($_GET["action"]=='saveArchFile'){
	$archJSON=$_GET["archJSON"];
	$jsonFile=$_GET["jsonFile"];
	
	$fmanger=new FileManagement();
	$fmanger->writeAFile($jsonFile, $archJSON);
}



?>