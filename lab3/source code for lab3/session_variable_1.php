<?php
// start the session
session_start();
// function seesion_register() has stop use after version PHP 4.2
//session_register(users_name);

// The trick we use to prevent us from making two 
// files (a .html and .php file)
if (@isset($_GET['name']))
{
@$_SESSION[users_name] = $_GET[name];
echo "Hello $_SESSION[users_name]<br>";
}
else // Print out the input form
{
echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"GET\">
<input type=\"text\" name=\"name\">
<br>
<input type=\"submit\" value=\"Submit\">
</form>";
}
// Print some information about the variable 
// $_SESSION
echo "- - - - - - - - - - - - - - <br>";
echo "Sessions: <pre>";
print_r($_SESSION);
echo "</pre>";
echo "Your session ID: ";
print_r(session_id());
?>