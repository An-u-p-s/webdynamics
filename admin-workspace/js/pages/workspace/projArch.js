var nodes, edges, network, node_id, edge_id, node_names;
var ws_node_num,db_node_num;
var remove_node_Identity;
var n_identity;



function generateNodeConnectionComment(n_label, node_id) {

var mul_conn=$('#node_connect_list').val();
 if(mul_conn!==null) {
			var view_NodeConnection_CommentElem='';
		   for(var index=0;index<mul_conn.length;index++) {
			for(var n=1;n<=node_id;n++) {
			      var checklabel=nodes._data[n].label;
				  var mulIndex=mul_conn[index];
				  var selectNodeId=nodes._data[n].id;
					if(n_label!==checklabel && parseInt(mulIndex)===parseInt(selectNodeId)){
					  view_NodeConnection_CommentElem+='<input type="text" name="" class="form-control projArc_mtop2" value="" placeholder="'+nodes._data[n].label+'"/>';
					}
				
			}	
		   }
	 }
	 console.log("view_NodeConnection_CommentElem: "+view_NodeConnection_CommentElem);
    document.getElementById("view_NodeConnection_Comment").innerHTML=view_NodeConnection_CommentElem;
}

function clickAndDragEvent(params){
    /* LeftPanelDisplay :: */
 document.getElementById("projArc_configForm").style.display='block';
   
	var index=params.nodes;
	console.log("params -- "+JSON.stringify(params));
	console.log("index: "+index)
	if(index.length===0) {
		document.getElementById("projArc_configForm").style.display='none';
	} else {
		/* Get Node-Id: */  n_identity=nodes._data[index].id;
							remove_node_Identity=nodes._data[index].id;
							if(remove_node_Identity===1) { document.getElementById("view_Node_removeNode").style.display='none'; }
							else { document.getElementById("view_Node_removeNode").style.display='block'; }						
		/* Get Label:   */ var n_label=nodes._data[index].label;
		/* Get Title:   */ var n_title=nodes._data[index].title;
	 
		document.getElementById("view_Node_Name").value=n_label;
		document.getElementById("view_Node_Id").value=n_identity;
		document.getElementById("view_Node_title").value=n_title;
		if(node_id>1) {
			var noptcontent='<label for="pwd">Connected to:</label>';
				noptcontent+='<select id="node_connect_list" class="form-control" multiple="true">'; 
			
			for(var n=1;n<=node_id;n++) {
				if(n_label!==nodes._data[n].label){
					noptcontent+='<option id="'+nodes._data[n].id+'" value="'+nodes._data[n].id+'" onclick="generateNodeConnectionComment(\''+n_label+'\',\''+node_id+'\');">'+nodes._data[n].label+'</option>';
				}
			}
			noptcontent+='</select>';
			noptcontent+='<label for="pwd"><button  class="btn btn-black" onclick="select_all_Nodes()">Select All</button><button class="btn btn-black"  onclick="deselect_all_nodes()">De-Select All</button></label>';
			document.getElementById("view_Node_Conected_to").innerHTML=noptcontent;
			
			/* Select Based on Edges :: */
			//n_identity
			var edges_list=JSON.stringify(edges.get(), null, 4);
			console.log(edges_list);
				edges_list=JSON.parse(edges_list);
			for(var index=0;index<edges_list.length;index++) {
				if(n_identity===edges_list[index].from || n_identity===edges_list[index].to) {
					var sel_edg='';
					if(n_identity===edges_list[index].from){ 
					    sel_edg=edges_list[index].to;
					}
					if(n_identity===edges_list[index].to) {
						sel_edg=edges_list[index].from;
				    }
				console.log("Select this nodes(sel_edg): "+sel_edg);
					 $('#node_connect_list option[id='+sel_edg+']').prop('selected', true);
				} }
			}
			
		}
	
}

