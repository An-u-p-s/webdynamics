<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<ul class="list-group">
   <li align="center" class="list-group-item active"><b>PROJECTS</b></li>
</ul>
     
<?php 
    function listFolderFiles($dir, $content, $folderType){
      $ffs = scandir($dir);
      $content.='<ul>';
      foreach($ffs as $ff){
         if($ff != '.' && $ff != '..'){
            if(is_dir($dir.'/'.$ff)) { 
					
					if($folderType==='Folder') {
                                         /*  if(isset($GLOBAL_APPLIST)) {
                                               $GLOBAL_APPLIST[count($GLOBAL_APPLIST)]=$ff; 
                                              
                                               
                                           } */
					   $content.='<li data-jstree=\'{"icon":"glyphicon glyphicon-briefcase"}\'>'.$ff;
                                           $content=listFolderFiles($dir.'/'.$ff, $content,'SubFolder');
					   $content.='</li>';	
					   
					} else {
						
					   $content.='<li data-jstree=\'{"icon":"glyphicon glyphicon-folder-open"}\'>'.$ff;
					   $content=listFolderFiles($dir.'/'.$ff, $content,'SubFolder');
					   $content.='</li>';	
					
					}

			   
             } else {
               $content.='<li data-jstree=\'{"icon":"glyphicon glyphicon-file"}\'>'.$ff.'</li>';
             }
         }
      }
      $content.='</ul>';
      return $content;
    }
?>
<div id="left_viewListOfProject">
<?php

    $content='<div id="jstree">';
	 if(isset($GLOBAL_USERID)) {
             
		$content=listFolderFiles('users/'.$GLOBAL_USERID,$content,'Folder');
	 }
	 else  {
		$content=listFolderFiles('../../users/'.$_GET["userId"],$content,'Folder');
	 }
    $content.='</div>';

    echo $content;

 ?>
</div>


                   
                    