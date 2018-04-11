<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>WebDynamics-CW</title>
        <script src="js-api-jquery"></script>
        <script src="js-api-bootstrap"></script>
        <script type="text/javascript" src="js/api/jslogger.js"></script>
        <link rel="stylesheet" href="styles-api-bootstrap">
    </head>
    <body style="background-color: #E91E63;">
        <?php include_once 'templates/default-header.php'; ?>
        
        <div class="container-fluid">
            <div class="row" style="margin-top:9%;"></div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="panel panel-danger" style="border:3px solid #000;">
                            <div class="panel-heading" style="color:#000;border-bottom:3px solid #000;">
                                <b>Login</b>
                                <span class="pull-right"><b>X</b></span>
                            </div>
                            <div class="panel-body">
                                <form>
                                    <div class="form-group">
                                      <label for="email">Username:</label>
                                      <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group">
                                      <label for="pwd">Password:</label>
                                      <input type="password" class="form-control" id="pwd">
                                    </div>
                                    <div class="checkbox">
                                      <label><input type="checkbox"> Remember me</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary form-control"><b>Submit</b></button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            
        </div>
    </body>
</html>
