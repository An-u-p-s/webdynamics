<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DAL-Framework</title>
        <link rel="stylesheet" href="styles/bootstrap.min.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style>
            body{ background-color: #fff;font-family:"Arial",Georgia, sans-serf; font-size: 12px; }
            #DalGenerator, #DesignDatabase { display:none; }
        </style>
        <script type="text/javascript">
            function pageOnload()
            {
                viewLeftMenu1();
            }
            function viewLeftMenu1()
            {
                $("#menu1").addClass("active");
                $("#menu2").removeClass("active");
                
                
                document.getElementById("DesignDatabase").style.display='block';
                document.getElementById("DalGenerator").style.display='none';
            }
            function viewLeftMenu2()
            {
               $("#menu1").removeClass("active");
               $("#menu2").addClass("active"); 
               
               document.getElementById("DesignDatabase").style.display='none';
               document.getElementById("DalGenerator").style.display='block';
               
            }
        </script>
    </head>
    <body onload="pageOnload()">
        <?php
        // put your code here
        ?>
        <div class="container-fluid">
             <hr/><h4 align="center">PHP CONTENT FRAMEWORK</h4><hr/>
                    <div class="container-fluid">

                        <div class="col-xs-2">
                            <ul class="nav nav-pills nav-stacked">
                                <li id="menu1"><a href="#" onclick="viewLeftMenu1()">Design Database</a></li>
                                <li id="menu2"><a href="#" onclick="viewLeftMenu2()">DAL Generator</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-10">
                        
                            <div id="DalGenerator">
                                <?php include 'templates/DalGenerator.php';?>
                            </div>
                            
                            <div id="DesignDatabase">
                                <?php include 'templates/DesignDatabase.php';?>
                            </div>
                            
                        </div>
                        
                    </div>
               
        </div>
    </body>
</html>
