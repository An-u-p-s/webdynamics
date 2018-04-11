<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<!DOCTYPE html>
<html>
  <head>
      <?php  
session_start();
require_once  'php/api/logManager.php';
$log=new logManager();

/* CONSTANT VARIABLES */
$GLOBAL_APPSPATH="users/";
$GLOBAL_USERID='USER12345'; //Should Be Renamed as global_userId (Standardization)
$GLOBAL_APPLIST=array();

$log->phploggerWarn(12, 'WorkSpace.php', 'GLOBAL_USER_ID: '.$GLOBAL_USERID);

 ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebDynamics</title>
    <script src="js-api-jquery"></script>
    <script src="js-api-bootstrap"></script>
    <script type="text/javascript" src="js/api/jslogger.js"></script>
	<style>
		#wrapper { visibility: hidden; }
	</style>
    <!-- JAVASCRIPT GLOBAL VARIABLES -->
	<script type="text/javascript">
		document.onreadystatechange = function () {
			  var state = document.readyState
			 /* if (state == 'interactive') {
				   document.getElementById('wrapper').style.visibility="hidden";
			  } else  */
			  if (state == 'complete') {
				  setTimeout(function(){
					// document.getElementById('interactive');
					 document.getElementById('load').style.display='none';
					 document.getElementById('wrapper').style.visibility="visible";
				  },5000);
			  } else {
			    document.getElementById('load').style.visibility="visible";
			  }
		};
	</script>
    <script type="text/javascript">
        var global_userId='<?php echo $GLOBAL_USERID; ?>';  // Should Be Renamed as global_userId (Standardization)
        var proj_struct;            // Used in project_structure.js   ::: Contains the list of Projects and list of its Children with their Ids.
        var openedFilesList={};     //  Used in file_tabs.js  ::: Contains List of Opened Files in the Project
        var currentViewingFile={};  //  Used in file_tabs.js ::: Contains Information of Current Viewing File of the Project 
    </script>
    <script src="js/api/jstree.min.js"></script>
    <script type="text/javascript" src="js/pages/workspace/project_structure.js"></script>
    <script type="text/javascript" src="js/pages/workspace/file_tabs.js"></script>
    <script type="text/javascript" src="js/pages/workspace/workspace_loader.js"></script>
    <link rel="stylesheet" href="styles-api-bootstrap">
    <link rel="stylesheet" href="styles/api/simple-sidebar.css">
    <link rel="stylesheet" href="styles/api/jstree.css" />
    <link rel="stylesheet" href="styles/api/font-awesome.min.css">
    <style>
	 a,a:hover,a:focus { color:#000; }
	   .btn-black,.btn-black:focus { color: #fff;background-color: #000;border-color: #000; }
	   .btn-black:hover { color: #000;background-color: #fff;border-color: #000; }
	   body { overflow-y:hidden; }
	  .crsor_pointer { cursor:pointer; }
	  .crsor_grab { cursor:grab; }
           hr { width:100%; }  
	  #projFile_menu { margin:0.1%; }	
	  #projFile_content { display:none; }
    </style>
  </head>
  <body>
  <div id="load">
	<img style="margin-left:50%;margin-top:20%;width:150px;height:100px;" src="images/wd.gif"/>
  </div>
      <!--  -->
  <!-- onload="alert(window.innerHeight);" -->
  <!-- oncontextmenu="return false;" -->
    <div id="wrapper">
      <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div id="left_viewProjectList"> 
	       <?php include_once 'templates/workspace/listOfProjects.php'; ?>
	    </div>
	 </div>
        <!-- /#sidebar-wrapper -->
         <!-- Page Content -->
         <div id="page-content-wrapper">
            <div class="container-fluid">
                <!-- Header -->
                <?php include_once 'templates/default-header.php'; ?>
                    
                <!-- Top menu::: Start -->
                <?php include_once 'templates/workspace/top-menu.php'; ?>
                <!-- Top menu::: End -->
                  
                <?php include_once 'templates/workspace/rightClicks.php';?>
               
                <?php ?>
				<!-- Files Listing -->
				<div id="projFile_menu"></div>
				
				<!-- File ContentViewing -->
				<div id="projFile_content">
				    <?php include_once 'templates/workspace/projArch.php';?>
				</div>
				
				<!-- Database -->
				<div>
					<style>
					  .dbarch-heading { height:40px;background-color:#000; }
					  .dbarch-head { color:#fff;font-weight:bold;margin-top:0.72%;margin-left:1%; }
					</style>
					<div class="container-fluid">
						<!-- Heading -->
						<div class="col-md-12 dbarch-heading">
							<div class="dbarch-head">DATABASE ARCHITECTURE</div>
						</div>
						
						
						<div class="col-md-12">
							<!-- Left Menu :: Design, Test, Live Environment -->
							<div class="col-md-2">
								<ul class="list-group" style="margin-top:3.2%;">
									<li align="center" class="list-group-item"><b>ENVIRONMENT</b></li>
								</ul>
								<ul class="nav nav-pills nav-stacked">
									<li class="active"><a href="#">Design</a></li>
									<li><a href="#">Test</a></li>
									<li><a href="#">Live</a></li>
								</ul>
								<ul class="list-group" style="margin-top:3.2%;">
									<li class="list-group-item"><b>Note:</b></li>
								</ul>
							</div>
							<div class="col-md-9">
								<!-- Create Design Instance-->
								<div class="col-md-4" style="margin-left:1%;">
									<div class="list-group" style="margin-top:1.9%;">
										<a align="center" class="list-group-item"><b>Create New Database</b></a>
									</div>
									
									<div class="col-md-12" style="margin-top:2%;">
                                                                                <div class="col-md-12">
											<select class="form-control">
                                                                                            <option>Select your WebServer</option>
                                                                                            <option option="ws01"></option>
                                                                                        </select>
										</div>
										<div class="col-md-12" style="margin-top:2%;">
											<select class="form-control">
                                                                                            <option>Select your Design Instance</option>
                                                                                            <option option="d01"></option>
                                                                                        </select>
										</div>
                                                                                
                                                                                <div class="col-md-12"  style="margin-top:2%;">
                                                                                   <div class = "input-group">
                                                                                        <input type = "text" class = "form-control" placeholder="databaseName">
                                                                                        <span class = "input-group-addon">_d01</span>
                                                                                   </div>
                                                                                    
                                                                                </div>
                                                                            
                                                                            
                                                                            <div class="col-md-12"  style="margin-top:2%;">
                                                                                <button class="form-control btn btn-primary"><b>Create New Database</b></button>
                                                                            </div>
									</div>
								</div>
                                                                
                                                                <div class="col-md-4" style="margin-left:1%;">
                                                                        <div class="list-group" style="margin-top:1.9%;">
										<a align="center" class="list-group-item">
                                                                                    <b>Import Database Schema from Live</b>
                                                                                </a>
									</div>
                                                                </div>
                                                                
                                                                
							</div>
						
						
					</div>
				</div>
				
            </div>
           </div>
		   
		</div>
        <!-- /#page-content-wrapper -->

    </div>
	
    <!-- /#wrapper -->
  </body>
</html>
