<?php

setcookie("userA","A",time()+3600);
setcookie("userB","B",time()+3600);
setcookie("userC","C",time()+3600);
	
print '<h2 align="center" id="welcomeBanner">Example for multiple cookies!</h2>';

?>

<html>
<head>
	<title>Game</title>
	<script type="text/javascript" src="gotocookie.js"></script> 
</head>

<table border="0">
<tr>
<td>Enter your name: </td>
<td>
	<input type="text" size="30" id="userName" onchange="GetInfo(this.value)"/>
	<input type="submit" value="Submit" />
</td>					
</tr>
<tr>
	<td>Current User: </td>
	<td><p type="text" size="30" id="currentuser" /></td>
</tr>
</table>
</html>

