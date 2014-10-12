<?php
//connect to the database server
$dbconn = mysql_connect("localhost", "root", "lx64498908") or die("Could not connect to database server.");
//select the database "test"
@mysql_select_db("test",$dbconn) or die("Could not connect to pet_store database.");
print "<html>\n<head>\n<title>XML Database example</title>\n</head>\n<body>\n";

$query = "SELECT * FROM books";

// We needed the slashes (\) to go with the PHP syntax, but
// to actually complete the query we need to get rid of them.
$query = stripslashes($query);

// Actually run the query
$res = mysql_query($query,$dbconn);

//create a table to display the data nicely:
print "<table  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
print "<tr><td>ISBN</td><td>Title</td><td>Authors</td></tr>";
//every time using the mysql_fetch_row it will return the next line or false if there is no next line
while ($row = mysql_fetch_row($res)) {
	print "<tr>";
	print "<td>$row[0]</td>"; //display the first column returned
	print "<td>$row[1]</td>"; //display the second column returned
	print "<td>$row[2]</td>"; //display the third column returned
	print "</tr>";
}
print "</table>";	//finish up the table HTML
mysql_free_result($res); //free the results from memory
print "</body>\n</html>\n";
?>