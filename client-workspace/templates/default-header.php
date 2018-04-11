<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
    <style>
       
body { overflow-x: hidden; }
body::-webkit-scrollbar-track{
 	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

body::-webkit-scrollbar {
	width: 10px;
	background-color: #000;
}

body::-webkit-scrollbar-thumb {
	background-color: #000;
}
@font-face { font-family: hm_boogaloo;src: url('fonts/Boogaloo-Regular.otf');  }
@font-face { font-family: hm_logo;src: url('fonts/BRUSHSCI.TTF');  }	    
#heading {  font-size:24px;font-family: hm_logo;float:left; }
.logo { margin-top:-18%;}
#heading ,#logo-icon-1,   #logo-icon-2, .header_menu  { color:#fff }
#logo-icon-1 {margin-top:-1.1%; }
#logo-icon-2 { margin-top:1.5%;font-size:28px;}
// body { font-size:11px;overflow-x: hidden; }
.navbar-custom{background-color:#E91E63; }
       
@media (min-width:250px){
   #hm_search_opt { margin-left:1%; margin-right:1%; }
}

.hrow {margin-top:4.5%; }
.hm_custom_active {color:#FFEB3B;}
.hm_font1 { color:#fff;font-weight:bold; }
.hm_font1:hover { color:#000; }
.ws_headlogo { width:100%;margin-left:2%; }
#logo-border { float:left; }

#ws_auth_pop { color:#fff;border:2px solid #000; }
#ws_auth_header { background-color:#FF9800;color:#000; }
#ws_auth_body { background-color:rgba(233, 30, 99, 0.99); }

        </style>
 <script type="text/javascript">
 function header_welcome(){
     $('#header_welcome').addClass('active');
     $('#header_help').removeClass('active');
 }
 function header_help(){
     $('#header_welcome').removeClass('active');
     $('#header_help').addClass('active');
 }
 
 </script>    
 <div class="container-fluid">
        <nav class="navbar navbar-custom">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
                <a class="navbar-brand" href="#">
                    <div class="ws_headlogo">
                     <div id="logo-border">
                        <div class="logo"><i class="fa fa-eur" id="logo-icon-1"></i><i class="fa fa-fighter-jet"  id="logo-icon-2"></i></div>
                     </div>
                     <div id="heading"><b>&nbsp;WebDynamics</b>
                      <span style="font-size:14px;font-family:Comic Sans MS,cursive,sans-serif">Client WorkStation</span>
                     
                     </div>
                     
                    </div>
                </a>
            </div>
             <div align="center" class="collapse navbar-collapse" id="myNavbar">
               <!--ul class="nav navbar-nav pull-right">
                    <li id="header_welcome"><a href="workspace.php" class="hm_font1" >Workspace</a></li>
                    <li id="header_help"><a href="help.php" class="hm_font1" >Help</a></li>
                    <li id="header_logReg" data-toggle="modal" data-target="#myModal"><a href="#" class="hm_font1" >Login/Register</a></li>
               </ul-->
          </div>
           </div>
            
            <!--    -->
            
        </nav>
    </div>


