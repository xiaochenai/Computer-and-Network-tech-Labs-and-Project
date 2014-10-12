<?php
//logout.php
//------------------------------------------------------------------------------------------
// This page is used when user logout and kill the cookie that include the infomation of the
// user
//------------------------------------------------------------------------------------------
//functions called:
// include_footer() - close the page and include my footer text
//------------------------------------------------------------------------------------------
require_once('./includes/functions.php');
//destroy cookies
setcookie("username","",time()-3600);
setcookie("mail","",time()-3600);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
	    <link rel="shortcut icon"href="favicon.ico"/>
	    <style>a{TEXT-DECORATION:none}</style>
	    <title><?php print $page_title; ?></title>
	    <meta http-equiv="Refresh" content="10;URL=index.php" /> 
	</head>

	<body>

	<table width="700" height="38" cellspacing="5" >
	<tr>
		<td width="149" align="left">
			<div id="banner">
			<a href="./index.php">
				<!--Welcome to My First Book Store Site-->
				<h3>My First Book Store</h3>
			</a>
			</div>
		</td>
		<td width="487" align="right">
			<a href="./view_cart.php">
			<div id="cart">
				<image border="0" src="./images/cart.jpg"></image><span id="cart_num_items"><?php print get_number_cart_items().'</span>'; ?>
			</div>
			</a>
		</td>
	</tr>
	</table>
<?php
echo "<center>You are now logged out";
echo "<br>Return to the <a href=\"index.php\"><b>index page</b></a>";
echo "<br>Your page would direct to index page in 10 second";
include_footer();
?>