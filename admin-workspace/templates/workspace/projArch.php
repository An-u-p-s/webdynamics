<script type="text/javascript" src="js/api/vis.js"></script>
<link href="styles/api/vis.css" rel="stylesheet" type="text/css"/>
<style>
.projArc_heading { border:1px solid #fff; margin-left:0.1%;margin-right:0.1%;height:26px;background-color:#000;color:#fff;font-weight:bold;font-size:18px;}
.projArc_iconheading { margin-left:0.1%;background-color:#000;border-bottom:1px solid #fff; }
.projArc_iconbtn { border-left:1px solid #fff;height:35.5px; }
.projArc_icontext { font-weight:bold;font-size:14px; }
.projArc_iconServer { border-left:1px solid #fff; }
.projArc_icondb {border-left:1px solid #fff;border-right:1px solid #fff; }
.projArc_content { margin-left:0.1%;    }
.projArc_config { overflow-y:scroll;background-color:#fff;height:500px;border-left:1px solid #fff;border-bottom:1px solid #fff; }
#projArc_configForm { display:none;margin-top:3%;margin-left:3%;margin-right:3%; }
.projArc_dnd { height:590px;border-left:1px solid #fff; }
.projArc_mtop2{ margin-top:2%; }
</style>
<script type="text/javascript" src="js/pages/workspace/projArch.js"></script>
<script type="text/javascript">

</script>
<div class="col-md-12 projArc_heading">PROJECT ARCHITECTURE</div>
<div class="col-md-12 projArc_iconheading">
	<div class="btn-group">
		<button type="button" class="btn btn-black projArc_iconbtn">
			<span class="projArc_icontext">ICONS:</span>
		</button>
		<button type="button" class="btn btn-black projArc_iconServer" data-toggle="tooltip" title="WebServer" onclick="addWebServerNode()"><i class="fa fa-server  fa-2x" aria-hidden="true"></i></button>
		<button type="button" class="btn btn-black projArc_icondb" data-toggle="tooltip" title="DatabaseServer"><i class="fa fa-database fa-2x" aria-hidden="true"></i></button>
	</div>
</div>
<div class="col-md-12 projArc_content">
	<!-- Node Properties -->
	<div class="col-md-3 projArc_config">
		<div id="projArc_configForm">
				<div id="view_Node_removeNode" class="form-group">
					<label class="pull-right"><span class="glyphicon glyphicon-remove" onclick="removeWebServerNode()"></span></label>
				</div>
				<div class="form-group">
					<label for="email">Node Name:</label>
					<input type="text" class="form-control" id="view_Node_Name" placeholder="Enter Node Name">
				</div>
				<div class="form-group">
					<label for="pwd">Node Id:</label>
				    <input type="text" class="form-control" id="view_Node_Id" placeholder="Enter Node-Id" disabled="true">
				</div>
				<div class="form-group">
					<label for="pwd">Node Comment:</label>
				    <input type="text" class="form-control" id="view_Node_title" placeholder="Enter Node Comment">
				</div>
				<div id="view_Node_Conected_to" class="form-group">
				</div>
				<div id="view_NodeConnection_Comment" class="form-group"></div>
				<script type="text/javascript">
					function change_nodeprop_icon() {
						if($('#nodeprop_icon').hasClass('glyphicon-menu-down')) {
						   $('#nodeprop_icon').addClass('glyphicon-menu-up');
						   $('#nodeprop_icon').removeClass('glyphicon-menu-down');
						}else {
						   $('#nodeprop_icon').removeClass('glyphicon-menu-up');
						   $('#nodeprop_icon').addClass('glyphicon-menu-down');
						}
					}
				</script>
				<div class="form-group">
					<div class="list-group">
						<a href="#" class="list-group-item"  data-toggle="collapse" data-target="#demo" onclick="javascript:change_nodeprop_icon()">
							Node Properties
							<span id="nodeprop_icon" class="glyphicon glyphicon-menu-down pull-right"></span>
						</a>
						<div id="demo" class="collapse">
							<div class="list-group">
								<a href="#" class="list-group-item">
								  <input type="text" class="form-control" id="iconId" placeholder="Enter ServerName">
								</a>
								<a href="#" class="list-group-item">
								  <input type="text" class="form-control" id="iconId" placeholder="Enter Username">
								</a>
								<a href="#" class="list-group-item">
								  <input type="password" class="form-control" id="iconId" placeholder="Enter Password">
								</a>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="form-group">
					<button class="form-control btn btn-black" onclick="updateWebServerNode()"><b>Update Selected Node</b></button>
				</div>

		</div>
	</div>
	
	<!-- DRAG-AND-DROP FUNCTIONALITY -->	
	<div  id="network" align="center" class="col-md-9 projArc_dnd"></div>
	
</div>
					