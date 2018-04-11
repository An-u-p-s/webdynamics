/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* Project Structure Building ::: End */
$(document).ready(function(){
    header_welcome();
	$('[data-toggle="tooltip"]').tooltip(); // Activates Stylish ToolTip
    $('#jstree').jstree();	
    initialLoader();
     hideProjects(); // hides the list of projects
 });

