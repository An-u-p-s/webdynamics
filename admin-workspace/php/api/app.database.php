<?php
require_once 'app.initiator.php';
 
$tableInfoJson;  // Global Variable Table Information Schema in JSON
class Database
{
    private $logger;
    function __construct() {
       $this->logger= Logger::getLogger("api.database.php");
    }
    
    function connectMySQLServer($serverName, $username, $pwd)
    {
      $GLOBALS["GLOB_DBACCESS"]='success';
        // Connecting Database
          $this->logger->info("Connecting to Database ...");
          $this->logger->info("ServerName : ".$serverName);
          $this->logger->info("Username : ".$username);
          $this->logger->info("Password : ".$pwd);
          
        $conn = new mysqli($serverName, $username, $pwd);
        if ($conn->connect_error) {  
                                     $this->logger->info("Connection Status : Failed (MESSAGE : ".$conn->connect_error.")");
                                     $GLOBALS["GLOB_DBACCESS"]='failure';
                                     die("Connection failed: " . $conn->connect_error); 
                                  } 
        $this->logger->info("Connection Status : Success"); 
               
            
        return $conn;
    }
   
    
    function dbinteraction()
    {
        global $GLOB_SERVER_NAME, $GLOB_DATABASE, $GLOB_USERNAME, $GLOB_PASSWORD;
        
        // Connecting Database
          $this->logger->info("Connecting to Database ...");

        $conn = new mysqli($GLOB_SERVER_NAME,$GLOB_USERNAME, $GLOB_PASSWORD, $GLOB_DATABASE);
        if ($conn->connect_error) { /* die("Connection failed: " . $conn->connect_error); */
                                     $this->logger->info("Connection Status : Failed (MESSAGE : ".$conn->connect_error.")");   
                                  } 
        else { $this->logger->info("Connection Status : Success"); }
        return $conn;
    }
   
   
    function getJSONData($sql)
    {
        $db=new Database();
        $conn = $db->dbinteraction();
        $result = mysqli_query($conn, $sql); 
        $json="";
         if (!$result) {   die("Invalid query: " . mysqli_error($conn));  }
         else {
                $rows= array();
                while($row = $result->fetch_assoc()) {  $rows[] = $row; }
                $json = json_encode($rows);
              }
        mysqli_free_result($result); 
        $conn->close();
        return $json;
    }
    
     function getDBSchemaJSON() //put your code here
     {
        // Get Global Variables
            global $GLOB_SERVER_NAME,$GLOB_DATABASE,$GLOB_USERNAME,$GLOB_PASSWORD;     // global variable
            global $tableInfoJson;   // global variable :: Table Information Array
          
            
        // Get Tables List with its Details
          $dbObject=new Database();
          $tablesQuery="SHOW TABLES FROM ".$GLOB_DATABASE;
          $tableJson=$dbObject->getJSONData($tablesQuery);
          $tabledejson=json_decode($tableJson);
          
          $this->logger->info("List of Tables : ");
           $tableInfoJson="[";
           
            for($tabind=0;$tabind<count($tabledejson);$tabind++)
            {
                $this->logger->info("Table - ".$tabledejson[$tabind]->{'Tables_in_'.$GLOB_DATABASE});
                $tableInfoJson.="{\"table\":"."\"".$tabledejson[$tabind]->{'Tables_in_'.$GLOB_DATABASE}."\",";
                $sql="SHOW COLUMNS FROM ".$GLOB_DATABASE.".".$tabledejson[$tabind]->{'Tables_in_'.$GLOB_DATABASE};
                $tableInfoJson.="\"columns\":". $dbObject->getJSONData($sql)."},";
               
            }
          $tableInfoJson= chop($tableInfoJson, ",");
          $tableInfoJson.="]";
          $this->logger->info("Table Details : ".$tableInfoJson);

    }
    
    
  
}
 
  
 