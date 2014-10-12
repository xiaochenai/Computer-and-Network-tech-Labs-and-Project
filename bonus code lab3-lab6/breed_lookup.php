<html>
<head>
<title>Breed Lookup Search Results</title>
</head>
<body>
<?php
// Connect to the mySQL server and select our database
$dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
mysql_select_db("pet_store",$dbcnx) or die("Can not select database");
// Now let's do our mySQL query to lookup the information
$query = "SELECT * FROM animals WHERE breed=\"$_GET[breed_input]\" ";
// We needed the slashes (\) to go with the PHP syntax, but
// to actually complete the query we need to get rid of them.
$query = stripslashes($query);
// Actually run the query
$result = mysql_query($query) or die(mysql_error());
// Return how many fields we selected with our *
$number_cols = mysql_num_fields($result);
// Set up the initial table and header rows
echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\"><tr><td>Id</td><td>Species</td><td>Breed</td><td>Quantity</td><td>Price</td></tr>";
// This next line creates an array called $row which will
// contain all of the items in a row returned by the mySQL
// query
while ($row = mysql_fetch_row($result))
{
echo "<tr>";
for ($i=0;$i<$number_cols;$i++)
{
echo "<td>$row[$i]</td>";
}
echo "</tr>";
}
?>
</body>
</html>