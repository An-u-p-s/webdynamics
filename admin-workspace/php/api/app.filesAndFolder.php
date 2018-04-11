<?php
class FileManagement {
	function readAFile($fileName){
		$readTxt='';
		$myfile = fopen($fileName, "r") or die("Unable to open file!");
		while(!feof($myfile)) { $readTxt.=fgets($myfile); }
		fclose($myfile);
	return $readTxt;
	}

	function writeAFile($fileName, $writeTxt) {
		$myfile = fopen($fileName, "w") or die("Unable to open file!");
		fwrite($myfile, $writeTxt);
		fclose($myfile);
	return $writeTxt;
	}

	function appendAFile($fileName, $appendTxt) {
		$appndTxt=readAFile($fileName);
		$appndTxt.=$appendTxt;
		writeAFile($fileName, $appndTxt);
	return $appndTxt;
	}

	function makeFileempty($fileName){
		$myfile = fopen($fileName, "w") or die("Unable to open file!");
		fwrite($myfile, "");
		fclose($myfile);
	}
	
	function deleteAFile($fileName){
		unlink($fileName);
	}
	
	function checkFileExistOrNot($fileName) {
		$status='NotExist';
		if(file_exists($fileName)==1) {
			$status='Exist';
		}
	return $status;
	}
	
	function reNameAFile($old_fileName, $new_fileName){
		rename($old_fileName, $new_fileName);
	}
	
	function moveAFile($from_path,$to_path){
		copy($from_path, $to_path);
	}
}

class DirectoryManagement {
	function createAFolder($folderName){
		$status;
		if(!is_dir($folderName)) {
			if(mkdir($folderName)) { $status='Folder_Created'; }
		} else {
			$status='Already_Folder_Exists';
		}
	   return $status;
	}
	function reNameAFolder($old_folderName, $new_folderName){
		$status="No_Folder_Renamed";
		
		if(is_dir($old_folderName)){
			if(is_dir($new_folderName)) {
				$status="Already_Folder_With_New_Name_Exist";
			}
			else {
				if(rename($old_folderName, $new_folderName)==1) {
					$status="Folder_Renamed";
				} 
			} 
		}
		else {
			$status='No_Folder_Exist';
		}
	return $status;
	}
	function moveAFolder($from_folder, $to_folder){
		
		if(is_dir($from_folder)){
			mkdir($to_folder);
			/* Get the List of Files and Copy to the Folder*/
			listFolderFiles($from_folder, $to_folder);
		}
	}
	
	function listFolderFiles($from_folder, $to_folder){
		$ffs = scandir($from_folder);
		foreach($ffs as $ff){
         if($ff != '.' && $ff != '..'){
				if(is_dir($from_folder.'/'.$ff)) {  /* Folder */mkdir($to_folder.'/'.$ff);listFolderFiles($from_folder.'/'.$ff, $to_folder.'/'.$ff); }
				else { /* File */ copy($from_folder.'/'.$ff, $to_folder.'/'.$ff); }
			}
			
		}
			
			
	}
	
	function deleteFolder($folderName){
		$status="No_Folder_Deleted";
		if(rmdir($folderName)==1){
			$status="Folder_Deleted";
		}
	   return $status;
	}
	function checkFolderExistOrNot($folderName){
		$status;
		if(!is_dir($folderName)) {
			$status='No_Folder_Exist';
		} else {
			$status='Folder_Exist';
		}
		return $status;
	}

}
$fs=new FileManagement();

$fldr=new DirectoryManagement();
 echo $fldr->createAFolder("MainFolder")."<br/>";
// echo $fldr->reNameAFolder("MainFolder","Sunny");
// echo $fldr->deleteFolder("Sunny");
$fldr->moveAFolder("MainFolder","Sunny");
?>