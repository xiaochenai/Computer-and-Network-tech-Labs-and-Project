<?php
function html_headers($title)
{
echo "<HTML><HEAD><TITLE>$title</TITLE>";
echo "</HEAD><BODY>";
	// Return 1 just in case you ever use this function
// in a conditional statement
return 1;
} 
?>