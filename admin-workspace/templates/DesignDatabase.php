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
        <link rel="stylesheet" href="../styles/bootstrap.min.css">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <style>
            body { background-color: #fff; }
            #database-create { margin-bottom: 2%; width:40%;height:60px;float:left;}
        </style>
    </head>
    <body>
        <div class="container-fluid" style="">
            
            <div id="row">
                <div id="col-xs-5">
                    <h6 align="center"><B>DESIGN A DATABASE</B></h6><hr/>
                </div>
            </div>
            
            <div id="database-create">
                <div class="col-xs-12">
                <div class="col-xs-4">
                    <span id="label">Database Name :</span>
                </div>
                <div class="col-xs-5">
                    <input type="text" class="form-control"/>
                </div>
                <div class="col-xs-2">
                    <input type="button" class="btn btn-danger" value="Create Database"/>
                </div>
                </div>
                
            </div>
            <!--div id="col-xs-6">
                <div id="col-xs-3">
                    Database Name :
                </div>
                <div id="col-xs-3">
                    <input type="text" class="form-control"/>
                </div>
                <div id="col-xs-3">
                    <input type="button" class="btn btn-danger" value="Create Database"/>
                </div>
            </div-->
        </div>
    </body>
</html>
