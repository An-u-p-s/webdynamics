<?php
require_once '../api/app.database.php';
// require_once  '../api/app.initiator.php';

$logger;
$logger= Logger::getLogger("controller.action.php");
$logger->info("Generating PHP DAL-Files..");

$serverName=$_GET["dal_serverName"];
$database=$_GET["dal_databaseName"];
$username=$_GET["dal_userName"];
$password=$_GET["dal_password"];

$logger->info("Recieved following Database Credentials ..");
$logger->info("SERVER_NAME   : ".$serverName);
$logger->info("DATABASE_NAME : ".$database);
$logger->info("USERNAME      : ".$username);
$logger->info("PASSWORD      : ".$password);

if(isset($serverName)  && isset($database) && isset($username) && isset($password))
{
    // Setting to Global Variables
    $GLOB_SERVER_NAME=$serverName;
    $GLOB_DATABASE=$database;
    $GLOB_USERNAME=$username;
    $GLOB_PASSWORD=$password;
    
    $logger->info("Deleting Existing files in Output Folder ..");
    // Deleting existing in output folder
    $files = glob($outputFolder.'*');   // get all file names
    $logger->info("Files/Folders exist in Output Folder : ".count($files));
    if(count($files)>0)
    {
        foreach($files as $file)
            {   
                    // iterate files
                    if (is_dir($file) === true)
                    {
                        $logger->info($file." is a folder ");
                        $dirfiles = array_diff(scandir($file), array('.', '..'));

                        foreach ($dirfiles as $delfile)
                        {
                            $logger->info($delfile." is a file ");
                            if(unlink($file.'/'.$delfile))
                            {
                                 $logger->info($delfile." is a deleted file ");
                            }
                        }
                    }
                    else if (is_file($file) === true)
                    {
                         if(unlink($file))
                         {
                            $logger->info($file." is a deleted file ");
                         }
                    }
           
            }
    }
    

// Create Required Folders
if(!is_dir($apiFolder))  {  mkdir($apiFolder);  }
if(!is_dir($dalFolder))  {  mkdir($dalFolder);  }

// Providing supporting files to output files
   // Adding api.define.php File
      $defineFile=fopen("../../output/api/app.initiator.php", "w") or die("Unable to open file!"); 
        fwrite($defineFile, "<?php \n\n");
        fwrite($defineFile, " /* Logger Declaration in JSON */ \n");
        fwrite($defineFile, "\t include('..\..\log4php\Logger.php'); \n");
        fwrite($defineFile, "\t Logger::configure('..\..\conf\config.xml'); \n\n");


        fwrite($defineFile, " /* Database Credentials */ \n");
        fwrite($defineFile, "\t define(\"SERVER_NAME\",\"".$serverName."\", true); \n");
        fwrite($defineFile, "\t define(\"DB_NAME\",\"".$database."\", true); \n");
        fwrite($defineFile, "\t define(\"DB_USER\",\"".$username."\", true); \n");
        fwrite($defineFile, "\t define(\"DB_PASSWORD\",\"".$password."\", true); \n");

        fclose($defineFile);
       
   // Adding api.database.php, api.util.php
       copy("../support_files/api/app.database.php","../../output/api/app.database.php");
       copy("../support_files/api/app.util.php","../../output/api/app.util.php");

// Generating Table PHP Class Files using Database Schema
       $dbObject=new Database();  // Connecting to Database
       $dbObject->getDBSchemaJSON();  // Getting Tables, its Information in JSON Format which set in global variable '$tableInfoJson'
       $tableInfodeJson=json_decode($tableInfoJson); // Decoding JSON into an Array      



// Writing Individual Queries for Tables using $tableInfoJson
        
        
          for($queInd=0;$queInd<count($tableInfodeJson);$queInd++)
          {
              $tableName=$tableInfodeJson[$queInd]->{'table'};
              $column=$tableInfodeJson[$queInd]->{'columns'};
              $columnSize=count($column);
              
              // Create Independent Table File
                $indTableFile = fopen("../../output/dal/data.".$tableName.".php", "w") or die("Unable to open file!"); 
              
             // Create a PHP Class in the Table 
                fwrite($indTableFile, "<?php session_start(); \n");
                fwrite($indTableFile, "require_once '../api/app.database.php'; \n");
                fwrite($indTableFile, "class ".$tableName."  \n");
                fwrite($indTableFile, "/* CLASS-DESCRIPTION :  This class generates basic CRUD queries for the individual table '".$tableName."' \n");
                fwrite($indTableFile, " * TABLE-SCHEMA-INFORMATION     :   \n");
                fwrite($indTableFile, " * \t TABLE-NAME     : ".$tableName."  \n");
                
             /* InsertParameters */
              $inserfuncParam="";
              $insertParam="";
              $insertvalues="";
              
             /* SelectParameters */
              $selectAndDeleteParam="";
              
              for($colInd=0;$colInd<$columnSize;$colInd++)
              {
                 $series=$colInd+1;
                 $field=$column[$colInd]->{'Field'};
                 $type=$column[$colInd]->{'Type'};
                 $extra=$column[$colInd]->{'Extra'};
                 $key=$column[$colInd]->{'Key'};
                 
                 fwrite($indTableFile, " * \t COLUMN-".$series." \t: ".$field." (".$type.")  \n");
                 if($type=='int(11)') { 
                     $selectAndDeleteParam.=" \$key=='".$field."' ||";
                 }
                 
                 if($extra!='auto_increment')
                 {
                    /* Type */
                    if($type=='int(11)') { 
                        $insertvalues.="\".$".$field.".\",";  
                    }
                    else { 
                           $insertvalues.="'\".$".$field.".\"',"; 
                          
                         }
                  
                         $insertParam.=$field.",";
                         $inserfuncParam.="\$".$field.",";
               
                    
                 }
              }
             
              fwrite($indTableFile, " */   \n");
              
              $insertParam=chop($insertParam,",");
              $insertvalues=chop($insertvalues,",");
              $inserfuncParam=chop($inserfuncParam,",");
             
              
              
                fwrite($indTableFile, " { \n");
                fwrite($indTableFile, "   private \$logger;\n\n");
                fwrite($indTableFile, "   function __construct() { \n");
                fwrite($indTableFile, "\t  \$this->logger= Logger::getLogger(\"api.".$tableName.".php\"); \n");
                fwrite($indTableFile, "\t } \n");
                fwrite($indTableFile, " \n");
            
              
              
              $selectAndDeleteParam=chop($selectAndDeleteParam,"||");
              $logger->info("selectAndDeleteParam : ".$selectAndDeleteParam);
              $logger->info("selectAndDeleteParam Count : ".strlen($selectAndDeleteParam)."");
                // Select Query
                 fwrite($indTableFile, "   function get".$tableName."Data(\$inputArray, \$outputArray) \n");
                 fwrite($indTableFile, "\t /* */  \n");
                 fwrite($indTableFile, "\t { \n");
                 fwrite($indTableFile, "\t \$output='';\n");
                 fwrite($indTableFile, "\t \$input='';\n\n"); 
                 fwrite($indTableFile, "\t /* Setting up Output Array */\n");
                 fwrite($indTableFile, "\t if(\$outputArray!='*') { \n");
                 fwrite($indTableFile, "\t\t for(\$outputInd=0;\$outputInd<count(\$outputArray);\$outputInd++) { \n");
                 fwrite($indTableFile, "\t\t\t \$output.=\$outputArray[\$outputInd].\",\"; \n");
                 fwrite($indTableFile, "\t\t  } \n"); 
                 fwrite($indTableFile, "\t\t \$output=  chop(\$output, \",\"); \n");
                 fwrite($indTableFile, "\t } \n");
                 fwrite($indTableFile, "\t else { \n");
                 fwrite($indTableFile, "\t\t \$output=\$outputArray; \n");
                 fwrite($indTableFile, "\t } \n\n");
                 fwrite($indTableFile, "\t /* Setting up Input Array */ \n");
                 fwrite($indTableFile, "\t if(\$inputArray!='1') {");
                 fwrite($indTableFile, "\t\t while (list(\$key, \$val) = each(\$inputArray)) { \n");
                 
                 if(strlen($selectAndDeleteParam)>0)
                 {
                   fwrite($indTableFile, "\t\t\t if(".$selectAndDeleteParam.") { \n");
                   fwrite($indTableFile, "\t\t\t \$input.=\$key.\"=\".\$val.\",\"; \n");
                   fwrite($indTableFile, "\t\t\t } \n");
                   fwrite($indTableFile, "\t\t\t else { \n");
                 }
                 fwrite($indTableFile, "\t\t\t \$input.=\$key.\"='\".\$val.\"',\"; \n");
                  
                 if(strlen($selectAndDeleteParam)>0)
                 {
                   fwrite($indTableFile, "\t\t\t } \n");
                 }
                 
                 fwrite($indTableFile, "\t\t } \n");
                 fwrite($indTableFile, "\t\t \$input=  chop(\$input, \",\"); \n");
                 fwrite($indTableFile, "\t } \n");
                 fwrite($indTableFile, "\t else { \n");
                 fwrite($indTableFile, "\t\t \$input=\$inputArray; \n");
                 fwrite($indTableFile, "\t } \n\n");
                 fwrite($indTableFile, "\t \$selectQuery=\"SELECT \".\$outputArray.\" FROM ".$tableName." WHERE \".\$inputArray; \n");
                 fwrite($indTableFile, "\t \$this->logger->info(\"[func - get".$tableName."Data()] Query : \".\$selectQuery);\n");
                 fwrite($indTableFile, "\t \$dbObject=new Database(); \n");
                 fwrite($indTableFile, "\t \$jsonData=\$dbObject->getJSONData(\$selectQuery);\n\n");
                 fwrite($indTableFile, "\t  return \$jsonData; \n");
                 fwrite($indTableFile, "      } \n\n");
                 
                 
                 // Delete Query
                 fwrite($indTableFile, "\t function delete".$tableName."Data(\$inputArray) { \n\n");
                 fwrite($indTableFile, "\t\t  \$input=''; \n\n");
                 fwrite($indTableFile, "\t\t  /* Setting up Input Array */ \n");
                 fwrite($indTableFile, "\t\t\t   if(\$inputArray!='1') { \n");
                 fwrite($indTableFile, "\t\t\t\t  while (list(\$key, \$val) = each(\$inputArray)) { \n");
                  
                 if(strlen($selectAndDeleteParam)>0)
                 {
                   fwrite($indTableFile, "\t\t\t\t\t if(".$selectAndDeleteParam.") { \n");
                   fwrite($indTableFile, "\t\t\t\t\t\t \$input.=\$key.\"=\".\$val.\",\"; \n");
                   fwrite($indTableFile, "\t\t\t\t\t } \n");
                   fwrite($indTableFile, "\t\t\t\t\t else { \n");
                 }
                 
                 fwrite($indTableFile, "\t\t\t\t\t\t \$input.=\$key.\"='\".\$val.\"',\"; \n");
                 
                 if(strlen($selectAndDeleteParam)>0)
                 {
                   fwrite($indTableFile, "\t\t\t\t\t } \n");
                 }
                 
                 fwrite($indTableFile, "\t\t\t\t } \n\n");
                 fwrite($indTableFile, "\t\t\t\t \$input=  chop(\$input, \",\"); \n\n");
                 fwrite($indTableFile, "\t\t\t } \n");
                 fwrite($indTableFile, "\t\t\t else { \n");
                 fwrite($indTableFile, "\t\t\t\t \$input=\$inputArray; \n");
                 fwrite($indTableFile, "\t\t\t } \n\n");
                 fwrite($indTableFile, "\t\t  \$deleteQuery=\"DELETE FROM ".$tableName." WHERE \".\$input.\";\";\n");
                 fwrite($indTableFile, "\t\t \$this->logger->info(\"[func - delete".$tableName."Data()] Query : \".\$deleteQuery);\n\n");
                 fwrite($indTableFile, "\t\t \$dbObject=new Database(); \n");
                 fwrite($indTableFile, "\t\t \$dbObject->addupdateData(\$deleteQuery); \n\n");
                 fwrite($indTableFile, "\t } \n\n");
                 
                 
                 
                // Update Query
                 fwrite($indTableFile, "\t function update".$tableName."Data(\$setArray, \$conditionArray) { \n\n");
                 fwrite($indTableFile, "\t\t  \$set=''; \n\n");
                 fwrite($indTableFile, "\t\t  \$condition=''; \n\n");
                 fwrite($indTableFile, "\t\t  /* Setting up setArray */ \n");
                 fwrite($indTableFile, "\t\t\t   if(\$setArray!='1') { \n");
                 fwrite($indTableFile, "\t\t\t\t  while (list(\$key, \$val) = each(\$setArray)) { \n");
                 
                 if(strlen($selectAndDeleteParam)>0)
                 {
                    fwrite($indTableFile, "\t\t\t\t\t if(".$selectAndDeleteParam.") { \n");
                    fwrite($indTableFile, "\t\t\t\t\t\t \$set.=\$key.\"=\".\$val.\",\"; \n");
                    fwrite($indTableFile, "\t\t\t\t\t } \n");
                    fwrite($indTableFile, "\t\t\t\t\t else { \n");
                 }
                 
                 fwrite($indTableFile, "\t\t\t\t\t\t \$set.=\$key.\"='\".\$val.\"',\"; \n");
                 
                 if(strlen($selectAndDeleteParam)>0)
                 {
                    fwrite($indTableFile, "\t\t\t\t\t } \n");
                 }
                 
                 fwrite($indTableFile, "\t\t\t\t } \n");
                 fwrite($indTableFile, "\t\t\t\t \$set=  chop(\$set, \",\"); \n");
                 fwrite($indTableFile, "\t\t\t\t\t } \n");
                 fwrite($indTableFile, "\t\t\t\t\t else { \n");
                 fwrite($indTableFile, "\t\t\t\t\t\t \$set=\$setArray; \n");
                 fwrite($indTableFile, "\t\t\t\t\t } \n\n");
                 fwrite($indTableFile, "\t\t  /* Setting up conditionArray */ \n");
                 fwrite($indTableFile, "\t\t\t   if(\$conditionArray!='1') { \n");
                 fwrite($indTableFile, "\t\t\t\t  while (list(\$key, \$val) = each(\$conditionArray)) { \n");
                 
                 if(strlen($selectAndDeleteParam)>0)
                 {
                    fwrite($indTableFile, "\t\t\t\t\t if(".$selectAndDeleteParam.") { \n");
                    fwrite($indTableFile, "\t\t\t\t\t\t \$condition.=\$key.\"=\".\$val.\",\"; \n");
                    fwrite($indTableFile, "\t\t\t\t\t } \n");
                    fwrite($indTableFile, "\t\t\t\t\t else { \n");     
                 }
                 fwrite($indTableFile, "\t\t\t\t\t\t \$condition.=\$key.\"='\".\$val.\"',\"; \n");
                 
                 if(strlen($selectAndDeleteParam)>0)
                 {
                    fwrite($indTableFile, "\t\t\t\t\t } \n");
                 }
                 
                 fwrite($indTableFile, "\t\t\t\t } \n");
                 fwrite($indTableFile, "\t\t\t\t \$condition=  chop(\$condition, \",\"); \n");
                 fwrite($indTableFile, "\t\t\t\t\t } \n");
                 fwrite($indTableFile, "\t\t\t\t\t else { \n");
                 fwrite($indTableFile, "\t\t\t\t\t\t \$condition=\$conditionArray; \n");
                 fwrite($indTableFile, "\t\t\t\t\t } \n\n");
                 fwrite($indTableFile, "\t\t\t \$updateQuery=\"UPDATE ".$tableName." \"; \n");
                 fwrite($indTableFile, "\t\t\t \$updateQuery.=\"SET \".\$set; \n");
                 fwrite($indTableFile, "\t\t\t \$updateQuery.=\"WHERE \".\$condition; \n");
                 fwrite($indTableFile, "\t\t \$this->logger->info(\"[func - update".$tableName."Data()] Query : \".\$updateQuery);\n\n");
                 fwrite($indTableFile, "\t\t \$dbObject=new Database(); \n");
                 fwrite($indTableFile, "\t\t \$dbObject->addupdateData(\$updateQuery); \n\n");
                 fwrite($indTableFile, "\t } \n\n");
                 
                 
                 
                 
              // Insert
              fwrite($indTableFile, "\t function add".$tableName."Data(".$inserfuncParam.") { \n\n");
              fwrite($indTableFile, "\t\t \$insertQuery=\"INSERT INTO ".$tableName."(".$insertParam.") \";\n");
              fwrite($indTableFile, "\t\t \$insertQuery.=\"VALUES (".$insertvalues.");\"; \n\n");
              fwrite($indTableFile, "\t\t \$this->logger->info(\"[func - add".$tableName."Data()] Query : \".\$insertQuery);\n\n");
              fwrite($indTableFile, "\t\t \$dbObject=new Database(); \n");
              fwrite($indTableFile, "\t\t \$dbObject->addupdateData(\$insertQuery); \n\n");
              fwrite($indTableFile, "\t } \n");
              
            
              
              fwrite($indTableFile, " } ");
              fclose($indTableFile);
          }
          
          
           
    // Writing Foreign Key related Queries for Tables using $tableInfoJson 
         
          for($queInd=0;$queInd<count($tableInfodeJson);$queInd++)
          {
              $tableName=$tableInfodeJson[$queInd]->{'table'};
              $column=$tableInfodeJson[$queInd]->{'columns'};
              $columnSize=count($column);
              
              for($colInd=0;$colInd<$columnSize;$colInd++)
              {
                 $field=$column[$colInd]->{'Field'};
                 $type=$column[$colInd]->{'Type'};
                 $extra=$column[$colInd]->{'Extra'};
                 $key=$column[$colInd]->{'Key'};
                 
                  if($extra!='auto_increment')
                  {
                       if($key=='MUL')    // If KEY=MUL, Check Linked Foreign Keys
                        {
                           echo "<br/>"."<br/>"."Current Colums :: ".$field."<br/>";
                            $refcolQuery="select REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME ";
                            $refcolQuery.="from information_schema.KEY_COLUMN_USAGE where TABLE_NAME = '".$tableName."' AND COLUMN_NAME='".$field."'";

                            $refcolJson=$dbObject->getJSONData($refcolQuery);
                            $refcolDeJson=  json_decode($refcolJson);
                       
                            for($refcolInd=0;$refcolInd<count($refcolDeJson);$refcolInd++)
                            {
                              $refTableName=$refcolDeJson[$refcolInd]->{'REFERENCED_TABLE_NAME'};
                              $refColName=$refcolDeJson[$refcolInd]->{'REFERENCED_COLUMN_NAME'};
                              
                                    echo "Current Table Colums :: "."<br/>";
                                    
                                     // Create a Join Table File that related with Foreign Key
                                        $jointablefile = fopen("../../output/dal/data.".$tableName.$refTableName.".php", "w") or die("Unable to open file!");

                                        fwrite($jointablefile, "<?php  session_start(); \n");
                                        fwrite($jointablefile, "require 'api.database.php'; \n\n");
                                        fwrite($jointablefile, " class ".$tableName.$refTableName."  \n");
                              
                                        fwrite($jointablefile, "/* CLASS-DESCRIPTION :  This class generates basic CRUD queries for the foreign key related table '".$tableName."' and '".$refTableName."'\n");
                                        fwrite($jointablefile, " * TABLE-SCHEMA-INFORMATION     :   \n");
                                        fwrite($jointablefile, " * \t TABLE-NAME     : ".$tableName."  \n");
                                        
                                    
                                    $joinSelectParam="";
                                    // Current Table Columns
                                    for($curcolInd=0;$curcolInd<$columnSize;$curcolInd++)
                                    {
                                                    $curseries=$curcolInd+1;
                                                    $curfield=$column[$curcolInd]->{'Field'};
                                                    $curtype=$column[$curcolInd]->{'Type'};
                                                    $curextra=$column[$curcolInd]->{'Extra'};
                                                    $curkey=$column[$curcolInd]->{'Key'};
                                                    
                                                     fwrite($jointablefile, " * \t COLUMN-".$curseries." \t: ".$curfield." (".$curtype.")  \n");
                                                   // echo $curfield." :: ".$curtype." :: ".$curextra." :: ".$curkey."<br/>";
                                                    
                                            
                                                  /* Type */
                                                if($curtype=='int(11)') { 
                                                           $joinSelectParam.=" \$key=='".$tableName.".".$curfield."' ||";
                                                }
                                                else { 

                                                     }
                                            
                                                    
                                    }
                                    
                                     fwrite($jointablefile, " * \t TABLE-NAME     : ".$refTableName."  \n");
                                     echo "Reference Table Colums :: "."<br/>";
                                    // Reference Table 
                                    for($refTabInd=0;$refTabInd<count($tableInfodeJson);$refTabInd++)
                                    {
                                        $referenceTable=$tableInfodeJson[$refTabInd]->{'table'};
                                        if($refTableName==$referenceTable)
                                        {
                                            $refTablecolumn=$tableInfodeJson[$refTabInd]->{'columns'};
                                            $refcolumnSize=count($refTablecolumn);
                                            
                                                for($refcolInd=0;$refcolInd<$refcolumnSize;$refcolInd++)
                                                {
                                                    $refSeries=$refcolInd+1;
                                                    $reffield=$refTablecolumn[$refcolInd]->{'Field'};
                                                    $reftype=$refTablecolumn[$refcolInd]->{'Type'};
                                                    $refextra=$refTablecolumn[$refcolInd]->{'Extra'};
                                                    $refkey=$refTablecolumn[$refcolInd]->{'Key'};
                                                    
                                                     fwrite($jointablefile, " * \t COLUMN-".$refSeries." \t: ".$reffield." (".$reftype.")  \n");
                                                 //   echo $reffield." :: ".$reftype." :: ".$refextra." :: ".$refkey."<br/>";
                                                    
                                                     
                                                             /* Type */
                                                            if($reftype=='int(11)') { 
                                                                    $joinSelectParam.=" \$key=='".$referenceTable.".".$reffield."' ||";
                                                            }
                                                            else { 

                                                                 }
                                                         
                                                         
                                                     
                                                    
                                                }
                                            
                                        }
                                    }
                                    
                                    fwrite($jointablefile, " */   \n");
                                    fwrite($jointablefile, " { \n");
                                    
                                     $joinSelectParam=chop($joinSelectParam, "||");
                                   
                                   // Join Select Query
                                        fwrite($jointablefile, "   function get".$tableName.$refTableName."Data(\$inputArray, \$outputArray) { \n\n");
                                        fwrite($jointablefile, "\t \$output='';\n");
                                        fwrite($jointablefile, "\t \$input='';\n\n"); 
                                        fwrite($jointablefile, "\t /* Setting up Output Array */\n");
                                        fwrite($jointablefile, "\t if(\$outputArray!='*') { \n");
                                        fwrite($jointablefile, "\t\t for(\$outputInd=0;\$outputInd<count(\$outputArray);\$outputInd++) { \n");
                                        fwrite($jointablefile, "\t\t\t \$output.=\$outputArray[\$outputInd].\",\"; \n");
                                        fwrite($jointablefile, "\t\t  } \n"); 
                                        fwrite($jointablefile, "\t\t \$output=  chop(\$output, \",\"); \n");
                                        fwrite($jointablefile, "\t } \n");
                                        fwrite($jointablefile, "\t else { \n");
                                        fwrite($jointablefile, "\t\t \$output=\$outputArray; \n");
                                        fwrite($jointablefile, "\t } \n\n");
                                        fwrite($jointablefile, "\t /* Setting up Input Array */ \n");
                                        fwrite($jointablefile, "\t if(\$inputArray!='1') {\n");
                                        fwrite($jointablefile, "\t\t while (list(\$key, \$val) = each(\$inputArray)) { \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                                fwrite($jointablefile, "\t\t\t if(".$joinSelectParam.") { \n");
                                                fwrite($jointablefile, "\t\t\t \$input.=\$key.\"=\".\$val.\",\"; \n");
                                                fwrite($jointablefile, "\t\t\t } \n");
                                                fwrite($jointablefile, "\t\t\t else { \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t \$input.=\$key.\"='\".\$val.\"',\"; \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                            fwrite($jointablefile, "\t\t\t } \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t } \n");
                                        fwrite($jointablefile, "\t\t \$input=  chop(\$input, \",\"); \n");
                                        fwrite($jointablefile, "\t } \n");
                                        fwrite($jointablefile, "\t else { \n");
                                        fwrite($jointablefile, "\t\t \$input=\$inputArray; \n");
                                        fwrite($jointablefile, "\t } \n\n");
                                        fwrite($jointablefile, "\t \$selectQuery=\"SELECT \".\$outputArray.\" FROM ".$tableName.",".$refTableName." WHERE \".\$inputArray; \n");
                                        fwrite($jointablefile, "\t \$this->logger->info(\"[func - get".$tableName.$refTableName."Data()] Query : \".\$selectQuery);\n");
                                        fwrite($jointablefile, "\t \$dbObject=new Database(); \n");
                                        fwrite($jointablefile, "\t \$jsonData=\$dbObject->getJSONData(\$selectQuery);\n\n");
                                        fwrite($jointablefile, "\t  return \$jsonData; \n");
                                        fwrite($jointablefile, "      } \n\n");
                 
                                     
                                     
                                  // Join Update Query 
                                        fwrite($jointablefile, "\t function update".$tableName.$refTableName."Data(\$setArray, \$conditionArray) { \n\n");
                                        fwrite($jointablefile, "\t\t  \$set=''; \n\n");
                                        fwrite($jointablefile, "\t\t  \$condition=''; \n\n");
                                        fwrite($jointablefile, "\t\t  /* Setting up setArray */ \n");
                                        fwrite($jointablefile, "\t\t\t   if(\$setArray!='1') { \n");
                                        fwrite($jointablefile, "\t\t\t\t  while (list(\$key, \$val) = each(\$setArray)) { \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                            fwrite($jointablefile, "\t\t\t\t\t if(".$joinSelectParam.") { \n");
                                            fwrite($jointablefile, "\t\t\t\t\t\t \$set.=\$key.\"=\".\$val.\",\"; \n");
                                            fwrite($jointablefile, "\t\t\t\t\t } \n");
                                            fwrite($jointablefile, "\t\t\t\t\t else { \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t\t\t\t \$set.=\$key.\"='\".\$val.\"',\"; \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                          fwrite($jointablefile, "\t\t\t\t\t } \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t\t } \n");
                                        fwrite($jointablefile, "\t\t\t\t \$set=  chop(\$set, \",\"); \n");
                                        fwrite($jointablefile, "\t\t\t\t\t } \n");
                                        fwrite($jointablefile, "\t\t\t\t\t else { \n");
                                        fwrite($jointablefile, "\t\t\t\t\t\t \$set=\$setArray; \n");
                                        fwrite($jointablefile, "\t\t\t\t\t } \n\n");
                                        fwrite($jointablefile, "\t\t  /* Setting up conditionArray */ \n");
                                        fwrite($jointablefile, "\t\t\t   if(\$conditionArray!='1') { \n");
                                        fwrite($jointablefile, "\t\t\t\t  while (list(\$key, \$val) = each(\$conditionArray)) { \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                            fwrite($jointablefile, "\t\t\t\t\t if(".$joinSelectParam.") { \n");
                                            fwrite($jointablefile, "\t\t\t\t\t\t \$condition.=\$key.\"=\".\$val.\",\"; \n");
                                            fwrite($jointablefile, "\t\t\t\t\t } \n");
                                            fwrite($jointablefile, "\t\t\t\t\t else { \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t\t\t\t \$condition.=\$key.\"='\".\$val.\"',\"; \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                            fwrite($jointablefile, "\t\t\t\t\t } \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t\t } \n");
                                        fwrite($jointablefile, "\t\t\t\t \$condition=  chop(\$condition, \",\"); \n");
                                        fwrite($jointablefile, "\t\t\t\t\t } \n");
                                        fwrite($jointablefile, "\t\t\t\t\t else { \n");
                                        fwrite($jointablefile, "\t\t\t\t\t\t \$condition=\$conditionArray; \n");
                                        fwrite($jointablefile, "\t\t\t\t\t } \n\n");
                                        fwrite($jointablefile, "\t\t\t \$updateQuery=\"UPDATE ".$tableName.", ".$refTableName." \"; \n");
                                        fwrite($jointablefile, "\t\t\t \$updateQuery.=\"SET \".\$set; \n");
                                        fwrite($jointablefile, "\t\t\t \$updateQuery.=\"WHERE \".\$condition; \n");
                                        fwrite($jointablefile, "\t\t \$this->logger->info(\"[func - update".$tableName.$refTableName."Data()] Query : \".\$updateQuery);\n\n");
                                        fwrite($jointablefile, "\t\t \$dbObject=new Database(); \n");
                                        fwrite($jointablefile, "\t\t \$dbObject->addupdateData(\$updateQuery); \n\n");
                                        fwrite($jointablefile, "\t } \n\n");
                 
                 
                                    
                                // Delete Query
                                        fwrite($jointablefile, "\t function delete".$tableName.$refTableName."Data(\$inputArray) { \n\n");
                                        fwrite($jointablefile, "\t\t  \$input=''; \n\n");
                                        fwrite($jointablefile, "\t\t  /* Setting up Input Array */ \n");
                                        fwrite($jointablefile, "\t\t\t   if(\$inputArray!='1') { \n");
                                        fwrite($jointablefile, "\t\t\t\t  while (list(\$key, \$val) = each(\$inputArray)) { \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                            fwrite($jointablefile, "\t\t\t\t\t if(".$joinSelectParam.") { \n");
                                            fwrite($jointablefile, "\t\t\t\t\t\t \$input.=\$key.\"=\".\$val.\",\"; \n");
                                            fwrite($jointablefile, "\t\t\t\t\t } \n");
                                            fwrite($jointablefile, "\t\t\t\t\t else { \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t\t\t\t \$input.=\$key.\"='\".\$val.\"',\"; \n");
                                        
                                        if(strlen($joinSelectParam)>0)
                                        {
                                           fwrite($jointablefile, "\t\t\t\t\t } \n");
                                        }
                                        
                                        fwrite($jointablefile, "\t\t\t\t } \n\n");
                                        fwrite($jointablefile, "\t\t\t\t \$input=  chop(\$input, \",\"); \n\n");
                                        fwrite($jointablefile, "\t\t\t } \n");
                                        fwrite($jointablefile, "\t\t\t else { \n");
                                        fwrite($jointablefile, "\t\t\t\t \$input=\$inputArray; \n");
                                        fwrite($jointablefile, "\t\t\t } \n\n");
                                        fwrite($jointablefile, "\t\t  \$deleteQuery=\"DELETE FROM ".$tableName.",".$refTableName." WHERE \".\$input.\";\";\n");
                                        fwrite($jointablefile, "\t\t \$this->logger->info(\"[func - delete".$tableName.$refTableName."Data()] Query : \".\$deleteQuery);\n\n");
                                        fwrite($jointablefile, "\t\t \$dbObject=new Database(); \n");
                                        fwrite($jointablefile, "\t\t \$dbObject->addupdateData(\$deleteQuery); \n\n");
                                        fwrite($jointablefile, "\t } \n\n");
                 
                 
                                        
                                        fwrite($jointablefile, " } \n");
                                        fclose($jointablefile);
                            }
                        }
                  }
              }
          }
    
 
   // Packing all output files into ZIP Archive
      
          
          
   
         
}
else {       
// Redirecting back to index.php
 // header("location:../../index.php");
}