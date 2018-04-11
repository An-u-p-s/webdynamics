  

/*  openedFilesList   : { "openlist":"[{"projectName":"<projectName>", "projectId":"<projectId>", "fileName" : "<fileName>", "fileId" :"fmenu_<fileId>"}] } */
/*  currentViewingFile: { "openlist":"[{"projectName":"<projectName>", "projectId":"<projectId>", "fileName" : "<fileName>", "fileId" :"fmenu_<fileId>"}] } */

/* Recognizers ::*/
var removeRecognizer;
var removeActiveRecognizer;

function addFileinOpenList(projectName, projectId, fileName, fileId){  
/* Adding FileName and FileId in OpenedList
 * LOGIC: Checks openedFilesList contains the File or not, if doesn't contain adds the FieName,FileId with respect to
 *        ProjectName and projectId.
 */
   removeRecognizer=false;
   removeActiveRecognizer=false;
   var fileId="fmenu_"+fileId;
   if(openedFilesList.openlist==undefined){ openedFilesList.openlist=[]; }
   var add=1;
   var fileTab='<ul class="nav nav-tabs">';
   // Check Already FileId Exist or Not 
     for(var index=0;index<openedFilesList.openlist.length;index++){
	    var f_Name=openedFilesList.openlist[index].fileName;
	    var f_Id=openedFilesList.openlist[index].fileId;
            var p_Name=openedFilesList.openlist[index].projectName;;
            var p_Id=openedFilesList.openlist[index].projectId;;
		if(fileName===f_Name && fileId===f_Id) {
			add=0;
		    fileTab+='<li id="fmenu_'+f_Id+'" class="active" onclick="selectAFileinOpenList(\''+p_Name+'\',\''+p_Id+'\',\''+f_Name+'\',\''+f_Id+'\')"><a href="#"><span>'+f_Name+'</span><span class="crsor_pointer glyphicon glyphicon-remove" onclick="removeFileinOpenList(\''+f_Id+'\')"></span></a></li>';
		} else { fileTab+='<li id="fmenu_'+f_Id+'" onclick="selectAFileinOpenList(\''+p_Name+'\',\''+p_Id+'\',\''+f_Name+'\',\''+f_Id+'\')"><a href="#"><span>'+f_Name+'</span><span class="crsor_pointer glyphicon glyphicon-remove" onclick="removeFileinOpenList(\''+f_Id+'\')"></span></a></li>'; }
	 }
		if(add==1) {
                        currentViewingFile.projectName=projectName;
                        currentViewingFile.projectId=projectId;
			currentViewingFile.fileName=fileName;
			currentViewingFile.fileId=fileId;
			var fileData={"projectName":projectName, "projectId":projectId, "fileName":fileName, "fileId":fileId};
			openedFilesList.openlist.push(fileData);  
			fileTab+='<li id="'+fileId+'" class="active" onclick="selectAFileinOpenList(\''+projectName+'\',\''+projectId+'\',\''+fileName+'\',\''+fileId+'\')"><a href="#"><span>'+fileName+'</span><span class="crsor_pointer glyphicon glyphicon-remove" onclick="removeFileinOpenList(\''+fileId+'\')"></span></a></li>';
		}
		fileTab+='</ul>';
        jsloggerInfo(41,"file_tabs.js","OpenedFileTabList: "+JSON.stringify(openedFilesList));
		/* Building File-Tab */
		document.getElementById("projFile_menu").innerHTML=fileTab;
		openFileContent(projectName, projectId, fileName, fileId);
	//	console.log("openedFilesList: "+JSON.stringify(openedFilesList));
}
function removeFileinOpenList(f_Id){
    jsloggerInfo(48,"file_tabs.js","Removing File with ID('"+f_Id+"') from OpenedFileTabList");
	removeRecognizer=true;
	removeActiveRecognizer=$('li#'+f_Id).hasClass('active');
	console.log('isActive?'+$('li#'+f_Id).hasClass('active'));
	for(var index=0;index<openedFilesList.openlist.length;index++){
	    var fileName=openedFilesList.openlist[index].fileName;
		var fileId=openedFilesList.openlist[index].fileId;
	    if(fileId===f_Id) { delete openedFilesList.openlist.splice(index, 1);; }
	}
      jsloggerInfo(56,"file_tabs.js","OpenedFileTabList: "+JSON.stringify(openedFilesList));
}
	  


