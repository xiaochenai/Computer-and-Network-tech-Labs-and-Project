<?php
//add_to_cart.php
//-----------------------------------------------------------------
// This page is called via AJAX to update the shopping cart when
//	a new item is added.
//
// It checks to make sure the provided quantity is valid, then
//	updates the cart with the new value
//
// Also prints (returns) the total number of items now in the 
//	cart to be updated in the pages header shopping cart
//-----------------------------------------------------------------
//functions called
//  get_number_cart_items() - returns the number of items in the cart
//-----------------------------------------------------------------

session_start();
include_once('./functions.php');

$id = $_GET['id'];
$qty = $_GET['qty'];
	
if (@strlen($id)>0 and @strlen($qty)>0)
{
	if(isset($_SESSION['cart'][$id]))
		$_SESSION['cart'][$id] += $qty;
	else
		$_SESSION['cart'][$id] = $qty;
}

print get_number_cart_items();

?>