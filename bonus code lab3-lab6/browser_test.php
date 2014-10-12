<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9'))
{ 
?>
<h1>strpos must have returned true</h1><center><b>You are using Internet Explorer 9</b></center>
<?php 
} 
else { 
?>
<h1>strpos must have returned false</h1><center><b>You are not using Internet Explorer 9</b></center>
<?php } ?>