<?php
//connect to the database server
$dbconn = mysql_connect("localhost", "root", "lx64498908") or die("Could not connect to database server.");
//select the database "test"
@mysql_select_db("test",$dbconn) or die("Could not connect to pet_store database.");

print "<html>\n<head>\n<title>XML Database example</title>\n</head>\n<body>\n";


$query = "SELECT *,ExtractValue(books.authors,'count(/authorList/author)') FROM books";

// We needed the slashes (\) to go with the PHP syntax, but
// to actually complete the query we need to get rid of them.
$query = stripslashes($query);

// Actually run the query
$res = mysql_query($query,$dbconn);

//create a table to display the data nicely:
print "<table  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";

print "<tr><td>ISBN</td><td>Title</td><td>Authors</td></tr>";
while ($row = mysql_fetch_row($res)) {
	print "<tr>";
	print "<td>$row[0]</td>"; //display the ISBN returned
	print "<td>$row[1]</td>"; //display the title returned
	if($row[3] > 1) //if we have multiple authors... ($row[3] is the result of $row[3] is the count
		//ExtractValue() function
	{
		//so we have multiple authors. Let's create a table to display their names nicely.
		print "<td><table>";
		$query = "SELECT ExtractValue( books.authors, '/authorList/author[1]' )";
		$loop = 2;
		while ($loop < $row[3]+1)
		{
			$query = implode(" ", array($query,", ExtractValue( books.authors, '/authorList/author[$loop]' )"));
			$loop++;
		}
		//echo "$query";
		$query = implode(" ", array($query,"FROM books WHERE books.ISBN = '$row[0]';"));
		$res1 = mysql_query($query,$dbconn);
		while($row1 = mysql_fetch_row($res1))
		{
			$loop = 0;
			while($loop < $row[3])
			{
				print "<tr><td>$row1[$loop]</td></tr>";
				$loop++;
			}
		}
		print "</table></td>";
	}
	else
		print "<td>$row[2]</td>"; //display the authors returned
	print "</tr>";
}
print "</table>";	//finish up the table HTML
mysql_free_result($res); //free the results from memory
mysql_free_result($res1); //free the results from memory

print "</body>\n</html>\n";
?>