var seconds = 180;
var divid = "timediv";
var url = "cta1_notifica2.php";

function refreshdiv(){

var xmlHttp;
try{
	xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
}
catch (e){
try{
	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
}
catch (e){
try{
	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e){
	alert("Your browser does not support AJAX.");
return false;
}
}
}

fetch_unix_timestamp = function()
{
	return parseInt(new Date().getTime().toString().substring(0, 10))
}

var timestamp = fetch_unix_timestamp();
var nocacheurl = url+"?t="+timestamp;

xmlHttp.onreadystatechange=function(){
if(xmlHttp.readyState==4){
	document.getElementById(divid).innerHTML=xmlHttp.responseText;
	setTimeout('refreshdiv()',seconds*1000);
}
}
	xmlHttp.open("GET",nocacheurl,true);
	xmlHttp.send(null);
}

var seconds;
	window.onload = function startrefresh(){
	setTimeout('refreshdiv()',seconds*1000);
}