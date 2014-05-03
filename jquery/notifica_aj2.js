var seconds2 = 180;
var divid2 = "timediv2";
var url2 = "cta1_notifica4.php";

function refreshdiv2(){

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

var timestamp2 = fetch_unix_timestamp();
var nocacheurl = url2+"?t="+timestamp2;

xmlHttp.onreadystatechange=function(){
if(xmlHttp.readyState==4){
	document.getElementById(divid2).innerHTML=xmlHttp.responseText;
	setTimeout('refreshdiv2()',seconds2*1000);
}
}
	xmlHttp.open("GET",nocacheurl,true);
	xmlHttp.send(null);
}

var seconds2;
	window.onload = function startrefresh(){
	setTimeout('refreshdiv2()',seconds*1000);
}