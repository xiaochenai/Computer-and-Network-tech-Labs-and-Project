<?php
//connect to the database server
$dbconn = mysql_connect("localhost", "root", "lx64498908") or die("Could not connect to database server.");
//select the database "test"
@mysql_select_db("test",$dbconn) or die("Could not connect to pet_store database.");

print "<html>\n<head>\n<title>XML Database example</title>\n</head>\n<body>\n";

if(isset($_GET['Action']))
{
	if(isset($_GET['ISBN']))
	{
		if(isset($_GET['oldValue']))
			$oldValue = addslashes($_GET['oldValue']);
		else
			$oldValue = "";
		$ISBN = $_GET['ISBN'];
		if(isset($_GET['newValue']))
		{
			$newValue = addslashes($_GET['newValue']);
			if($_GET['Action'] == "Edit")
				$query = "UPDATE books1 SET authors=UpdateXML(books1.authors, '/authorList/author[.=\'$oldValue\']','<author>$newValue</author>') WHERE books1.ISBN=$ISBN;";
			
	
		}
		if(@$_GET['addnewValue']!= '')
		{
			if($_GET['Action'] == "Add")
			{
				$query = "SELECT ExtractValue( books1.authors, 'count(/authorList/author)' ) FROM books1 WHERE books1.ISBN=\"$ISBN\" LIMIT 1;";
				$res = mysql_query($query,$dbconn);
				$row = mysql_fetch_row($res);
				$numEntries = $row[0];			
				$query = "UPDATE books1 SET authors=UpdateXML(books1.authors, 
						concat('/authorList/author[$numEntries]'), 
						concat('<author>',
									ExtractValue(books1.authors,'/authorList/author[$numEntries]'), 
									'</author><author>$addnewValue</author>')
								) WHERE books1.ISBN=\"$ISBN\";";
			}
		}	
		if ($_GET['Action'] == "Delete")
			$query = "UPDATE books1 SET authors=UpdateXML(books1.authors, '/authorList/author[.=\'$oldValue\']','') WHERE books1.ISBN=$ISBN;";
		$res = mysql_query($query,$dbconn);
	}
	if( isset($_GET['searchTerm']))
	{
		$searchTerm = $_GET['searchTerm'];
		$query = "SELECT *, ExtractValue(books1.authors,'count(/authorList/author)'),
				ExtractValue(books1.errata,'count(/errata/erratum)') FROM books1 
				WHERE ExtractValue(books1.authors,'/authorList/author') LIKE '%$searchTerm%';";
		print "You searched for \"$searchTerm\""; 
	}
	else
		$query = "SELECT *,ExtractValue(books1.authors,'count(/authorList/author)'),
					ExtractValue(books1.errata,'count(/errata/erratum)') FROM books1";
}
else
		$query = "SELECT *,ExtractValue(books1.authors,'count(/authorList/author)'),
					ExtractValue(books1.errata,'count(/errata/erratum)') FROM books1";



// We needed the slashes (\) to go with the PHP syntax, but
// to actually complete the query we need to get rid of them.
$query = stripslashes($query);

// Actually run the query
$res = mysql_query($query,$dbconn);


//create a table to display the data nicely:
print "<table  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";


print @"<tr><td colspan=4><table><tr><td>
			<form action=\"$PHP_SELF\" method=\"GET\">
			<input type=\"text\" name=\"searchTerm\" value=\"\"/>
			<input type=\"submit\" name=\"Action\" value=\"Search\"/></form></td><td>
			<form action=\"$PHP_SELF\" method=\"GET\">
			<input type=\"submit\" value=\"Clear Search\"/></form></td></tr></table></td></tr>";

print "<tr><td>ISBN</td><td>Title</td><td>Authors</td><td>Add New Author</td><td>Errata</td></tr>";
while ($row = mysql_fetch_row($res)) {
	print "<tr>";
	print "<td>$row[0]</td>"; //display the ISBN returned
	print "<td>$row[1]</td>"; //display the title returned
	
	{
		//so we have multiple authors. Let's create a table to display their names nicely.
		print "<td><table>";
		$query = "SELECT ExtractValue( books1.authors, '/authorList/author[1]' )";
		$loop = 2;
		while ($loop < $row[4]+1)
		{
			$query = implode(" ", array($query,", ExtractValue( books1.authors, '/authorList/author[$loop]' )"));
			$loop++;
		}
		$query = implode(" ", array($query,"FROM books1 WHERE books1.ISBN = '$row[0]';"));
		$res1 = mysql_query($query,$dbconn);
		while($row1 = mysql_fetch_row($res1))
		{
			$loop = 0;
			while($loop < $row[4])
			{
				print @"<tr><td><table><tr><td><form action=\"$PHP_SELF\" method=\"GET\">
					<input type=\"hidden\" name=\"oldValue\" value=\"$row1[$loop]\"/>
					<input type=\"hidden\" name=\"ISBN\" value=\"$row[0]\"/>
					<input type=\"text\" name=\"newValue\" value=\"$row1[$loop]\"/>
					<input type=\"submit\" name=\"Action\" value=\"Edit\"/>
					</form></td>
					<td><form action=\"$PHP_SELF\" method=\"GET\">
					<input type=\"hidden\" name=\"oldValue\" value=\"$row1[$loop]\"/>
					<input type=\"hidden\" name=\"ISBN\" value=\"$row[0]\"/>
					<input type=\"submit\" name=\"Action\" value=\"Delete\"/>
					</form></td></tr></table></td></tr>";
				$loop++;
			}
		}
		print "</table></td>";
	}
	print @"<td><table><tr><td><form action=\"$PHP_SELF\" method=\"GET\">
					<input type=\"hidden\" name=\"ISBN\" value=\"$row[0]\"/>
					<input type=\"text\" name=\"addnewValue\" value=\"\"/>
					<input type=\"submit\" name=\"Action\" value=\"Add\"/>
					</form></td></tr></table></td>";
//now display the errata
	{
		//so we have multiple authors. Let's create a table to display their names nicely.
		print "<td><table>";
		$query = "SELECT ExtractValue( books1.errata, '/errata/erratum[1]/version' ),
								ExtractValue( books1.errata, '/errata/erratum[1]/date'),
								ExtractValue( books1.errata, '/errata/erratum[1]/information')";
		$loop = 2;
		while ($loop < $row[5]+1)
		{
			$query = implode(" ", array($query,", ExtractValue( books1.errata, '/errata/erratum[$loop]/version' ),
								ExtractValue( books1.errata, '/errata/erratum[$loop]/date'),
								ExtractValue( books1.errata, '/errata/erratum[$loop]/information')"));
			$loop++;
		}
		$query = implode(" ", array($query,"FROM books1 WHERE books1.ISBN = '$row[0]';"));
		$res1 = mysql_query($query,$dbconn);
		while($row1 = mysql_fetch_row($res1))
		{
			$loop = 0;
			while($loop < $row[5])
			{
				print "<tr><td><table>
					<tr><td>Version:</td><td>";
				print $row1[($loop*3)];
				print "</td></tr>
					<tr><td>Date:</td><td>";
				print $row1[($loop*3)+1];
				print "</td></tr>
					<tr><td>Information:</td><td>";
				print $row1[($loop*3)+2];
				print "</td></tr>	</table></td></tr>";
				$loop++;
			}
		}
		print "</table></td>";
	}
	print "</tr>";
}
print "</table>";	//finish up the table HTML
mysql_free_result($res); //free the results from memory

print "</body>\n</html>\n";
?>