<?php
// functions.php
// -------------------------------------------------------------------------
// This page provides several functions which fit into five categories
//		1) header/footer functions
//		2) display functions
//		3) shopping cart functions
//		4) dropdown menu functions
//		5) debug functions
// These functions are included in all pages, and are called as necessary
// -------------------------------------------------------------------------
// Functions:
//
//HEADER/FOOTER FUNCTIONS
// include_header($page_title, $keep_data_in_session=false)
//		- creates the header for each page
//		- page title is passed in as a variable
//		- $keep_data_in_session determines whether or not $_SESSION['data'] is kept
//			or destroyed when the page is loaded. Most of the pages want to destory it.
//			The feature is added so that order confirmation pages can be refreshed without
//			destroying the data. It is destroyed on the rest so that a user could not reaccess
//			an order page when it was not intended.
//		- this function also adds the shopping cart icon to the header
//    - display form for user to login and display number of times he visit
// 
// include_login_header($page_title, $keep_data_in_session=false)
//		- creates the header for each page
//		- page title is passed in as a variable
//		- $keep_data_in_session determines whether or not $_SESSION['data'] is kept
//			or destroyed when the page is loaded. Most of the pages want to destory it.
//			The feature is added so that order confirmation pages can be refreshed without
//			destroying the data. It is destroyed on the rest so that a user could not reaccess
//			an order page when it was not intended.
//		- this function also adds the shopping cart icon to the header
//    - display form for user to login and display number of times he visit
//    - this is called by index.php which is the main webpage and cookie counter increase
//      by 1 if the  user revisit the website
//
// include_footer()
//		- includes the footer for every page
//		- the footer includes a link to the admin page
// 
// include_browse_menu()
//		- includes the browse menu in a page
//		- this menu includes options to browse by title and Genre and provides a search bar
// 
//
//DISPLAY FUNCTIONS 
// display_item_list($products)
//		- takes input of an array of products. Each product in the array is an array of all
//			of the data associated with that particular item
//		- this function prints the table which displays the provided products
//
// get_availability_text($num)
//		- $num is the quantity available for an item
//		- $cutoff is the limit for when the item becomes "Low Availability"
//		- $num higher than the cutoff returns "In Stock"
//		- if quantity is 0, return is "Out of Stock"
//
// display_featured_item($product)
//		- when an item is displayed on it own page, this function is called to print the item's display
//		- $product is an array of all the data relevant to the product from the database
//
// add_remove_for($product)
//		- function returns the HTML for the status div with each product listed by display_item_list
//		- uses <div> with id=status{id#} where id# is the item_number of the product associated with this <div>
//
//
//SHOPPING CART FUNCTIONS
// add_to_cart($product_id)
//		- sets shopping cart in current session to include the given product id
//		- if already in cart, increments the number of copies
// 
// remove_from_cart($product_id)
//		- sets the quantity to 0 for the given product in the shopping cart
// 
// empty_cart()
//		- sets all cart quantities to 0
//
// set_cart_quantity($product_id, $quantity)
//		- set the quantity of a given product to the specified qantity
// 
// get_number_cart_items()
//		- return the total number of items in the cart
// 
// item_in_cart($product_id)
//		- return a boolean of whether the given item is in the cart or not
// 
// get_cart_quantity_for($product_id)
//		- return the cart quantity for the given product
// 
// calculate_item_total($price, $quantity)
//		- return the total price for a given price and quantity
//		- multiply price * quantity and return float
//
//
//DROPDOWN MENU FUNCTIONS
// get_shipping_dropdown($type="")
//		- function returns a dropdown menu for a shipping selection with preselect option
//		- onchange event calls javascript function updateShipping() from clientSide.js
//
// getMonthDropDown($m='')
//		- returns a simple 12 digit month selection dropdown menu with preselect option
//		- onchange event calls javascript function verifyMonth() from creditCard.js
//
// getYearDropDown($y='')
//		- returns a year selection dropdown menu with preselect option
//		- $length variable sets the number of years in the list
//		- first year displayed is the current year and displays the next $length-1 years
//
// getStateDropDown($s='', $enabled=true)
//		- returns a state selection dropdown menu with a preselect option
//		- $enabled adds the option to print the menu, but disabled. This is not used for this website
//		- Alabama is not on the state list. This is because of the in-state/out-of-state tax requirements.
//			The user chooses his tax status on the view_cart.php page. If he selects Alabama, his state is
//			set and cannot be changed on the billing page. If he chooses out of state, he can choose to
//			bill and ship his purchase to any state other than Alabama.
// 
// ****************************************************
//	the notes of my function***************************
//*****************************************************
//set_current_cookie($cookie_name,$cookie_mail)
//		- no return
//		- $cookie_name and $ cookie_mail is the cookie stored in the HD
//		- the function is used to set the current cookie
//DEBUG FUNCTIONS
// disp_r($text)
//		- this function is essentially the same as PHPs print_r.
//		- it adds the <pre> tags so that data send to this function is
//			printed to the screen in a authorted display
//*****************************************************************************

