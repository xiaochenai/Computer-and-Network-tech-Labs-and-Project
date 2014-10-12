<?php
// Start the session and register the variables
session_start();
//this function has stop using afer PHP 4.2
//session_register(users_name);
echo "Hello, Again $_SESSION[users_name]";
echo "<br>";
// Print some information about the variable 
// $_SESSION
echo "- - - - - - - - - - - - - - <br>";
echo "Sessions: <pre>";
print_r($_SESSION);
echo "</pre>";
echo "Your session ID: ";
print_r(session_id());
?>