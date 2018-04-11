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
        <script type="text/javascript">
            function dalSubmission()
            {
               
                
                var serverName=document.getElementById("dal_serverName").value;
                var databaseName=document.getElementById("dal_databaseName").value;
                var userName=document.getElementById("dal_userName").value;
                var password=document.getElementById("dal_password").value;
                
                if(serverName.length>0 && databaseName.length>0
                        && userName.length>0)
                {
                    // Send to dac.action.php
                      var result="";
                       $.ajax({type: "GET", 
                                    async: false,
                                    url: 'php/dac/controller.action.php',
                                    data:{dal_serverName:serverName,
                                          dal_databaseName:databaseName,
                                          dal_userName:userName,
                                          dal_password:password},
                                    success: function(resp)
                                    {
                                           result=resp;
                                    }
                                   });
                                   console.log("Result : "+result);
                                   alert("Done");
                }
                
                
                
            }
        </script>
    </head>
    <body>
        <div class="col-xs-12">
            <h5><B>PHP DAL CLASSES GENERATOR</B></h5><hr/>
        </div>
        <div class="col-xs-6">
                            <div class="form-group">
                               <label>Server Name:</label>
                               <input type="text" class="form-control" id="dal_serverName"  name="dal_serverName" placeholder="localhost:3306" value="localhost:3306">
                            </div>

                            <div class="form-group">
                               <label>Database Name:</label>
                               <input type="text" class="form-control" id="dal_databaseName"  name="dal_databaseName" placeholder="UserDB"  value="test">
                            </div>

                             <div class="form-group">
                               <label>User Name:</label>
                               <input type="text" class="form-control" id="dal_userName" name="dal_userName" placeholder="root"  value="root">
                            </div>

                            <div class="form-group">
                               <label>Password:</label>
                               <input type="text" class="form-control" id="dal_password" name="dal_password" placeholder="password" value="@anupanup123">
                            </div>

                             <div class="form-group">
                                <input type="submit" class="btn btn-danger pull-right" value="Generate PHP Classes" onclick="dalSubmission()"/>
                             </div>
        
        </div>
        
    </body>
</html>