//----------------------------header/footer-----------------------------------
function set_current_cookie($cookie_name,$cookie_mail)
{
	setcookie("username",$cookie_name);
	setcookie("mail",$cookie_mail);
}	
function include_header($page_title, $keep_data_in_session=false)
{
	session_start();
	
	//
	if(!$keep_data_in_session){
		//
	}
	
	$browserid = session_id();

	/**Browser-based Cookie*/
	//Connect to the database
  $dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
  
  mysql_select_db("book_store",$dbcnx) or die("Can not select database");
  
  if (isset($_COOKIE['BrowserCookie'])) {
      $counter = $_COOKIE['BrowserCookie']+1;      
      //update the counter in the database
      $sql="UPDATE counter SET counter= $counter where id = '$browserid'";
      $rs=mysql_query($sql) or die(mysql_error());
  } 
  else {
      //first time of visit
      $counter = 1;
      //save counter in the database
      $sql="INSERT INTO counter (id,counter) VALUES ('$browserid','1')";
      $sql1="UPDATE counter SET counter= 1 where id = '$browserid'";
      $rs=mysql_query($sql) or mysql_query($sql1);
  }
  //update the counter in the cookie
  setcookie("BrowserCookie", $counter,time()+60);
  echo "Welcome !";
  echo "You are :";
  //array_push($_COOKIE['name'],"zhu");
  //************************************************************
  //the own part************************************************
  //************************************************************
  if(@isset($_COOKIE['name']))
	{	
		
		// display the menu of the loged in user who has cookie in broswer
		// get the cookie array
		$name = $_COOKIE['name'];
		echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">";
		echo"<select name='cookies' >";
		foreach($_COOKIE['name'] as $k => $value)
		{
			echo "<option value = \"$k\">";
			echo $value;
			echo "</option>";
		}
		echo "<input type=\"submit\" value=\"Go\">";
		echo"</select>";
		echo "</form>";
	
	}
	
	if(@isset($_POST['cookies']))
	{
	  //echo "WELCOME ";
	  // if the user have chose his/her name in menu, we will set another current cookie for him/her
	  $index =  @$_POST['cookies'];
	  $name = @$_COOKIE['name'][$index];
	  $mail = @$_COOKIE['mailarray'][$index];

	  if($index != '')
	  {
	  
			//set current cookie
			setcookie ("username", "$name");
			setcookie ("mail", "$mail");
	  }
	}

  //set_current_cookie(@$name,$mail);
  //echo $_COOKIE['BrowserCookie']; 
	
  /*User-based Cookie*/
	// Connect to the database
  $dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
  // Choose which database you would use
  mysql_select_db("book_store",$dbcnx) or die("Can not select database");
  //get cookie value
  $i=0;
  $uname=@$_COOKIE["username"];
  //find the username in database
  @$sql="SELECT * FROM customers WHERE last_name=\"$name\"";
  $rs=mysql_query($sql);
  $num= mysql_num_rows($rs);
  // Fectch the row of the table
  $row = mysql_fetch_row($rs);
 
  //if we have not found the user, we allow the user to login
  if(!($num>0)){
    // isset function here to make sure that the form is submited
	if(@isset($_COOKIE['username']) && !(@isset($_POST['cookies'])))
	{	
		echo "$_COOKIE[username] ";
		echo "</br>";
		echo "<a href=\"logout.php\">Log Out</a> | <a href=\"history.php\">View History</a>";
	}
    if(@isset($_POST['name']))
    {	
	
      // find user in database by using lastname and email 
      $query = "Select * from customers where last_name=\"$_POST[name]\" AND email=\"$_POST[mail]\" ";
      // Run this query
      //$query = stripslashes($query);
      $result = mysql_query($query) or die(mysql_error());
      // Fectch the row of the table
      $num_cols = mysql_num_rows($result);
      $row = mysql_fetch_row($result);
      if (($num_cols>0))
      {
		
        // Set cookie and choose to go to which page
		$usname = count(@$_COOKIE['name'])+1;
		$mailn = count(@$_COOKIE['mailarray'])+1;
		/*
		array_push($_COOKIE['name'],"$_POST[name]");
		array_push($_COOKIE['mail'],"$_POST[mail]");
		foreach($_COOKIE['name'] as $k => $value)
		{
			setcookie("name[$k]","$value");
		}
		foreach($_COOKIE['mail'] as $k => $value)
		{
			setcookie("mail[$k]","$value");
		}*/
		//**************************************************************
		//the own part  ************************************************
		//**************************************************************
		//set the current if user use the username and email to login
		setcookie ("username", "$_POST[name]");
        setcookie ("mail", "$_POST[mail]");
		// if the cookie array is null then we use setcookie function to set a cookie for user
		if(count(@$_COOKIE['name']) == 0)
		{
			setcookie ("name[$usname]" , "$_POST[name]",time()+315360000);
			setcookie ("mailarray[$mailn]", "$_POST[mail]",time()+315360000);
			$flag =1;
		}
		// if the cookie array is not null then we use another way to setcookie
		else
		{	// first we judge if the user have logged in in this computer
			foreach($_COOKIE['mailarray'] as $k => $value)
			{
				if(($value == $_POST['mail']))
				{
					if($_COOKIE['name'][$k] == $_POST['name'])
					{	
						//make sure we do not log repeat
						echo "You have been login in this computer, please choose in the menu";
						echo "</br>";
						// if the mail and user name all have been find in cookie we will stop user to login again
						$flag = 0;
					}
				}
				else
				{
					$flag = 1;
				}

			}
			//*********************************************************************
			// the own part		   ************************************************
			//*********************************************************************
			// if the user have not login in this computer, we will use a current array and use the push method to add new user in the array
			// the advantage of this way is that we do not need to care about how many cookie we have now as well as the index of the array
			if($flag)
			{	// push new data in the array
				array_push($_COOKIE['name'],"$_POST[name]");
				array_push($_COOKIE['mailarray'],"$_POST[mail]");
			}
			// we go though all of the cookie array and setcookie
			foreach($_COOKIE['name'] as $k => $value)
			{
				setcookie("name[$k]","$value",time()+315360000);
			}
			foreach($_COOKIE['mailarray'] as $k => $value)
			{
				setcookie("mailarray[$k]","$value",time()+315360000);
			}
		}
		//array_push($_COOKIE['name'],"$_POST[name]");
		if(@$flag){
			echo "Welcome back, ";
			echo $_POST['name'];
			echo "!             ";
			//display the number of times he visit our website
			echo "Cookie Counter:";
			echo $row[13]+1;
			echo "!             ";
			$query = "UPDATE customers SET counter=counter+1 where last_name=\"$_POST[name]\"";
			$result = mysql_query($query) or die(mysql_error());
			echo "<a href=\"logout.php\">Log Out</a> | <a href=\"history.php\">View History</a>";
			echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
				   Lastname: 
				  <input type=\"text\" name=\"name\">
				   Email:
				  <input type=\"text\" name=\"mail\">
				  <input type=\"submit\" value=\"Submit\"></form>";
			}
       }
     // If user does not exist in the database, ask user to input again
     else
     {
        echo "Do not have that customer or the email is wrong<br>";
        echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
               Lastname: 
              <input type=\"text\" name=\"name\">
               Email:
              <input type=\"text\" name=\"mail\">
              <input type=\"submit\" value=\"Submit\"></form>";
      }
    }
    // If there is not submited the form, set the form for submiting
    else
    {
      echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
              Lastname: 
            <input type=\"text\" name=\"name\">
              Email:
            <input type=\"text\" name=\"mail\">
            <input type=\"submit\" value=\"Submit\"></form>";
     }
  }
  //if we got user inauthorion from the cookie
  else{
	
     echo "Welcome back, ";
     echo $name;
     echo "!             ";
	 echo " $mail ";
     //display the number of times he visit our website
     echo "Cookie Counter:";
     echo $row[13]+1;
     echo "!             ";
	 $query = "UPDATE customers SET counter=counter+1 WHERE last_name=\"$name\"";
     $result = mysql_query($query) or die(mysql_error());
     echo "<a href=\"logout.php\">Log Out</a> | <a href=\"history.php\">View History</a>";
	 echo "</br>";
	 echo "if you are not $name, please log out";
	 echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
               Lastname: 
              <input type=\"text\" name=\"name\">
               Email:
              <input type=\"text\" name=\"mail\">
              <input type=\"submit\" value=\"Submit\"></form>";
  }
  //display the times of visit
  //echo "<br/>";
  echo "The Browser cookie counter is :";
  echo $counter;

	require_once('./includes/constants.php');
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
	    <title><?php print $page_title; ?></title>
		<script type="text/javascript" src="./includes/clientSide.js"></script> 
		<script type="text/javascript" src="./includes/checkout.js"></script> 
		<script type="text/javascript" src="./includes/creditCard.js"></script> 
	</head>

	<body onload="calculateInitialTotals()">

	<table cellspacing="5" width="500px">
	<tr>
		<td align="left">
			<div id="banner">
			<a href="./index_again.php">
				<!--Welcome to my<br />My Book Store Site-->
				<h3>My Book Store</h3>
			</a>
			</div>
		</td>
		<td align="right">
			<a href="./view_cart.php">
			<div id="cart">
				<image border="0" src="./images/cart.jpg"></image><span id="cart_num_items"><?php print get_number_cart_items().'</span> items'; ?>
			</div>
			</a>
		</td>
	</tr>
	</table>
	

<?php
}
function include_login_header($page_title, $keep_data_in_session=false)
{
	 session_start();
	////
	if(!$keep_data_in_session){
		////
	}
	
	$browserid = session_id();
	
	/**Browser-based Cookie*/
	//Connect to the database
  $dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
  
  mysql_select_db("book_store",$dbcnx) or die("Can not select database");
  
  if (isset($_COOKIE['BrowserCookie'])) {
      $counter = $_COOKIE['BrowserCookie']+1;      
      //update the counter in the database
      $sql="UPDATE counter SET counter= $counter where id = '$browserid'";
      $rs=mysql_query($sql) or die(mysql_error());
  } 
  else {
      //first time of visit
      $counter = 1;
      //save counter in the database
      $sql="INSERT INTO counter (id,counter) VALUES ('$browserid','1')";
      $sql1="UPDATE counter SET counter= 1 where id = '$browserid'";
      $rs=mysql_query($sql) or mysql_query($sql1);
  }
  //update the counter in the cookie
  setcookie("BrowserCookie", $counter,time()+60);
  
  //echo $_COOKIE['BrowserCookie'];
    
  /*User-based Cookie*/
	// Connect to the database
  $dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect to the database server.");
  // Choose which database you would use
  mysql_select_db("book_store",$dbcnx) or die("Can not select database");
  //get cookie value
  $uname=@$_COOKIE["username"];
  //find the username in database
  $sql="SELECT * FROM customers WHERE last_name=\"$uname\"";
  $rs=mysql_query($sql);
  $num= mysql_num_rows($rs);
  // Fectch the row of the table
  $row = mysql_fetch_row($rs);
  //if we have not found the user, we allow the user to login
  if(!($num>0)){
    // isset function here to make sure that the form is submited
    if(@isset($_POST[name]))
    {
      // find user in database by using lastname and email
      $query = "Select * from customers where last_name=\"$_POST[name]\" AND email=\"$_POST[mail]\" ";
      // Run this query
      //$query = stripslashes($query);
      $result = mysql_query($query) or die(mysql_error());
      // Fectch the row of the table
      $num_cols = mysql_num_rows($result);
      $row = mysql_fetch_row($result);
      if (($num_cols>0))
      {
        // Set cookie and choose to go to which page
        setcookie ("username", "$_POST[name]");
        setcookie ("mail", "$_POST[mail]");
        echo "Welcome back, ";
        echo $_POST['name'];
        echo "!             ";
        //display the number of times he visit our website, and increase by 1
        echo "Cookie Counter:";
        echo $row[13]+1;
        echo "!             ";
        $query = "UPDATE customers SET counter=counter+1 where last_name=\"$_POST[name]\"";
        $result = mysql_query($query) or die(mysql_error());
        echo "<a href=\"logout.php\">Log Out</a> | <a href=\"history.php\">View History</a>";
		echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
               Lastname: 
              <input type=\"text\" name=\"name\">
               Email:
              <input type=\"text\" name=\"mail\">
              <input type=\"submit\" value=\"Submit\"></form>";
       }
     // If user does not exist in the database, ask user to input again
     else
     {
        echo "Do not have that customer or the email is wrong<br>";
        echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
               Lastname: 
              <input type=\"text\" name=\"name\">
               Email:
              <input type=\"text\" name=\"mail\">
              <input type=\"submit\" value=\"Submit\"></form>";
      }
    }
    // If there is not submited the form, set the form for submiting
    else
    {
      echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"Post\">
              Lastname: 
            <input type=\"text\" name=\"name\">
              Email:
            <input type=\"text\" name=\"mail\">
            <input type=\"submit\" value=\"Submit\"></form>";
     }
  }
  //if we got user inauthorion from the cookie
  else{
     echo "Welcome back, ";
     echo $_COOKIE["username"];
     echo "!             ";
     //display the number of times he visit our website, and increase by 1
     echo "Cookie Counter:";
     echo $row[13]+1;
     echo "!             ";
     $query = "UPDATE customers SET counter=counter+1 WHERE last_name=\"$uname\"";
     $result = mysql_query($query) or die(mysql_error());
     echo "<a href=\"logout.php\">Log Out</a> | <a href=\"history.php\">View History</a>";
  }
  //display the times of visit
  //echo "$browserid<br/>";
  echo "The Browser cookie counter is :";
  echo $counter;

	require_once('./includes/constants.php');
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
	    <title><?php print $page_title; ?></title>
		<script type="text/javascript" src="./includes/clientSide.js"></script> 
		<script type="text/javascript" src="./includes/checkout.js"></script> 
		<script type="text/javascript" src="./includes/creditCard.js"></script> 
	</head>

	<body onload="calculateInitialTotals()">

	<table cellspacing="5" width="500px">
	<tr>
		<td align="left">
			<div id="banner">
			<a href="./index_again.php">
				<!--Welcome to my<br />My Book Store Site-->
				<h3>My Book Store</h3>
			</a>
			</div>
		</td>
		<td align="right">
			<a href="./view_cart.php">
			<div id="cart">
				<image border="0" src="./images/cart.jpg"></image><span id="cart_num_items"><?php print get_number_cart_items().'</span> items'; ?>
			</div>
			</a>
		</td>
	</tr>
	</table>
	

<?php
}

