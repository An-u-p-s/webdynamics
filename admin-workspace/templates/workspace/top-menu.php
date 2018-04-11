<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<style>

.rowh {margin-top:1%; }
/* Tag CSS */     
.tags { list-style: none;margin: 0;overflow: hidden; padding: 0;}
.tags li { float: left; }
.tag { background: #e91e63;border-radius: 3px 0 0 3px;color: #fff;display: inline-block;height: 26px;line-height: 26px;padding: 0 20px 0 23px;
       position: relative;margin: 0 10px 10px 0;text-decoration: none;-webkit-transition: color 0.2s; }
.tag::before { background: #fff;border-radius: 10px;box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);content: '';height: 6px;left: 10px;position: absolute;
               width: 6px;top: 10px; }
.tag::after { background: #fff;border-bottom: 13px solid transparent;border-left: 10px solid #e91e63;border-top: 13px solid transparent;content: '';
              position: absolute;right: 0;top: 0; }
.tag:hover { background-color: crimson;color: white;text-decoration: none; }
.tag:hover::after { border-left-color: crimson; }
</style>
<script type="text/javascript">
   function viewProjects() {
     document.getElementById("file_viewProj").innerHTML='<a href="#" onclick="hideProjects()">Hide Projects</a>';
     $("#wrapper").removeClass("toggled"); // View Projects
   }
   function hideProjects(){
     document.getElementById("file_viewProj").innerHTML='<a href="#" onclick="viewProjects()">View Projects</a>';
     $("#wrapper").addClass("toggled"); // Hide Projects
   }
  
  function getproj_lang() {
	var lang='';
	check_PHP=document.getElementById("newproj_lang_PHP").checked;
	check_Java=document.getElementById("newproj_lang_Java").checked;
	if(check_PHP) {  lang+='PHP,'; }
	if(check_Java) {  lang+='Java,'; }
	var temp='';
	for(var index=0;index<lang.length-1;index++) {
		temp+=lang[index];
	}
	 lang=temp;
	return lang;
   }
    
   function createProject(){
     // global variable userId
	  var newproj_Name=document.getElementById("newproj_Name").value;
	  var newproj_lang=getproj_lang();
	  console.log("global_userId: "+global_userId);
	  console.log("proj_Name: "+newproj_Name);
	  console.log("proj_lang: "+newproj_lang);
      var content='';
       $.ajax({url: "php/dac/controller.createProject.php", type:'GET', async : false,
	   data:{ action: 'createProject', userId: global_userId, projName:newproj_Name, projLang:newproj_lang },
	   success: function(resp){ content=resp.trim(); } });
	  /* Reloading Projects */
	  $.get("templates/workspace/listOfProjects.php",{ userId: global_userId },
   	  function(d){
		document.getElementById("left_viewProjectList").innerHTML=d;
		$('#jstree').jstree();	
		initialLoader();
		selectArchFileByProjName(newproj_Name);
	  });
	  
	  
	  /* Close Modal */
	   $('#createProject').modal('toggle');
   }
   
   function selectArchFileByProjName(projctName){
		for(var pind=0;pind<proj_struct.proj_list.length;pind++) {
			var projId=proj_struct.proj_list[pind].projectId;
			var projName=proj_struct.proj_list[pind].projectName;
			var projIcon=proj_struct.proj_list[pind].projectIcon;
			if(projctName===projName) {
				for(var cind=0;cind<proj_struct.proj_list[pind].childrens.length;cind++) {
					var childId=proj_struct.proj_list[pind].childrens[cind].childrenId;
					var childName=proj_struct.proj_list[pind].childrens[cind].childrenName;
					var childIcon=proj_struct.proj_list[pind].childrens[cind].childrenIcon;
							if(childName===projName+'.arch') {
									$('#jstree').jstree(true).select_node(childId);
								}
							}
						}
			}		
   
     console.log("Arch: "+projName);
   }
</script>

 <div>
   <nav class="navbar" style="border-bottom:1px solid #ccc;border-top:1px solid #ccc;">
       <div class="container-fluid">
           
           <div class="navbar-header pull-right">
                <a id="wd_project_heading" class="navbar-brand" href="#">WebDynamics Administrative Workstation</a>
           </div>
           
           <ul class="nav navbar-nav">
               
              <li class="dropdown"><!--  top-active -->
                 <a class="dropdown-toggle" data-toggle="dropdown" href="#">File
                 <span class="caret"></span></a>
                 <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#createProject">Create New Project</a></li>
                    <li class="divider"></li>
                    <li id="file_viewProj"><a href="#" onclick="viewProjects()">View Projects</a></li>
                 </ul>
              </li>
                            
              <li class="dropdown">
				 <a class="dropdown-toggle" data-toggle="dropdown" href="#">Edit
					<span class="caret"></span>
					<ul class="dropdown-menu">
						<li onclick="openFileContent('file_Id', 'fileName')"><a href="#">Reload Current File (FileName)</a></li>
					    <li class="divider"></li>
					    <li><a href="#">Save Current File (FileName)</a></li>
						<li class="divider"></li>
						<li><a href="#" onclick="deleteAllFilesinOpenList()">Close All Files</a></li>
					</ul>
				 </a>
			  </li>
                            
              <li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Deployments
						<span class="caret"></span></a>
						 <ul class="dropdown-menu">
							<li><a href="#">Web Deployment in WebServers</a></li>
							<li class="divider"></li>
							<li><a href="#">Database Deployment in DatabaseServers</a></li>
						 </ul>
				  </a></li> 
              <li><a href="#">Page 3</a></li> 
              
           </ul>
       </div>
   </nav>
</div>



<!-- Modal -->
<div id="createProject" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close pull-right" data-dismiss="modal">
            <b>
              <span class="glyphicon glyphicon-remove"></span>  
            </b>
        </button>
        <h4 class="modal-title"><b>CREATE NEW PROJECT</b></h4>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
              <div class="col-md-12">
                  <input type="text" class="form-control" id="newproj_Name" placeholder="Enter your Project Name"/>
              </div>
			  
			  <div class="col-md-12"  style="margin-top:2%;">
                  <b>Languages:</b>
              </div>
			  
			  <style>
				.mtop10 { margin-top:10%; }
				.checkBox { width:20px;height:20px; }
			  </style>
			  
			  <div class="col-md-12"  style="margin-top:1%;">
					<div class="col-md-1">
						<input type="checkbox" id="newproj_lang_PHP" name="newproj_lang" value="PHP" class="checkBox">
					</div>
					<div class="col-md-2"><div class="mtop10">PHP</div></div>
					<div class="col-md-1">
						<input type="checkbox" id="newproj_lang_Java" name="newproj_lang" value="Java" class="checkBox">
					</div>
					<div class="col-md-2"><div class="mtop10">Java</div></div>
			  </div>
			  
			  
              <div class="col-md-12" style="margin-top:2%;">
                  <button class="btn btn-primary form-control" onclick="javascript:createProject()"><b>Create a Project</b></button>
              </div>
          </div>
      </div>
     
    </div>

  </div>
</div>

