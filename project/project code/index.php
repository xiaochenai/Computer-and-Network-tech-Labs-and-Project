<?php
//index.php
//------------------------------------------------------------------------------------------
// This is the site's homepage. It displays a random selection of Books to the user.
//------------------------------------------------------------------------------------------
//functions called:
// include_login_header(title) - include the page header and shopping cart
// include_browse_menu() - include the browse options
// include_footer() - close the page and include my footer text
// get_random_product_infos(length) - get a random list of products of size length
// display_item_list(products) - display formatted table output for the products
//------------------------------------------------------------------------------------------

require_once('./includes/mysql_connect.php');
require_once('./includes/mysql_functions.php');
require_once('./includes/functions.php');

//include_login_header will display login form and cookie counter if there is
include_header('My First Book Store.com');
include_browse_menu();
print '<h2>Welcome to my first Book Store</h2>';

//set the number of items to be fetched and displayed
$length = 3;

//get the random selection of products
$products = get_random_product_infos($length);

//display the list to the page
display_item_list($products);


include_footer();

?>