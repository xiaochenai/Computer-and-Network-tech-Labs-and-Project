<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<?php
// first test if the user have the cookie
if(@isset($_COOKIE['username']))
{
	echo "<html><head><title>Welcome back</title></head></html>";
	echo "<p><h1  style='color:red'>Welcome Back</h1></p>";
	echo $_COOKIE['username'];
}
else
{
echo "<head><title>Login required</title></head>";
echo "the cookie has not been set";
echo "<br>Return to the <a href=\"Login page.php\">Login page</a>";
}
?>
</html>