function include_footer()
{
?>
<hr size="1" />
	<table width="500"><tr><td>
	<table align="center" cellpadding="10"><tr><td><small><b>My Book Store</b></small></td></tr></table>
	</td></tr></table>
	</body>
	</html>
<?php
}


function include_browse_menu()
{
	?>
	<table cellpadding="5">
		<tr>
			<td>Browse by:</td><td><a href="./browse.php?list=author">author</a></td>
			<td><a href="./browse.php?list=genre">Genre</a></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right">
				<form action="./search.php" method="get">
					<select name="field">
						<option value="ISBN">ISBN</option>
						<option value="title">title</option>
						<option value="Publisher">Publisher</option>
						<option value="author">author</option>
					</select>
					<input type="text" size="15" name="search_text" />
					<input type="submit" value="Search" />
				</form>
			</td>
		</tr>
	</table>
	<?php
}

//------------------------dipslay functions----------------------------------------


function display_item_list($products)
{
	//*****************************************************************
	//change image border color [6]
	//http://www.boutell.com/newfaq/creating/imagebordercolor.html
	//*****************************************************************
	
	print '<table cellpadding="5">
			<tr><td><b>Books</b></td><td><b>Availability</b></td><td><b>Price</b></td></tr>';

	foreach($products as $id => $product)
	{
		print '
		<tr><td>
				<table>
				<tr>
				<td><a href="./item.php?item='.$id.'"><img border="1" style="border-color: black;" width="80" src="./display_image.php?item_number='.$id.'" /></a></td>
				<td>
					<p>genre: <a href="./browse.php?type=genre&value='.$product['genre'].'">'.$product['genre'].'</a></p>
					<p>ISBN: <a href="./item.php?item='.$id.'"><b>'.$product['ISBN'].'</b></a></p>
					<p>Publisher: <a href="./browse.php?type=Publisher&value='.$product['Publisher'].'">'.$product['Publisher'].'</a></p>
					<p>author: <a href="./browse.php?type=author&value='.$product['author'].'">'.$product['author'].'</a></p>
				</td>
				</tr>
				</table>
				</td>
				<td>'.get_availability_text($product['quantity']).'</td>';
				
		print   add_remove_for($product);
		print '</tr>';
	}

	print '</table>';
}

