<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
         function func(event){
		 // console.log(event);
		 //   console.log(event.button);
			if(event.button==0){ console.log("You got Left Click.."); }
			else if(event.button==2){ console.log("You got Right Click..");  }
			
			
		 }
		 var openedFilesList=[];  // Files opened List
	     var currentViewingFile; //  Current Viewing File
	     function addFileinOpenList(fileName){
			openedFilesList[openedFilesList.length]=fileName;
	     }
	  function removeFileinOpenList(){
	  
	  }
	  function deleteAllFilesinOpenList(){
	  
	  }
        </script>
    </head>
    <body>
	<button onclick="addFileinOpenList('test')" onmousedown="func(event)">Test</button>
	
        <!--?php 
        $var=" 'How is going on?' ";
    
    
        $var1= urlencode($var);
        echo $var1."<br/>";
        echo urldecode($var1);
         ?-->
        
    </body>
</html>
