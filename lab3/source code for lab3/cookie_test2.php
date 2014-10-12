<?php

// Test to see if the cookie has been set correctly
if (isset($_COOKIE["TestCookie"]))
{
echo "The cookie is set<br>Here is the value: ";
// To get the value of our cookie we named TestCookie, we use
// the php array $_COOKIE[], in version after PHP4.1.0 $HTTP_COOKIES_VARS[] have stop using
// Notice the lack of "" around this echo statement!
echo $_COOKIE["TestCookie"];
echo "<br>Do you want to log out?<br>";
echo "<a href=\"cookie_test_logout.php\">Yes</a> | <a
href=\"$_SERVER[PHP_SELF]\">No</a>";
}
else
{
echo "the cookie is not set";
echo "<br>Return to the <a href=\"cookie_test.php\">Login page</a>";
}
?>