function get_availability_text($num)
{
	$cutoff = 5;
	if($num > $cutoff){
		return "In Stock";
	}elseif($num > 0){
		return "Low Availability";
	}else{
		return "Out of Stock";
	}
}

function display_featured_item($product)
{
	$id = $product['item_number'];
	print '<table cellpadding="15">
			<tr>
				<td><img width="128" src="./display_image.php?item_number='.$id.'" /></td>
				<td>
					<p><a href="./browse.php?type=genre&value='.$product['genre'].'">'.$product['genre'].'</a><br />
					<b>'.$product['title'].'</b></p>
				</td>';
	print '<td>'.get_availability_text($product['quantity']).'</td>';
	print   add_remove_for($product);
	print 	'</tr>
			<tr>
				<td></td>
				<td>title: '.$product['title'].'<br></td>
				<td>Price: '.$product['price'].'<br></td>
				<td>author: <a href="./browse.php?type=author&value='.$product['author'].'">'.$product['author'].'</a>
				</td></tr>
			<tr><td></td><td colspan="3" width="550">'.$product['Publisher'].'</td></tr>
			</table>';
}

function add_remove_for($product)
{
	$id = $product['item_number'];
	$return = '<td>$'.number_format($product['price'],2).'<br />';
	if(item_in_cart($id))
	{
		$return .= '<div id="status'.$id.'">';
		$return .= get_cart_quantity_for($id).' item(s) in <a href="./view_cart.php">Shopping Cart</a><br />';
		$return .= '<form name="form'.$id.'" method="post" action="'.$_SERVER['PHP_SELF'].'" onsubmit="return removeFromCart('.$id.')"><input type="hidden" name="num_available" id="num_available" value="'.$product['quantity'].'" /><input type="submit" value="Remove from Cart" /></form>';
		$return .= '</div>';
	}
	elseif($product['quantity']==0)
	{
		$return .= '<div id="status'.$id.'"></div>';
	}
	else
	{
		$return .= '<div id="status'.$id.'">';
		$return .= '<form name="form'.$id.'" method="post" action="'.$_SERVER['PHP_SELF'].'" onsubmit="return addToCart('.$id.', '.$product['quantity'].')">		
				<input type="text" id="qty'.$id.'" size="4" value="1" />				
				<input type="submit" value="Add to Cart" /></form>';
		$return .= '</div>';
	}
	$return .= '</td>';
	
	return $return;
}


