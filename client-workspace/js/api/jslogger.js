/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var logger_url='php/api/logManager.php';
/* Add Line Number Also */
function lineNumberFormat(number){
  var num='';
  if(String(number).length<4) {
   for(var index=0;index<(4-String(number).length);index++){ num+='0'; }
  }
  num=num+String(number);
  return num;
}
function jsloggerWarn(num, fileName, msg){
/* logType: WARN, TRACE, INFO, DEBUG, FATAL, ERROR */
var number=lineNumberFormat(num);
var access_response='';
$.ajax({type : "GET",async : false,url : logger_url, 
data : {action:'Logger', Working_FileName:fileName, Working_Line: number,
Working_LoggerType:'WARN', Working_LoggerMessage:msg}, 
success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);

}
function jsloggerTrace(num, fileName, msg){
var number=lineNumberFormat(num);
var access_response='';
$.ajax({type : "GET",async : false,url : logger_url, 
data : {action:'Logger', Working_FileName:fileName, Working_Line: number,
Working_LoggerType:'TRACE', Working_LoggerMessage:msg}, 
success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);
}
function jsloggerInfo(num, fileName, msg){
var number=lineNumberFormat(num);
var access_response='';
$.ajax({type : "GET",async : false,url : logger_url, 
data : {action:'Logger', Working_FileName:fileName, Working_Line: number,
Working_LoggerType:'INFO',  Working_LoggerMessage:msg}, 
success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);
}
function jsloggerDebug(num, fileName, msg){
var number=lineNumberFormat(num);
var access_response='';
$.ajax({type : "GET",async : false,url : logger_url, 
data : {action:'Logger', Working_FileName:fileName, Working_Line: number,
Working_LoggerType:'DEBUG',  Working_LoggerMessage:msg}, 
success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);
}
function jsloggerFatal(num, fileName, msg){
var number=lineNumberFormat(num);
var access_response='';
$.ajax({type : "GET",async : false,url : logger_url, 
data : {action:'Logger', Working_FileName:fileName, Working_Line: number,
Working_LoggerType:'FATAL',  Working_LoggerMessage:msg}, 
success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);
}
function jsloggerError(num, fileName, msg){
var number=lineNumberFormat(num);
var access_response='';
$.ajax({type : "GET",async : false,url : logger_url, 
data : {action:'Logger', Working_FileName:fileName, Working_Line: number,
Working_LoggerType:'ERROR', Working_LoggerMessage:msg}, 
success : function(resp) { access_response = resp.trim(); } }); 
console.log("response : "+access_response);
}

