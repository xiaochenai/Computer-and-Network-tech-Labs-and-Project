<?php
//connect to the database server
$dbconn = mysql_connect("localhost", "root", "lx64498908") or die("Could not connect to database server.");
//select the database "store"
@mysql_select_db("store",$dbconn) or die("Could not connect to store database.");

print "<html>\n<head>\n<title>XML Database: store</title>\n</head>\n<body>\n";

if(isset($_GET['Action']))
{
	if( isset($_GET['searchTerm']))
	{
		$searchTerm = $_GET['searchTerm'];
		$query = "SELECT *,ExtractValue(phone.Details,'/details/display'),ExtractValue(phone.Details,'/details/body'),ExtractValue(phone.Details,'/details/memory'),ExtractValue(phone.Details,'/details/camera'),ExtractValue(phone.Details,'/details/OS'),
ExtractValue(phone.Details,'/details/camera'),ExtractValue(phone.details,'/details/OS'),
ExtractValue(phone.details,'/details/Chipset'),ExtractValue(phone.details,'/details/battery')		FROM phone
				WHERE phone.Name LIKE '%$searchTerm%';";
		print "You searched for \"$searchTerm\""; 
	}
	else
		$query = "SELECT *,ExtractValue(phone.Details,'/details/display'),ExtractValue(phone.Details,'/details/body'),
		ExtractValue(phone.Details,'/details/memory'),ExtractValue(phone.Details,'/details/camera'),
ExtractValue(phone.details,'/details/OS'),ExtractValue(phone.details,'/details/Chipset'),
ExtractValue(phone.details,'/details/battery')		FROM phone";
}
else
		$query = "SELECT *,ExtractValue(phone.Details,'/details/display'),ExtractValue(phone.Details,'/details/body'),
		ExtractValue(phone.Details,'/details/memory'),ExtractValue(phone.Details,'/details/camera'),
ExtractValue(phone.details,'/details/OS'),ExtractValue(phone.details,'/details/Chipset'),
ExtractValue(phone.details,'/details/battery')		FROM phone";

// We needed the slashes (\) to go with the PHP syntax, but
// to actually complete the query we need to get rid of them.
$query = stripslashes($query);

// Actually run the query
$res = mysql_query($query,$dbconn);

//create a table to display the data nicely:
print "<table  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";

print @"<tr><td colspan=4><table><tr><td>
			<form action=\"$PHP_SELF\" method=\"GET\">
			<input type=\"text\" name=\"searchTerm\" value=\"$searchTerm\"/>
			<input type=\"submit\" name=\"Action\" value=\"Search\"></form></td><td>
			<form action=\"$PHP_SELF\" method=\"GET\">
			<input type=\"submit\" value=\"Clear Search\"/></form></td></tr></table></td></tr>";

print "<tr><td>Name</td><td>Producer</td><td>Details</td><td>Price</td></tr>";
while ($row = mysql_fetch_row($res)) {
	print "<tr>";
	print "<td>$row[0]</td>";//display the Name returned
	print "<td>$row[1]</td>";
	
	{
		//we have detail informations. Let's create a table to display their names nicely.
		print "<td><ul>";
		print "<li>Display: $row[4]</li>";
		print "<li>Body: $row[5]</li>";
		print "<li>Memory: $row[6]</li>";
		print "<li>Camera: $row[7]</li>";
		print "<li>OS: $row[8]</li>";
		print "<li>Chipset: $row[9]</li>";
		print "<li>Battery: $row[10]</li>";
		print "</ul></td>";
	}
	print "<td>$ $row[3]</td>";
	print "</tr>";
}
print "</table>";	//finish up the table HTML
mysql_free_result($res); //free the results from memory

print "</body>\n</html>\n";
?>