<?php
// This cookie will expire 1 hour ago, effectively
// removing the cookie information
setcookie("TestCookie","",time()-3600);
echo "<html><head>
<meta name='viewport' content='width=device-width, initial-scale=1'/>
<body>
 You are now logged out
 <br>Return to the <a href=\"cookie_test.php\">Login page</a>
 <br>Return to the <a href=\"cookie_test2.php\">cookie test page</a></body></html>";
?>
?