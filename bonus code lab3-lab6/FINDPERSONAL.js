var xmlHttp
function GetPI(str){ 
xmlHttp=GetXmlHttpObject();
//detect if the browser support AJAX
if (xmlHttp==null)  {  
	alert ("Your browser does not support AJAX!");  
	return;  
	} 
	//set the url
	var url="ReadPersonal_3.php";
	url=url+"?q="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	//send request to server
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	}
	function stateChanged() 
	{ 
	//if the respons is ready then updata the client web page 
	if (xmlHttp.readyState==4){ 
	document.getElementById("result").innerHTML=xmlHttp.responseText;
	}
	}
	function GetXmlHttpObject()
	{
	var xmlHttp=null;
	try  {  
	// Firefox, Opera 8.0+, Safari  
	xmlHttp=new XMLHttpRequest();  
	}
	catch (e)
	{  
	// Internet Explorer  
	try    
	{    
	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");    
	}  
	catch (e)    
	{    
	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");    
	}  
	}
	return xmlHttp;
	}