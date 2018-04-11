/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function initialLoader() {
jsloggerInfo(9,"project_structure.js", "initialLoader() initialized");
proj_structure();
rightClickProjects(proj_struct);
$('#jstree').on("changed.jstree", function (e, data) {
	
	if(data.node!==undefined) {
	jsloggerInfo(15,"project_structure.js","data.selected: "+data.selected);
        jsloggerInfo(16,"project_structure.js","data.node.icon: "+data.node.icon);
        jsloggerInfo(17,"project_structure.js","data.node.text: "+data.node.text);
	
    var projectName='';
    var projectId=data.node.parent;
    var fileName=data.node.text;
    var fileId=data.node.id;
	if(data.node.parent==='#') { projectName=data.node.text;  }
	else {  var pro_list=proj_struct.proj_list;
		for(var i=0;i<pro_list.length;i++){
			var pro_childrens=pro_list[i].childrens;
			   for(var j=0;j<pro_childrens.length;j++) {
				if(pro_childrens[j].childrenId===data.node.id){  projectName=pro_list[i].projectName;  }
			    }
		  }
	     }					
						
	 var content=projectName;
         if(projectName!==fileName) {
	     content+=' ::: '+fileName;
         }
		
        jsloggerInfo(38,"project_structure.js","projectName: "+projectName);
        jsloggerInfo(39,"project_structure.js","projectId: "+projectId);
		 if(data.node.icon=='glyphicon glyphicon-file') {
			addFileinOpenList(projectName,projectId, fileName, fileId);
		 }
	// document.getElementById("wd_project_heading").innerHTML=content;
	 }
	 
     }); 
     
    

}

 
/* Project Structure Building ::: Start */
function getproj_struct(){
    return proj_struct;
}
function proj_structure(){
  var proj_list = $("#jstree").jstree().get_json(); // Full-Project Structure JSON
  folder_struct(proj_list);
 
}

function folder_struct(proj_list){
  var content='';
  if(proj_list.length>0) {
	   content='{ "proj_list":[';
		for(var i=0;i<proj_list.length;i++) {       // Folder Level
		  content+='{';
		  content+='"projectId":"'+proj_list[i].id+'",';
		  content+='"projectName":"'+proj_list[i].text+'",';
		  content+='"projectIcon":"'+proj_list[i].icon+'",';
		  content+='"childrens":[';
		  content=subfolder_struct(proj_list[i],content);
		  var temp='';
		  for(var k=0;k<content.length;k++){ 
			  if(k==content.length-1 && content[k]==','){
				  temp+='';
			  }else {
				temp+=content[k]; 
			  }
		  }
		  content=temp;
		  content+=']},';
	   }
		 var tem='';
		 for(var m=0;m<content.length-1;m++){ tem+=content[m]; }
		 content=tem;
		 content+=']}';
                 jsloggerInfo(96,"project_structure.js", "project Folder Structure: "+content);
		 proj_struct=JSON.parse(content);
    }
	else {
		document.getElementById("left_viewListOfProject").innerHTML='<div align="center" class="col-md-12"><b>Empty</b></div>';
	}
 
}
		
function subfolder_struct(proj_list,content) {
  for(var j=0;j<proj_list.children.length;j++){ // Sub-Folder Level
	content+='{';
	content+='"childrenId":"'+proj_list.children[j].id+'",';
	content+='"childrenName":"'+proj_list.children[j].text+'",';
	content+='"childrenIcon":"'+proj_list.children[j].icon+'"';
	content+='},';
	content=subfolder_struct(proj_list.children[j],content);
    }
   return content;
}

function rightClickProjects(proj_struct){
    $('ul').on('contextmenu', 'li a', function(e) { 
	   
        console.log("Event: "+e.button+" Id: "+this.id);
            if(e.button===2) {
			   
				for(var pind=0;pind<proj_struct.proj_list.length;pind++) {
				  //  console.log(proj_struct.proj_list[pind].projectId);
					var projId=proj_struct.proj_list[pind].projectId;
					var projName=proj_struct.proj_list[pind].projectName;
					var projIcon=proj_struct.proj_list[pind].projectIcon;
					
					if(this.id===projId+"_anchor") {
						$('#jstree').jstree(true).select_node(projId);
						document.getElementById("wd_project_heading").innerHTML=projName;
						/* Project ::: Right Click */
						if(projIcon==='glyphicon glyphicon-briefcase') {
								/* Project RightClick:: Layout*/
								var prc='<ul id="project-menu">';
									prc+='<li data-action="first">Rename the Project</li>';
									prc+='<li data-action="second">Delete the Project</li>';
									prc+='<li data-action="third">Project Properties</li>';
									prc+='</ul>';
								document.getElementById("rightclick").innerHTML=prc;
								
									$("#project-menu").
										// In the right position (the mouse)
									css({
										top: event.pageY + "px",
										left: -100-event.pageX + "px"
									});
						}
						
						
						
					}
					else {
					$('#jstree').jstree(true).deselect_node(projId);
					}
					
					
					for(var cind=0;cind<proj_struct.proj_list[pind].childrens.length;cind++) {
						var childId=proj_struct.proj_list[pind].childrens[cind].childrenId;
						var childName=proj_struct.proj_list[pind].childrens[cind].childrenName;
						var childIcon=proj_struct.proj_list[pind].childrens[cind].childrenIcon;
						
						 if(this.id===childId+"_anchor") {
							$('#jstree').jstree(true).select_node(childId);
							document.getElementById("wd_project_heading").innerHTML=projName+' ::: '+childName;
							
							/* Project Sub-Folder ::: Right Click */
							if(childIcon==='glyphicon glyphicon-folder-open') {
							var cfrc='<ul id="project-menu">';
								cfrc+='<li data-action="first">Add New Folder</li>';
								cfrc+='</ul>';
								document.getElementById("rightclick").innerHTML=cfrc;
								
									$("#project-menu").
										// In the right position (the mouse)
									css({
										top: event.pageY + "px",
										left: -100-event.pageX + "px"
									});
									
							}
							
							/* Project File ::: Right Click  */
						 }
						 else {
							$('#jstree').jstree(true).deselect_node(childId);
						 }
					}
				}
				
			}
        
			
             
        });


	/* Right Click :: Hide */
	// If the document is clicked somewhere
$(document).bind("mousedown", function (e) {
             if (!$(e.target).parents("#project-menu").length > 0) {
                $("#project-menu").hide(100);
             }
			 });
 }
