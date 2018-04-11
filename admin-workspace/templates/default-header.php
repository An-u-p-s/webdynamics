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
.navbar-black{background-color:#000; }
       
@media (min-width:250px){
   #hm_search_opt { margin-left:1%; margin-right:1%; }
}
.c12 { padding-right: 2%;padding-left: 2%; }
.hrow {margin-top:2.5%; }
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
        <nav class="navbar navbar-black">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
                <a class="navbar-brand" href="default.php">
                    <div class="ws_headlogo">
                     <div id="heading"><b>&nbsp;WebDynamics</b>
                        <span style="font-size:14px;font-family:Comic Sans MS,cursive,sans-serif">Administrative WorkStation</span>
                     </div>
                    </div>
                    
                </a>
            </div>
             <div align="center" class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav pull-right">
                    <li id="header_welcome"><a href="workspace.php" class="hm_font1" >Workspace</a></li>
                    <li id="header_help"><a href="help.php" class="hm_font1" >Help</a></li>
                     <li id="header_logReg" data-toggle="modal" data-target="#myModal"><a href="#" class="hm_font1" >Login/Register</a></li>
               </ul>
          </div>
           </div>
            
            <!--    -->
            
        </nav>
    </div>

 
  <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div id="ws_auth_pop" class="modal-content">
      <div id="ws_auth_header" class="modal-header">
        <button type="button" class="close pull-right" data-dismiss="modal"><b>&times;</b></button>
        <h4 align="center" class="modal-title"><b>USER AUTHENTICATION</b></h4>
      </div>
      <div id="ws_auth_body" class="modal-body">
          <div ng-app="app_auth" class="row">
              <div class="col-md-6" ng-controller="form_register"><!-- Register-->
                <form name="ws_signup" ng-submit="ws_register()">
                  <div class="row">
                      <div align="center" class="col-md-12"><h4>Register</h4></div>
                      <input type="hidden" name="ws_signup_status" value="{{ws_signup.$valid}}">
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="text" class="form-control" name="reg_username" ng-model="reg_username" placeholder="Enter your User Name" required/>
                          <input type="hidden" name="reg_username_status" value="{{ws_signup.reg_username.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="text" class="form-control" name="reg_firstname" ng-model="reg_firstname" placeholder="Enter your First Name" required/>
                          <input type="hidden" name="reg_firstname_status" value="{{ws_signup.reg_firstname.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="text" class="form-control" name="reg_middlename" ng-model="reg_middlename" placeholder="Enter your Middle Name"/>
                          <input type="hidden" name="reg_middlename_status" value="{{ws_signup.reg_middlename.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="text" class="form-control" name="reg_lastname" ng-model="reg_lastname" placeholder="Enter your Last Name" required/>
                          <input type="hidden" name="reg_lastname_status" value="{{ws_signup.reg_lastname.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="email" class="form-control" name="reg_email" ng-model="reg_email" placeholder="Enter your Email" required/>
                          <input type="hidden" name="reg_email_status" value="{{ws_signup.reg_email.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="password" class="form-control" name="reg_pwd" ng-model="reg_pwd" placeholder="Enter Password" required/>
                          <input type="hidden" name="reg_pwd_status" value="{{ws_signup.reg_pwd.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12">
                          <input type="password" class="form-control" name="reg_confirmpwd" ng-model="reg_confirmpwd" placeholder="Enter Confirm Password" required/>
                          <input type="hidden" name="reg_confirmpwd_status" value="{{ws_signup.reg_confirmpwd.$valid}}">
                      </div>
                  </div>
                  <div class="row hrow">
                      <div class="col-md-12 c12"><button id="reg_submit" class="btn btn-warning form-control"><b>Register</b></button></div>
                  </div>
                    <div id="reg_custom_validation"></div>
                  </form>
              </div>
              
              <div class="col-md-6"  ng-controller="form_login"><!-- Login-->
                  <form name="ws_signIn" ng-submit="ws_login()">
                        <div class="row">
                            <div align="center" class="col-md-12"><h4>Login</h4></div>
                        </div>
                        <div class="row hrow">
                            <div class="col-md-12 c12"><input type="text" class="form-control" name="login_email" ng-model="login_email" placeholder="Enter your Email" required/></div>
                        </div>
                         <div class="row hrow">
                             <div class="col-md-12 c12"><input type="text" class="form-control" name="login_pwd" ng-model="login_pwd"  placeholder="Enter Password" required/></div>
                        </div>
                        <div class="row hrow">
                            <div class="col-md-12 c12"><button class="btn btn-warning form-control"><b>Login</b></button></div>
                        </div>
                  </form>
              </div>
          </div>
        
          
      </div>
     
    </div>

  </div>
</div>
  
