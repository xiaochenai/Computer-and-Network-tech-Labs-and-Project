<?php
//view_cart.php
//--------------------------------------------------------------------------------
// This page displays the contents of the shopping cart to the user, and allows
//		him to update them. Also he selects his shipping and tax status here
//		before entering his billing information on checkout.php
//--------------------------------------------------------------------------------
//functions: 
// show_cart()
//		- function displays  the shopping cart with options for item removal and quantity updates
//		- also select shipping and tax status before placing the order
//
// show_empty_cart()
//		- display a message to the user that the shopping cart is empty
//
// state_in_out()
//		- return a dropdown menu which lets the user select between in-state
//			or out of state tax
//--------------------------------------------------------------------------------
//functions called:
// include_header(string title) - include the page header and shopping cart
// include_browse_menu() - include the browse options
// include_footer() - close the page and include my footer text
// remove_from_cart(int id) - remove the item from the cart. Only done on page refresh.
// get_number_cart_items() - return the number of items in the cart
// get_product_info(int id) - return array of all the product info associated with the id
// calculate_item_total(float price, int quantity) - return the float price*quantity for the given
// number_format(int num, int digits) - return the given number formatted to 'digits' decimal places
// get_shipping_dropdown() - return the dropdown for the types of available shipping
// updateTotals() - calculates and updates the subtotal, tax, shipping, and total
// updateCartQuantity(int item_num, int quantity_avail) - updates the cart and checks number requested against number available
//--------------------------------------------------------------------------------

require_once('./includes/mysql_connect.php');
require_once('./includes/mysql_functions.php');
require_once('./includes/functions.php');

include_header('My First CD Store.com - Shopping Cart');
print '<h3>Shopping Cart</h3>';


//if an item was removed from the cart, submit_remove will be set,
//so execute this block to remove the item from the cart
if(isset($_POST['submit_remove'])){
	$id = $_POST['id'];
	remove_from_cart($id);
	$qty = get_number_cart_items();
	//need javascript to update the display in the shopping cart header, because the header
	//was sent to the page before the removal was processed
	?>
	<script type="text/javascript">
		document.getElementById("cart_num_items").innerHTML = <?php print $qty; ?>;
	</script>
	<?php
}		

if(get_number_cart_items()>0)
	show_cart();
else
	show_empty_cart();

include_footer();

?>

<?php

function show_cart()
{
?>
	<!--Shopping cart very roughly modeled after BestBuy.com-->
	<table id="shopping_cart_display" cellpadding="4">
	<tr id="cart_headings"><td></td><td>Qty.</td><td colspan="2">Product</td><td>Item Price</td><td>Item Total</td></tr>
	<?php
	$subtotal = 0;
	foreach($_SESSION['cart'] as $item_number => $quantity)
	{	
		if($quantity > 0){
			$product = get_product_info($item_number);
			$item_total = calculate_item_total($product['price'], $quantity);
			//$subtotal += $item_total;
			
			//for each item, print a row with an option to remove the item, update the quantity, view the product, and prices
			print '<tr>
					<td>
						<form action="" method="post">
							<input type="hidden" name="id" value="'.$item_number.'" />
							<input type="hidden" name="submit_remove" value="true" />
							<input style="font-size: 70%" type="submit" value="remove" />
						</form>
					</td>
					<td>
						<input type="text" id="qty'.$item_number.'" value="'.$quantity.'" size="2" /><br />
						<form action="" method="post" onsubmit="return updateCartQuantity('.$item_number.', '.$product['quantity'].')">
							<input style="font-size: 70%" type="submit" value="Update" />
						</form>
					</td>
					<td><a href="./item.php?item='.$item_number.'"><img border="0" width="60" src="./display_image.php?item_number='.$item_number.'" /></a></td>
					<td><small>'.$product['title'].'</small><br /><b><a href="./item.php?item='.$item_number.'">'.$product['ISBN'].'</a></b></td>
					<td align="right">'.number_format($product['price'], 2).'</td>
					<td align="right">$<span id="item_'.$item_number.'_total">'.number_format($item_total, 2).'</span></td>
					</tr>'."\n";
		}
	}
	//$shipping=0;
	//$tax=0;
	//display a form which contains the subtotal, shipping, taxe, and total as well as a proceed to checkout button
	
	print '<form name="cart_form" action="./checkout.php" method="post" onsubmit="saveTotal()">';
	
	print '<tr><td colspan="2"></td><td colspan="4" align="center"><hr width="100%" /></td></tr>';
	print '<tr><td></td><td></td><td align="left" colspan="3">&nbsp;&nbsp;<b><i>Product Subtotal</i></b></td>
			<td align="right"><b>$<span id="subtotal">'.number_format($subtotal,2).'</span></b></td>
			</tr>';
			
	print '<tr><td></td><td></td><td align="left">&nbsp;&nbsp;<b><i>Shipping</i></b></td>
			<td colspan="2">'.get_shipping_dropdown().'</td>
			<td align="right">$<span id="shipping">'.@$shipping.'</span></td>
			</tr>';
			
	print '<tr><td></td><td></td><td align="left">&nbsp;&nbsp;<b><i>Tax</i></b></td>
			<td colspan="2">'.state_in_out().'</td>
			<td align="right">$<span id="tax">'.@$tax.'</span></td>
			</tr>';
			
	print '<tr><td colspan="2"></td><td colspan="4" align="center"><hr width="100%" /></td></tr>';
	print '<tr><td></td><td></td><td align="left">&nbsp;&nbsp;<b><i>TOTAL</i></b></td>
			<td colspan="2"></td>
			<td align="right"><b>$<span id="total"></span></b></td>
			</tr>';
	?>
	<tr><td colspan="5" align="right"><input type="submit" name="submit" value="Proceed to Checkout" /></td></tr>
	</table>
	<input type="hidden" name="total_price" id="total_price" value="" />
	</form>
	
<?php	
}


function show_empty_cart()
{
	print '<h3>There are no items in your shopping cart.</h3>';
}

//return dropdown menu for tax selection
function state_in_out()
{
	$return = '<select name="tax" id="tax_type" onchange="updateTotals()" >
			<option name="in_state" value="in_state">Alabama</option>
			<option name="out_state" value="out_state">Other</option>
			</select>';
	return $return;
	
}

?>