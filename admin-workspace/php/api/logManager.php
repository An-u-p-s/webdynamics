<?php
  
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$GLOBAL_PROJECT_PATH=$_SERVER['DOCUMENT_ROOT'].'/';          // $project_path = C:/wamp/www/
$GLOBAL_PROJECT_NAME="WebDynamics-AW/";                         // $projectName = DALEngine
$GLOBAL_LOGGER_FILEPATH="log4php/Logger.php";
$GLOBAL_LOGGER_CONFIGPATH="conf/config.xml";

date_default_timezone_set("Asia/Kolkata"); /* Set Timezone */

/* ============================================================================
 *  LOGMANAGER CLASS
 * ============================================================================
 *  PURPOSE: It used for logging logs that are written in PHP Language.
 *  LOGGING LEVELS: TRACE < DEBUG < INFO < WARN < ERROR < FATAL
 */
class logManager {
    private $logger;
    function __construct() {
        global $GLOBAL_LOGGER_FILEPATH, $GLOBAL_LOGGER_CONFIGPATH;
        include_once($GLOBAL_LOGGER_FILEPATH);
        Logger::configure($GLOBAL_LOGGER_CONFIGPATH);
    }
    function lineNumberFormat($number){
       $num='';
       if(strlen((String)$number)<4) {
            for($index=0;$index<4-strlen((String)$number);$index++){ $num.='0'; }
        }
      return $num.(String)$number;
    }
    function phploggerWarn($line, $fileName, $msg) {
        $lm=new logManager();
        $this->logger=Logger::getLogger("PHP(Line-".$lm->lineNumberFormat($line)."): ".$fileName);
        $this->logger->warn($msg);
    }     
    function phploggerTrace($line, $fileName, $msg) {
        $this->logger=Logger::getLogger("PHP(Line-".$lm->lineNumberFormat($line)."): ".$fileName);
        $this->logger->trace($msg);
    }  
    function phploggerInfo($line, $fileName, $msg) {
        $this->logger=Logger::getLogger("PHP(Line-".$lm->lineNumberFormat($line)."): ".$fileName);
        $this->logger->info($msg);
    }
    function phploggerDebug($line, $fileName, $msg) {
        $this->logger=Logger::getLogger("PHP(Line-".$lm->lineNumberFormat($line)."): ".$fileName);
        $this->logger->debug($msg);
    }
    function phploggerFatal($line, $fileName, $msg) {
        $this->logger=Logger::getLogger("PHP(Line-".$lm->lineNumberFormat($line)."): ".$fileName);
        $this->logger->fatal($msg);
    }
    function phploggerError($line, $fileName, $msg) {
        $this->logger=Logger::getLogger("PHP(Line-".$lm->lineNumberFormat($line)."): ".$fileName);
        $this->logger->error($msg);
    }
}
/* ===================================================================================
 *  JAVASCRIPT LOGGING
 * ===================================================================================
 * PURPOSE: It used for logging logs that are written in Javascript Language.
 * LOGGING LEVELS: TRACE < DEBUG < INFO < WARN < ERROR < FATAL
 * INPUTS: Working_FileName, Working_LoggerType, Working_LoggerMessage
 */
if(isset($_GET["action"]) && $_GET["action"]=='Logger'){
  
  $logger_invoker=$GLOBAL_PROJECT_PATH.$GLOBAL_PROJECT_NAME.$GLOBAL_LOGGER_FILEPATH;
  $logger_config=$GLOBAL_PROJECT_PATH.$GLOBAL_PROJECT_NAME.$GLOBAL_LOGGER_CONFIGPATH;

  include_once($logger_invoker);
  Logger::configure($logger_config);

  $fileName=$_GET["Working_FileName"];
  $logger_type=$_GET["Working_LoggerType"];
  $msg=$_GET["Working_LoggerMessage"];
  $lang="JAVASCRIPT";
  $line=$_GET["Working_Line"];
  
  $logger=Logger::getLogger("JAVASCRIPT(Line-".$line."): ".$fileName);
    if($logger_type=='WARN')  {   $logger->warn($msg);   }
    if($logger_type=='TRACE') {   $logger->trace($msg);  }
    if($logger_type=='INFO')  {   $logger->info($msg); }
    if($logger_type=='DEBUG') {   $logger->debug($msg);  }
    if($logger_type=='FATAL') {   $logger->fatal($msg);  }
    if($logger_type=='ERROR') {   $logger->error($msg);  } 
    
  
  }

?>


