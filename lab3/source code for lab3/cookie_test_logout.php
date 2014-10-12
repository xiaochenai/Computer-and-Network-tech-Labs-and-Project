<?php
// This cookie will expire 1 hour ago, effectively
// removing the cookie information
setcookie("TestCookie","",time()-3600);
echo "You are now logged out";
echo "<br>Return to the <a href=\"cookie_test.php\">Login page</a>";
echo "<br>Return to the <a href=\"cookie_test2.php\">cookie test page</a>";
?>
?