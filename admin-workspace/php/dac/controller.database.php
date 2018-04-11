<?php
require_once '../api/app.database.php';
/**============================================*
 *  MYSQL-SERVER MANAGEMENT QUERIES
 **============================================*
 * @author user1
 */
$db_action=$_GET["db_action"];

if($db_action=='Access_Database_Server')
{
    
    $GLOBALS["GLOB_DBACCESS"]='failure';
    
    $dbObj=new Database();
    $conn=$dbObj->connectMySQLServer($_GET["ServerName"], $_GET["Username"],$_GET["Password"] );
    
    echo  $GLOBALS["GLOB_DBACCESS"];
}