function deleteAllFilesinOpenList(){
jsloggerInfo(63,"file_tabs.js","All Files in OpenedFileTabList are deleted");
if(openedFilesList.openlist!==undefined){
	if(openedFilesList.openlist.length>0) {
	delete openedFilesList.openlist;
	document.getElementById("projFile_menu").innerHTML='';
	$('#jstree').jstree("deselect_all");
  }
}
jsloggerInfo(71,"file_tabs.js","OpenedFileTabList: "+JSON.stringify(openedFilesList));
}
	 
function selectAFileinOpenList(project_Name, project_Id, file_Name, file_Id) {

	if(removeRecognizer) {
                project_Name=currentViewingFile.projectName;
                project_Id=currentViewingFile.projectId;
		file_Name=currentViewingFile.fileName;
		file_Id=currentViewingFile.fileId;
                
		removeRecognizer=false;
	}
	var fileTab='<ul class="nav nav-tabs">';
	for(var index=0;index<openedFilesList.openlist.length;index++){
		var fileName=openedFilesList.openlist[index].fileName;
		var fileId=openedFilesList.openlist[index].fileId;
		var projectName=openedFilesList.openlist[index].projectName;
                var projectId=openedFilesList.openlist[index].projectId;
		if(file_Id===fileId || (removeActiveRecognizer===true && index===0)){
		    
			$('#jstree').jstree(true).select_node(fileId.replace("fmenu_", ""));
		   if(removeActiveRecognizer==true && index==0) {
                           project_Name=openedFilesList.openlist[0].projectName;
                           project_Id=openedFilesList.openlist[0].projectId;
			   file_Name=openedFilesList.openlist[0].fileName;
			   file_Id=openedFilesList.openlist[0].fileId;
			   removeActiveRecognizer=false;
		   }
		   fileTab+='<li id="'+fileId+'" class="active" onclick="selectAFileinOpenList(\''+projectName+'\',\''+projectId+'\',\''+fileName+'\',\''+fileId+'\')"><a href="#"><span>'+fileName+'</span><span class="crsor_pointer glyphicon glyphicon-remove" onclick="removeFileinOpenList(\''+fileId+'\')"></span></a></li>';
		} else {
			$('#jstree').jstree(true).deselect_node(fileId.replace("fmenu_", ""));
		   fileTab+='<li id="'+fileId+'" onclick="selectAFileinOpenList(\''+projectName+'\',\''+projectId+'\',\''+fileName+'\',\''+fileId+'\')"><a href="#"><span>'+fileName+'</span><span class="crsor_pointer glyphicon glyphicon-remove" onclick="removeFileinOpenList(\''+fileId+'\')"></span></a></li>';
		}
	}
	fileTab+='<ul>';
	currentViewingFile.projectName=project_Name;
        currentViewingFile.projectId=project_Id;
	currentViewingFile.fileName=file_Name;
	currentViewingFile.fileId=file_Id;
			
	jsloggerInfo(111,"file_tabs.js","currentViewingFile: "+JSON.stringify(currentViewingFile));
	document.getElementById("projFile_menu").innerHTML=fileTab;	
	openFileContent(project_Name, project_Id, file_Name, file_Id);
	
}	 

function openFileContent(projectName, projectId, fileName, file_Id){
	var r_fext='';
	for(var f_index=fileName.length-1;f_index>=0;f_index--) {
	   r_fext+=fileName[f_index];
	   if(fileName[f_index]==='.') { break; }
	}
	if(r_fext==='hcrajorp.')  /* .projarch :: Architecture File */ {
		document.getElementById("projFile_content").style.display='block';
		initializeArch(fileName);
	//	document.getElementById("projFile_content").innerHTML='<b>'+fileName+' Architecture File</b>';
	} else if(r_fext==='seitreporp.') /* .properties :: Properties File */ {
	//	document.getElementById("projFile_content").innerHTML='<b>'+fileName+' Properties File</b>';
	}
}