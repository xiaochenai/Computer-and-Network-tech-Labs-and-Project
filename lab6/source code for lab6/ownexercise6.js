var xmlHttp;

function calcu(str)
{
//construct a GetXml..  Object
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
//get the form detials by method getElementById
var url="ownexercise6.php";
var cd1price = document.getElementById("cd1price");
var cd1quantity = document.getElementById("cd1quantity");
var cd7price = document.getElementById("cd7price");
var cd7quantity = document.getElementById("cd7quantity");
var movieAprice = document.getElementById("movieAprice");
var movieAquantity = document.getElementById("movieAquantity");
//get right url
url=url+"?cd1price="+cd1price;
url=url+"&cd1quantity="+cd1quantity;
url=url+"&cd7price="+cd7price;
url=url+"&cd7quantity="+cd7quantity;
url=url+"&movieAprice="+movieAprice;
url=url+"&movieAquantity="+movieAquantity;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
//send request to server
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4)
{ 
//get respons and update the form
var response=xmlHttp.responseText.split(",");
document.getElementById("cd1total").innerHTML=xmlHttp.responseText[0];
document.getElementById("cd7total").innerHTML=xmlHttp.responseText[1];
document.getElementById("movieAtotal").innerHTML=xmlHttp.responseText[2];
document.getElementById("shippingtital").innerHTML=xmlHttp.responseText[3];
document.getElementById("total").innerHTML=xmlHttp.responseText[4];
}
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
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