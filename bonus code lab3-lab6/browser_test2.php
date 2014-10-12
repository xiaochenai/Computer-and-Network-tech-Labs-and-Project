<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 9"))
{ 
echo"<h1 style='color:red'>strpos must have returned true</h1><center><b style='color:yellow'>You are using Internet Explorer 9</b></center>";
} 
else
{ 
echo"<h3 style='color:blue'>strpos must have returned false</h3><center><b style='color:green'>You are not using Internet Explorer 9</b></center>";
}
?>