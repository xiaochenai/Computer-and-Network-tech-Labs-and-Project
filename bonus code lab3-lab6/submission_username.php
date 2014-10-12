<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<?php
//start the session
session_start();
//get the input
//check the enter box
if(@isset($_POST['name1']) || @isset($_POST['name2']) || @isset($_POST['name3']) || @isset($_POST['name4']))
{		
		//get the data and save it into session
		@$_SESSION[name][0] = $_POST['name1'];
		@$_SESSION[name][1] = $_POST['name2'];
		@$_SESSION[name][2] = $_POST['name3'];
		@$_SESSION[name][3] = $_POST['name4'];
		
		echo "<html><head><title>UserName List</title></head></html>";
		// print pout session
		echo "Hello, Welcome Back!"; print(@$_SESSION[name][0]); echo "</br>";
		echo "Hello, Welcome Back!"; print(@$_SESSION[name][1]); echo "</br>";
		echo "Hello, Welcome Back!"; print(@$_SESSION[name][2]); echo "</br>";
		echo "Hello, Welcome Back!"; print(@$_SESSION[name][3]); echo "</br>";
		
}
else
{	//if there is no user's input turn to form to get input
	echo"<form action=\"$_SERVER[PHP_SELF]\" method = \"POST\">
	Name 1 :<input type = 'text' name = 'name1'></br>
	Name 2 :<input type = 'text' name = 'name2'></br>
	Name 3 :<input type = 'text' name = 'name3'></br>
	Name 4 :<input type = 'text' name = 'name4'></br>
	<input type=\"submit\" value=\"Submit\"></form>";
}
echo "- - - - - - - - - - - - - - <br>";
echo "Sessions: <pre>";
print_r($_SESSION);
echo "</pre>";
echo "Your session ID: ";
print_r(session_id());


?>
</body>