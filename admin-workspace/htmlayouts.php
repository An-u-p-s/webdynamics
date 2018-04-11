<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <script src="js-api-jquery"></script>
         <script src="js-api-bootstrap"></script>
         <link rel="stylesheet" href="styles-api-bootstrap">
         <link rel="stylesheet" href="styles/api/simple-sidebar.css">
         <link rel="stylesheet" href="styles/api/font-awesome.min.css">
         <script>
           $(document).ready(function(){
              swtoggle(); 
           });
           function swtoggle(){
              $("#wrapper").addClass("toggled"); 
           }
         </script>
    </head>
    <body>
        <div id="wrapper">
             <!-- Sidebar -->
             <div id="sidebar-wrapper">
                 
             </div>
             <div id="page-content-wrapper">
                 <button onclick="javascript:swtoggle()">Button</button>
             </div>
        </div>
    </body>
</html>