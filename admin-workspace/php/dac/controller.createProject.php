<!--
=========================================================
PROJECT STRUCTURE
=========================================================
ProjectName
-->
<?php 
if($_GET["action"]=='createProject') {
$userId=$_GET["userId"];
$projName=$_GET["projName"];
$projLang=$_GET["projLang"];

echo "userId: ".$userId.", projName: ".$projName.", projLang: ".$projLang.", ";
/* Creation process :: */
/* Folders and Files */
$projDir="../../users/".$userId."/".$projName;
$projArch=$projDir."/".$projName.".arch";
$projProp=$projDir."/".$projName.".properties";
$projDBFolder=$projDir."/"."databases";
$projWebServer=$projDir."/"."webservers";

echo "projDir: ".$$projDir.", projArch: ".$projArch.", projDBFolder: ".$projDBFolder.", projWebServer: ".$projWebServer;
mkdir($projDir);  // Creates Project Directory
mkdir($projDBFolder);  // Creates Project Databases Folder
mkdir($projWebServer);  // Creates Project WebServers Folder
fopen($projArch, "w") or die("Unable to open file!"); // Creates Project Architecture File
$projPropFile=fopen($projProp, "w") or die("Unable to open file!"); // Creates Project Properties File
$projPropFileContent='ProjectName='.$projName."\n";
$projPropFileContent.='Language='.$projLang."\n";
fwrite($projPropFile,$projPropFileContent);
fclose($projPropFile);
 echo 'Done';
}
if($_GET["action"]=='writeProjArchFileOnSave') {
   $fileWithPath=$_GET["fileWithPath"]; 
}



?>