//-------------------------shopping cart functions---------------------------

function add_to_cart($product_id)
{
	if(isset($_SESSION['cart'][$product_id]))
		$_SESSION['cart'][$product_id]++;
	else
		$_SESSION['cart'][$product_id] = 1;
}

function remove_from_cart($product_id)
{
	if(isset($_SESSION['cart'][$product_id]))
		$_SESSION['cart'][$product_id] = 0;
}

function empty_cart()
{
	foreach($_SESSION['cart'] as $item_number => $quantity)
	{
		remove_from_cart($item_number);
	}
}

function set_cart_quantity($product_id, $quantity)
{
	$_SESSION['cart'][$product_id] = $quantity;
}

function get_number_cart_items()
{
	$items = 0;
	if(@$_SESSION['cart'] != null)
	{
		foreach($_SESSION['cart'] as $product)
		{
			$items += $product;
		}
	}	
	return $items;
}

function item_in_cart($product_id)
{
	if(isset($_SESSION['cart'][$product_id]) and $_SESSION['cart'][$product_id] != 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function get_cart_quantity_for($product_id)
{
	if(isset($_SESSION['cart'][$product_id]) and $_SESSION['cart'][$product_id] != 0)
	{
		return $_SESSION['cart'][$product_id];
	}
	else{
		return 0;
	}
}

function calculate_item_total($price, $quantity)
{
	return $price*$quantity;
}

//-----------------------drop down menus--------------------------------------

function get_shipping_dropdown($type="")
{
	$return = '<select name="shipping" id="shipping_type" onchange="updateTotals()" >
			<option value="ground" '; if($type=='ground') $return .= 'selected="selected" '; $return .= '>Ground</option>
			<option value="two_day" '; if($type=='two_day') $return .= 'selected="selected" '; $return .= '>2 Days</option>
			<option value="overnight" '; if($type=='overnight') $return .= 'selected="selected" '; $return .= '>Overnight</option>
				</select>';
	return $return;
}

function getMonthDropDown($m='')
{
	$return = '<select name="month" id="month" onchange="verifyMonth()" >
			<option value="01" '; if($m=='01') $return .= 'selected="selected"'; $return .= '>01</option>
			<option value="02" '; if($m=='02') $return .= 'selected="selected"'; $return .= '>02</option>
			<option value="03" '; if($m=='03') $return .= 'selected="selected"'; $return .= '>03</option>
			<option value="04" '; if($m=='04') $return .= 'selected="selected"'; $return .= '>04</option>
			<option value="05" '; if($m=='05') $return .= 'selected="selected"'; $return .= '>05</option>
			<option value="06" '; if($m=='06') $return .= 'selected="selected"'; $return .= '>06</option>
			<option value="07" '; if($m=='07') $return .= 'selected="selected"'; $return .= '>07</option>
			<option value="08" '; if($m=='08') $return .= 'selected="selected"'; $return .= '>08</option>
			<option value="09" '; if($m=='09') $return .= 'selected="selected"'; $return .= '>09</option>
			<option value="10" '; if($m=='10') $return .= 'selected="selected"'; $return .= '>10</option>
			<option value="11" '; if($m=='11') $return .= 'selected="selected"'; $return .= '>11</option>
			<option value="12" '; if($m=='12') $return .= 'selected="selected"'; $return .= '>12</option>
			</select>';
	return $return;
}

function getYearDropDown($y='')
{
	$length = 10;
	$this_year = date('Y');
	
	$return = '<select name="year" id="year" onchange="verifyExpiration()" >';
	for($year=$this_year; $year<$this_year+$length; $year++){
		$return .= '<option value="'.$year.'" '; if($y==$year) $return .= 'selected="selected"'; $return .= '>'.$year.'</option>';
	}
	$return .= '</select>';
	return $return;
}

function getStateDropDown($s='', $enabled=true)
{
	//excludes Alabama, because of state tax requirement
	
	/*<option value="" '; if($s=='') $return .= 'selected="selected"'; $return .= '>N/A</option>
	<option value="AL" '; if($s=='AL') $return .= 'selected="selected"'; $return .= '>Alabama</option>*/
			
	$return = '<select name="state" id="state" onchange=\'stateValidator()\' size="1" '; if(!$enabled) $return .= 'disabled="disabled"'; $return.= '>
			<option value="AL" '; if($s=='AL') $return .= 'selected="selected"'; $return .= '>Alabama</option>
			<option value="AK" '; if($s=='AK') $return .= 'selected="selected"'; $return .= '>Alaska</option>
			<option value="AZ" '; if($s=='AZ') $return .= 'selected="selected"'; $return .= '>Arizona</option>
			<option value="AR" '; if($s=='AR') $return .= 'selected="selected"'; $return .= '>Arkansas</option>
			<option value="CA" '; if($s=='CA') $return .= 'selected="selected"'; $return .= '>California</option>
			<option value="CO" '; if($s=='CO') $return .= 'selected="selected"'; $return .= '>Colorado</option>
			<option value="CT" '; if($s=='CT') $return .= 'selected="selected"'; $return .= '>Connecticut</option>
			<option value="DE" '; if($s=='DE') $return .= 'selected="selected"'; $return .= '>Delaware</option>
			<option value="DC" '; if($s=='DC') $return .= 'selected="selected"'; $return .= '>Dist of Columbia</option>
			<option value="FL" '; if($s=='FL') $return .= 'selected="selected"'; $return .= '>Florida</option>
			<option value="GA" '; if($s=='GA') $return .= 'selected="selected"'; $return .= '>Georgia</option>
			<option value="HI" '; if($s=='HI') $return .= 'selected="selected"'; $return .= '>Hawaii</option>
			<option value="ID" '; if($s=='ID') $return .= 'selected="selected"'; $return .= '>Idaho</option>
			<option value="IL" '; if($s=='IL') $return .= 'selected="selected"'; $return .= '>Illinois</option>
			<option value="IN" '; if($s=='IN') $return .= 'selected="selected"'; $return .= '>Indiana</option>
			<option value="IA" '; if($s=='IA') $return .= 'selected="selected"'; $return .= '>Iowa</option>
			<option value="KS" '; if($s=='KS') $return .= 'selected="selected"'; $return .= '>Kansas</option>
			<option value="KY" '; if($s=='KY') $return .= 'selected="selected"'; $return .= '>Kentucky</option>
			<option value="LA" '; if($s=='LA') $return .= 'selected="selected"'; $return .= '>Louisiana</option>
			<option value="ME" '; if($s=='ME') $return .= 'selected="selected"'; $return .= '>Maine</option>
			<option value="MD" '; if($s=='MD') $return .= 'selected="selected"'; $return .= '>Maryland</option>
			<option value="MA" '; if($s=='MA') $return .= 'selected="selected"'; $return .= '>Massachusetts</option>
			<option value="MI" '; if($s=='MI') $return .= 'selected="selected"'; $return .= '>Michigan</option>
			<option value="MN" '; if($s=='MN') $return .= 'selected="selected"'; $return .= '>Minnesota</option>
			<option value="MS" '; if($s=='MS') $return .= 'selected="selected"'; $return .= '>Mississippi</option>
			<option value="MO" '; if($s=='MO') $return .= 'selected="selected"'; $return .= '>Missouri</option>
			<option value="MT" '; if($s=='MT') $return .= 'selected="selected"'; $return .= '>Montana</option>
			<option value="NE" '; if($s=='NE') $return .= 'selected="selected"'; $return .= '>Nebraska</option>
			<option value="NV" '; if($s=='NV') $return .= 'selected="selected"'; $return .= '>Nevada</option>
			<option value="NH" '; if($s=='NH') $return .= 'selected="selected"'; $return .= '>New Hampshire</option>
			<option value="NJ" '; if($s=='NJ') $return .= 'selected="selected"'; $return .= '>New Jersey</option>
			<option value="NM" '; if($s=='NM') $return .= 'selected="selected"'; $return .= '>New Mexico</option>
			<option value="NY" '; if($s=='NY') $return .= 'selected="selected"'; $return .= '>New York</option>
			<option value="NC" '; if($s=='NC') $return .= 'selected="selected"'; $return .= '>North Carolina</option>
			<option value="ND" '; if($s=='ND') $return .= 'selected="selected"'; $return .= '>North Dakota</option>
			<option value="OH" '; if($s=='OH') $return .= 'selected="selected"'; $return .= '>Ohio</option>
			<option value="OK" '; if($s=='OK') $return .= 'selected="selected"'; $return .= '>Oklahoma</option>
			<option value="OR" '; if($s=='OR') $return .= 'selected="selected"'; $return .= '>Oregon</option>
			<option value="PA" '; if($s=='PA') $return .= 'selected="selected"'; $return .= '>Pennsylvania</option>
			<option value="RI" '; if($s=='RI') $return .= 'selected="selected"'; $return .= '>Rhode Island</option>
			<option value="SC" '; if($s=='SC') $return .= 'selected="selected"'; $return .= '>South Carolina</option>
			<option value="SD" '; if($s=='SD') $return .= 'selected="selected"'; $return .= '>South Dakota</option>
			<option value="TN" '; if($s=='IN') $return .= 'selected="selected"'; $return .= '>Tennessee</option>
			<option value="TX" '; if($s=='TX') $return .= 'selected="selected"'; $return .= '>Texas</option>
			<option value="UT" '; if($s=='UT') $return .= 'selected="selected"'; $return .= '>Utah</option>
			<option value="VT" '; if($s=='VT') $return .= 'selected="selected"'; $return .= '>Vermont</option>
			<option value="VA" '; if($s=='VA') $return .= 'selected="selected"'; $return .= '>Virginia</option>
			<option value="WA" '; if($s=='WA') $return .= 'selected="selected"'; $return .= '>Washington</option>
			<option value="WV" '; if($s=='WV') $return .= 'selected="selected"'; $return .= '>West Virginia</option>
			<option value="WI" '; if($s=='WI') $return .= 'selected="selected"'; $return .= '>Wisconsin</option>
			<option value="WY" '; if($s=='WY') $return .= 'selected="selected"'; $return .= '>Wyoming</option>
			</select>';	
	return $return;
}

//------------------------debug functions----------------------------------------
function disp_r($text)
{
	print '<pre>';
	print_r($text);
	print '</pre>';
}
?>