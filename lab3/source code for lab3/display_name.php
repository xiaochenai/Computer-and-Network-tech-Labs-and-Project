<?php
session_start();
// print out the information stored in session
echo "Hello, Welcome Back Again!"; print(@$_SESSION[name][0]); echo "</br>";
echo "Hello, Welcome Back Again!"; print(@$_SESSION[name][1]); echo "</br>";
echo "Hello, Welcome Back Again!"; print(@$_SESSION[name][2]); echo "</br>";
echo "Hello, Welcome Back Again!"; print(@$_SESSION[name][3]); echo "</br>";
//print out session array	
echo "<br>- - - - - - - - - - - - - - <br>";
echo "Sessions: <pre>";
print_r($_SESSION);
echo "</pre>";
echo "Your session ID: ";
print_r(session_id());
?>