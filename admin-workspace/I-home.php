<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <style>
      body{ font-size:12px;}
      #homeMenu1-container { display:none; }
      #homeMenu2-container { display:none; }
      #homeMenu3-container { display:none; }
  </style>
  <script type="text/javascript">
      function pageOnload()
      {
         homeMenu1(); 
      }
      
      function homeMenu1()
      {
          $('#homeMenu1').addClass('active');
          $('#homeMenu2').removeClass('active');
          $('#homeMenu3').removeClass('active');
          
          document.getElementById("homeMenu1-container").style.display='block';
          document.getElementById("homeMenu2-container").style.display='none';
          document.getElementById("homeMenu3-container").style.display='none';
      }
      
      function homeMenu2()
      {
          $('#homeMenu1').removeClass('active');
          $('#homeMenu2').addClass('active');
          $('#homeMenu3').removeClass('active');
          
          document.getElementById("homeMenu1-container").style.display='none';
          document.getElementById("homeMenu2-container").style.display='block';
          document.getElementById("homeMenu3-container").style.display='none';
      }
      
      function homeMenu3()
      {
          $('#homeMenu1').removeClass('active');
          $('#homeMenu2').removeClass('active');
          $('#homeMenu3').addClass('active');
          
          document.getElementById("homeMenu1-container").style.display='none';
          document.getElementById("homeMenu2-container").style.display='none';
          document.getElementById("homeMenu3-container").style.display='block';
      }
      
      
      function homeMenu1_topbtn1()
      {
          document.getElementById("homeMenu1-topbtn1").disabled=false;
          document.getElementById("homeMenu1-topbtn2").disabled=true;
      }
      
      function homeMenu1_topbtn2()
      {
          document.getElementById("homeMenu1-topbtn1").disabled=true;
          document.getElementById("homeMenu1-topbtn2").disabled=false;
      }
      
      function accessMySQLServer()
      {
          var serverName=$('#Access_ServerName').val();
          var username=$('#Access_Username').val();
          var pwd=$('#Access_Password').val();
          
          console.log(serverName);
          console.log(username);
          console.log(pwd);
          
          if(serverName.length>0 && username.length>0 && pwd.length>0)
          {
            var access_response='failure';
             $.ajax({type : "GET",async : false,url : 'php/dac/controller.database.php',
	 	data : {db_action: 'Access_Database_Server',
                        ServerName : serverName,
                        Username : username, 
                        Password: pwd},
	 	success : function(resp) { access_response = resp.trim(); }
		}); 
                console.log("response : "+access_response);
             if(access_response==='success') { homeMenu1_topbtn2(); }
          }
          
          
          
          
          
      }
  </script>
</head>
    <body onload="pageOnload()">
        <div class="container-fluid" style="margin-top:1.2%;">
            <div class="row">
                <div class="col-md-2">
                    <ul class="nav nav-pills nav-stacked">
                        <li id="homeMenu1" onclick="javascript:homeMenu1();"><a href="#">Database Schema Design</a></li>
                        <li id="homeMenu2" onclick="javascript:homeMenu2();"><a href="#">Data-Access Layer Design</a></li>
                        <li id="homeMenu3" onclick="javascript:homeMenu3();"><a href="#">Front-End Layer Design</a></li>
                    </ul>
                </div>
                <div class="col-md-8">
                    
                    <div  id="homeMenu1-container">
                         <div class="btn-group">
                                <button type="button" id="homeMenu1-topbtn1" class="btn btn-primary">Access MySQL Server</button>
                                <button type="button" id="homeMenu1-topbtn2" class="btn btn-primary" disabled="true">Database Management</button>
                         </div>
                        <div class="container-fluid" style="margin-top:1%;">
                            <!--form role="form"-->
                                
                                <div class="form-group">
                                  <label for="usr">Server:</label>
                                  <input type="text" class="form-control" id="Access_ServerName" placeholder="Example: localhost:3306" value="localhost:3306">
                                </div>
                           
                                <div class="form-group">
                                    <label for="pwd">Username:</label>
                                    <input type="text" class="form-control" id="Access_Username" placeholder="Example: root" value="root">
                                </div>
                                
                                <div class="form-group">
                                   <label for="pwd">Password:</label>
                                   <input type="password" class="form-control" id="Access_Password" placeholder="Example: password" value="@anupanup123">
                                </div>
                                
                                 <div class="form-group">
                                     <button class="btn btn-primary pull-right" onclick="accessMySQLServer()">Access MySQL Server</button>
                                </div>
                        <!--/form-->
                        </div>
                        
                    </div>
                   
                    <div  id="homeMenu2-container">
                         
                    </div>
                    
                    <div  id="homeMenu3-container">
                         
                    </div>
                </div>
                
                
            </div>
        
        </div>
    </body>
</html>
