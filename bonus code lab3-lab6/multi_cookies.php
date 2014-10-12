<?php
setcookie("userA","A",time()+3600);
setcookie("userB","B",time()+3600);
setcookie("userC","C",time()+3600);
if (isset($_COOKIE["userA"]))
{
	echo "Welcome " . $_COOKIE["userA"] . "!<br />";
}
else
	echo "Welcome friend!<br />";

if (isset($_COOKIE["userB"]))
{
	echo "Welcome " . $_COOKIE["userB"] . "!<br />";
}
else
	echo "Welcome friend!<br />";

if (isset($_COOKIE["userC"]))
{
	echo "Welcome " . $_COOKIE["userC"] . "!<br />";
}
else
	echo "Welcome friend!<br />";
?>