<?php
// The isset() function returns true if a variable has a
// value
if (@isset($_GET[test_info]))
{
// No output has occurred so it's OK to have setcookie()
// function here. The time()+3600 means that this cookie
// will expire in one hour (3600 secs = 1 hour)
setcookie ("TestCookie","$_GET[test_info]",time()+3600);
echo "Now test your cookie<br>";
echo "<a href=\"cookie_test2.php\">cookie_test2.php</a>";
}
else
{
// The action=\"$_SERVER[PHP_SELF]\" will call cookie_test.php again, but
// when it calls it again, $_Get[test_info] will have a value
// and this part will not be executed.
echo "Enter your username:<br>
<form action=\"$_SERVER[PHP_SELF]\" method=\"Get\">
<input type=\"text\" name=\"test_info\">
<input type=\"submit\" value=\"Submit\"></form>";
}
?>