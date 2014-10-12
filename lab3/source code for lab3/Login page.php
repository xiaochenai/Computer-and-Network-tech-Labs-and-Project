<?php
IF(isset($_POST["username"]))
{	//connect to the database
	$dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
	mysql_select_db("pet_store",$dbcnx) or die("Can not select database");
	// Now let's do our mySQL query to lookup the information
	$query = "Select * from customers where username=\"$_POST[username]\" ";
	// We needed the slashes (\) to go with the PHP syntax, but
	// to actually complete the query we need to get rid of them.
	$query = stripslashes($query);
	// Actually run the query
	$result = mysql_query($query) or die(mysql_error());
	$db_result = mysql_fetch_row($result);
	// Return how many fields we selected with our *
	$number_cols = mysql_num_fields($result);

	// $db_result[0] is the username field from the table
	// $db_result[1] is the password field from the table
	// This is true only if your first field in your database is the username
	// and the second is the password field.

If ($_POST["password"] == $db_result[1])
	{	//get cookie value
		$cookie_value=$_POST['username'];
		//set cookie
		setcookie("username","$cookie_value",time()+3600);
?>
<html>
<head>
<title> Login Successful</title>
</head>
<body>
<p style= 'color:blue'><h1>Login Successful</h1></p></br>
Click to visit <a href="first_test.php">main page</a>
</body>
</html>
<?php
		
}
else
{	
		echo "<html><head><title>Login Failed</title></head></html>";
		
		//Display ¡°Login was incorrect. Please try again¡±
		echo "<p style='color:red'><big>User name or password uncorrect, login failed</big></p></br>";
		echo "<br>Return to the <a href=\"Login page.php\">Login Page</a>";
		//Display HTML code for form
}
}
else
{
	//Display HTML code for form.  Make sure action=$_SERVER[PHP_SELF]& method=POST
	echo "<p style = 'color:blue'><big>Please Login:</big></p></br>
	<form action=\"$_SERVER[PHP_SELF]\" method=\"POST\">
	Username : <input type=\"text\" name=\"username\"></br>
	Password : <input type=\"password\" name = \"password\"></br>
	<input type=\"submit\" value=\"Login\" name=\"login\"></form>";
}
?>