<?php
	$q=$_GET["q"];
	echo($q);
	echo "<br />";
	
	if ($q=="A")
	{
		setcookie("userA","$q",time()+3600);
		if (isset($_COOKIE["userA"]))
			{
				echo "Welcome " . $_COOKIE["userA"] . "!<br />";
			}
		else
				echo "Welcome friend!<br />";
	}
	else if ($q=="B")
	{
		setcookie("userB","$q",time()+3600);
		if (isset($_COOKIE["userB"]))
			{
				echo "Welcome " . $_COOKIE["userB"] . "!<br />";
			}
		else
				echo "Welcome friend!<br />";
	}
	else if ($q=="C")
	{
		setcookie("userC","$q",time()+3600);
		if (isset($_COOKIE["userC"]))
			{
				echo "Welcome " . $_COOKIE["userC"] . "!<br />";
			}
		else
				echo "Welcome friend!<br />";
	}
	else
	{
		echo("User information for ");
		echo($q);
		echo(" was not found.");
	}
?>