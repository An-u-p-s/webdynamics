<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Utils
{
    function randomNumber($size)
    {
        $num="";
        for($index=0;$index<$size;$index++) {
            $num.=rand(1,9);
        }
        return $num;
    }
    
    function create_zip($files = array(),$destination = '',$overwrite = false) 
    /* FUNCTION DESCRIPTION : Creates a compressed zip file 
     * FUNCTION USAGE :  $files_to_zip = array('output/1.jpg','output/2.jpg','output/3.jpg', ... );
     *                   $result = create_zip($files_to_zip,'my-archive.zip'); //if true, good; if false, zip creation failed
     */
    {
	if(file_exists($destination) && !$overwrite) { return false; } //if the zip file already exists and overwrite is false, return false

	$valid_files = array();
	
	if(is_array($files))  //if files were passed in...
        {
		
		foreach($files as $file) //cycle through each file
                {
			
			if(file_exists($file)) //make sure the file exists
                        {
				$valid_files[] = $file;
			}
		}
	}
	
	if(count($valid_files)) //if we have good files...
            {
		$zip = new ZipArchive(); //create the archive
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) 
                {
	           return false;
		}
		
		foreach($valid_files as $file) //add the files
                {
			$zip->addFile($file,$file);
		}
		
		$zip->close();
		
		return file_exists($destination); //check to make sure the file exists
	   }
	 else
	  {
		return false;
	  }
    }

}