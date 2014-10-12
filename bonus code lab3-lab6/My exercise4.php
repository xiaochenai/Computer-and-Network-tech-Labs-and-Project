<html>
<head>
<title>My exercise</title>
</head>
<body>
<?php
// Connect to the mySQL server and select our database
$dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
mysql_select_db("pet_store",$dbcnx) or die("Can not select database");
// Now let's do our mySQL query to lookup the information
$query = "SELECT * FROM animals WHERE id_num=\"$_POST[Field_ID]\" ";
// We needed the slashes (\) to go with the PHP syntax, but
// to actually complete the query we need to get rid of them.
$query = stripslashes($query);
// Actually run the query
$result = mysql_query($query) or die(mysql_error());
// Return how many fields we selected with our *
$number_cols = mysql_num_fields($result);
// Set up the initial table and header rows
echo "Old Table";
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
echo "</tr></table></br>";
}

//update
$Mysql_update="update animals set quantity = \"$_POST[New_Quantity]\" where id_num = '1'" ;
$Mysql_update= stripslashes($Mysql_update);
mysql_query($Mysql_update) or die(mysql_error());

//redraw the new table
echo "New Table";
$query =  "select * from animals where id_num=\"$_POST[Field_ID]\" ";
$query = stripslashes($query);
$result = mysql_query($query) or die(mysql_error());
$number_cols = mysql_num_fields($result);
echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\"><tr><td>Id</td><td>Species</td><td>Breed</td><td>Quantity</td><td>Price</td></tr>";
while ($row = mysql_fetch_row($result))
{
echo "<tr>";
for ($i=0;$i<$number_cols;$i++)
{
echo "<td>$row[$i]</td>";
}
echo "</tr></table>";
}
?>
</body>
</html>