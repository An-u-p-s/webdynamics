<?php session_start(); 
require_once '../api/app.database.php'; 
class mw_accounts  
/* CLASS-DESCRIPTION :  This class generates basic CRUD queries for the individual table 'mw_accounts' 
 * TABLE-SCHEMA-INFORMATION     :   
 * 	 TABLE-NAME     : mw_accounts  
 * 	 COLUMN-1 	: mw_Id (varchar(25))  
 * 	 COLUMN-2 	: app_Id (varchar(25))  
 * 	 COLUMN-3 	: secretKey (varchar(55))  
 * 	 COLUMN-4 	: access (bit(1))  
 */   
 { 
   private $logger;

   function __construct() { 
	  $this->logger= Logger::getLogger("api.mw_accounts.php"); 
	 } 
 
   function getmw_accountsData($inputArray, $outputArray) 
	 /* */  
	 { 
	 $output='';
	 $input='';

	 /* Setting up Output Array */
	 if($outputArray!='*') { 
		 for($outputInd=0;$outputInd<count($outputArray);$outputInd++) { 
			 $output.=$outputArray[$outputInd].","; 
		  } 
		 $output=  chop($output, ","); 
	 } 
	 else { 
		 $output=$outputArray; 
	 } 

	 /* Setting up Input Array */ 
	 if($inputArray!='1') {		 while (list($key, $val) = each($inputArray)) { 
			 $input.=$key."='".$val."',"; 
		 } 
		 $input=  chop($input, ","); 
	 } 
	 else { 
		 $input=$inputArray; 
	 } 

	 $selectQuery="SELECT ".$outputArray." FROM mw_accounts WHERE ".$inputArray; 
	 $this->logger->info("[func - getmw_accountsData()] Query : ".$selectQuery);
	 $dbObject=new Database(); 
	 $jsonData=$dbObject->getJSONData($selectQuery);

	  return $jsonData; 
      } 

	 function deletemw_accountsData($inputArray) { 

		  $input=''; 

		  /* Setting up Input Array */ 
			   if($inputArray!='1') { 
				  while (list($key, $val) = each($inputArray)) { 
						 $input.=$key."='".$val."',"; 
				 } 

				 $input=  chop($input, ","); 

			 } 
			 else { 
				 $input=$inputArray; 
			 } 

		  $deleteQuery="DELETE FROM mw_accounts WHERE ".$input.";";
		 $this->logger->info("[func - deletemw_accountsData()] Query : ".$deleteQuery);

		 $dbObject=new Database(); 
		 $dbObject->addupdateData($deleteQuery); 

	 } 

	 function updatemw_accountsData($setArray, $conditionArray) { 

		  $set=''; 

		  $condition=''; 

		  /* Setting up setArray */ 
			   if($setArray!='1') { 
				  while (list($key, $val) = each($setArray)) { 
						 $set.=$key."='".$val."',"; 
				 } 
				 $set=  chop($set, ","); 
					 } 
					 else { 
						 $set=$setArray; 
					 } 

		  /* Setting up conditionArray */ 
			   if($conditionArray!='1') { 
				  while (list($key, $val) = each($conditionArray)) { 
						 $condition.=$key."='".$val."',"; 
				 } 
				 $condition=  chop($condition, ","); 
					 } 
					 else { 
						 $condition=$conditionArray; 
					 } 

			 $updateQuery="UPDATE mw_accounts "; 
			 $updateQuery.="SET ".$set; 
			 $updateQuery.="WHERE ".$condition; 
		 $this->logger->info("[func - updatemw_accountsData()] Query : ".$updateQuery);

		 $dbObject=new Database(); 
		 $dbObject->addupdateData($updateQuery); 

	 } 

	 function addmw_accountsData($mw_Id,$app_Id,$secretKey,$access) { 

		 $insertQuery="INSERT INTO mw_accounts(mw_Id,app_Id,secretKey,access) ";
		 $insertQuery.="VALUES ('".$mw_Id."','".$app_Id."','".$secretKey."','".$access."');"; 

		 $this->logger->info("[func - addmw_accountsData()] Query : ".$insertQuery);

		 $dbObject=new Database(); 
		 $dbObject->addupdateData($insertQuery); 

	 } 
 } 