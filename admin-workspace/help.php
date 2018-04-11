<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WebDynamics</title>
        <link rel="stylesheet" href="styles-api-bootstrap">
        <script src="js-api-jquery"></script>
        <script src="js-api-bootstrap"></script>
        <script type="text/javascript">
            $(document).ready(function(){
               header_help(); 
               menu_content1();
            });
        </script>
        <style>
            .help-heading { font-size:24px;font-family: hm_boogaloo;float:left; }
            .list-group-item.subactive, .list-group-item.subactive:focus, .list-group-item.subactive:hover { z-index: 10;color: #fff;background-color: #FF9800;border-color:#FF9800; }
            .h30 { height:30px; }
            .mtop1-5{margin-top:1.5%; }
            .help-content { font-size:16px;line-height: 30px; }
            #content1_text,#content1subcontent1_text,#content1subcontent2_text{display:none;}
            hr {width:100%;}
            #webdynamic_content {margin-bottom:2%;}
        </style>
    </head>
    <body onload="">
        <!-- alert(window.innerWidth); -->
        <?php include_once 'templates/default-header.php'; ?>
        <!-- -->
        <script type="text/javascript">
            function menu_content1(){
              $('#content1_title').addClass('active');
              $('#content2_title').removeClass('active');
              $('#content3_title').removeClass('active');
              
              document.getElementById("content1_text").style.display='block';
              document.getElementById("content1subcontent1_text").style.display='none';
            //  document.getElementById("content1subcontent2_text").style.display='none';
              
            }
                    function menu_content1subtitle1(){
                        $('#content1_subtitle1').addClass('subactive');
                        $('#content1_subtitle2').removeClass('subactive');
                        $('#content1_subtitle3').removeClass('subactive');
                        
                         document.getElementById("content1_text").style.display='none';
                         document.getElementById("content1subcontent1_text").style.display='block';
                      //   document.getElementById("content1subcontent2_text").style.display='none';
                    }
                    function menu_content1subtitle2(){
                        $('#content1_subtitle1').removeClass('subactive');
                        $('#content1_subtitle2').addClass('subactive');
                        $('#content1_subtitle3').removeClass('subactive');
                        
                        document.getElementById("content1_text").style.display='none';
                        document.getElementById("content1subcontent1_text").style.display='none';
                     //   document.getElementById("content1subcontent2_text").style.display='block';
                    }
                    function menu_content1subtitle3(){
                        $('#content1_subtitle1').removeClass('subactive');
                        $('#content1_subtitle2').removeClass('subactive');
                        $('#content1_subtitle3').addClass('subactive');
                    }
            function menu_content2(){
              $('#content1_title').removeClass('active');
              $('#content2_title').addClass('active');
              $('#content3_title').removeClass('active');
            }
            function menu_content3(){
              $('#content1_title').removeClass('active');
              $('#content2_title').addClass('active');
              $('#content3_title').removeClass('active');
            }
        </script>
        
        
        <div class="container-fluid">
            <div class="col-md-4" style="margin-top:0.2%;">
                <div class="list-group" style="padding-left: 2%;padding-right: 5%;padding-top: 1.5%;">
                        <a id="content1_title" onclick="menu_content1()" href="#" class="list-group-item" data-toggle="collapse" data-target="#demo">About WebDynamics</a>
                            <div id="demo" class="collapse">
                                  <div class="list-group">
                                       <a id="content1_subtitle1" href="#" class="list-group-item">WebDynamics Overview</a>
                                       <a id="content1_subtitle2" href="#" class="list-group-item">Architecture of WebDynamics</a>
                                       <a id="content1_subtitle3" href="#" class="list-group-item">item-3</a>
                                  </div>
                            </div>
                        <a id="content2_title" href="#" class="list-group-item">Second item</a>
                        <a id="content3_title" href="#" class="list-group-item">Third item</a>
                </div>
            </div>
            
            <div id="webdynamic_content" class="col-md-8" style="padding-right: 5%;padding-left: 2%;">
                <!-- About WebDynamics:Start -->
                    <?php include 'templates/help/content1_text.php'; ?>
                <!-- About WebDynamics:End -->
                
                <!-- WebDynamics Overview:Start -->
                    <?php include 'templates/help/content1subcontent1_text.php'; ?>
                <!-- WebDynamics Overview:End -->
                
                <!-- Architecture of WebDynamics:Start -->
                
                <!-- Architecture of WebDynamics:End -->
                
            </div>
        </div>
    </body>
</html>