function initializeArch(fileName) {
console.log("InitializeArch Started:: ");
console.log("fileName: "+fileName);
/* New Project Arch */

ws_node_num=0, db_node_num=0;
nodes = new vis.DataSet();
// Default Node: For New Project Arch
/*default_node=[{id: node_id, label: 'WebDynamics Administrative WorkStation', title: 'I have a popup!', shape: 'box', font:{size:15}, size:15,
			 color: {background:'pink', border:'purple',highlight:{background:'pink',border:'purple'},
			 hover:{background:'purple',border:'pink'}},shadow:true }]; */
/* Reading '.projArch' File */
var access_response='failure';
$.ajax({type : "GET",async : false,url : 'users/USER12345/A/A.projarch', data : {}, success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);
access_response=JSON.parse(access_response);
/* Getting Existing Nodes from '.projArch' File */			   
default_node=access_response.projArch.Nodes; // List of Nodes
console.log("default_node : "+default_node);
node_id=access_response.projArch.Nodes.length; //Number of Nodes
nodes.add(default_node);

edges = new vis.DataSet();
default_edges=access_response.projArch.Edges; // List of Edges
edge_id=access_response.projArch.Edges.length; // Number of Edges
edges.add(default_edges);

// create a network
 var container = document.getElementById('network');
 var data = { nodes: nodes, edges: edges };
 var options = {interaction:{hover:true}};
 network = new vis.Network(container, data, options);

 network.on("deselectNode", function (params) { 
     document.getElementById("projArc_configForm").style.display='none';
 });
/*  network.on("hoverNode", function (params) {
     clickAndDragEvent(params);
 }); */
 network.on("dragStart", function (params) {
     clickAndDragEvent(params);
 });
 network.on("click", function (params) { 
 clickAndDragEvent(params);
 });
 

}
function select_all_Nodes() {
    $('#node_connect_list option').prop('selected', true);
}
function deselect_all_nodes() {
$('#node_connect_list option').prop('selected', false);
}

function addWebServerNode() {
	ws_node_num++, node_id++;
    try { nodes.add({ id: node_id, label: 'WebServer_'+ws_node_num, title: 'I have a popup!',
					  shape: 'box', font:{size:15}, size:15, color: {background:'pink', border:'purple',highlight:{background:'pink',border:'purple'},
					  hover:{background:'purple',border:'pink'}},shadow:true });
        } catch (err) { alert(err); }
}

function updateWebServerNode(){
 var mul_conn=$('#node_connect_list').val();
	 nodes.update({ id: document.getElementById('view_Node_Id').value, label: document.getElementById('view_Node_Name').value });
	 // Check From, to already exist or not :: If exist, don't update.4
	 //nodes=JSON.stringify(nodes.get(), null, 4);
	// edges=JSON.stringify(edges.get(), null, 4);
	
	// console.log("Stringify Nodes: "+nodes);
	// console.log("Stringify Edges: "+edges);
	
	
		  var currentNode=document.getElementById('view_Node_Id').value;
		   console.log("currentNode: "+currentNode+"  edge_id: "+edge_id+"  edges: "+JSON.stringify(edges));
			   /* Removing Edges to a Respective Node ::: */
			   for(var index=1;index<edge_id;index++) {
					if(edges.length>0){
					console.log('index[remove]: '+index);
					  if(edges._data[index]!==undefined) {
						if(edges._data[index].from===currentNode || edges._data[index].to===currentNode) {
						   var rem_sel_edg='';
						    if(edges._data[index].from===currentNode) {
								rem_sel_edg=edges._data[index].to;
							}
							if(edges._data[index].to===currentNode) {
								rem_sel_edg=edges._data[index].from;
							}
							console.log("Data Index: "+JSON.stringify(edges._data[index])+"Reading From: "+rem_sel_edg);
						
							try { edges.remove({id: index }); }
							catch (err) { alert(err); }
						}
						
						}
					  }	
			 	}
				
			
				console.log("latestNode: "+currentNode+"  edge_id: "+edge_id+"  edges: "+JSON.stringify(edges));
				
		 if(mul_conn!==null) {
				/* Adding New Edges to a Respective Node ::: */
				for(var eloop=0;eloop<mul_conn.length;eloop++) {
					try { edges.update({ id: edge_id,title:'Hello', from: currentNode, to: mul_conn[eloop], arrows:'to, from', dashes:true }); } 
					catch (err) { alert(err); }
					edge_id++;    
				}
	 }
	 
}


function removeWebServerNode() {
	if(remove_node_Identity!==1) {
		/* Remove All Edges connected to Node */
		
		/* Then, Remove The Node */
		try { nodes.remove({id: remove_node_Identity}); }
        catch (err) { alert(err); }
	}
}

function saveprojArch(){
    var json='{ "projArch": { ';
        json+='"Nodes":['+nodes+"],";
        json+='"Edges":['+edges+"],";	
        json+='"NodeConfig":[] } }';
        
  console.log(json);
}