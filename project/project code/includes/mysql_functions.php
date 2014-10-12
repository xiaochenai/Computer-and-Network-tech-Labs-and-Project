<?php
//mysql_functions.php
//-----------------------------------------------------------------
// This page provides functions which rely on queries of the mysql database
//-----------------------------------------------------------------
//Functions:
//
// get_product_info($item_number)
//		- returns an array of all the info relevant to the supplied $item_number
//
// get_all_product_infos($start=-1, $length=-1, $type="", $value="")
//		- returns as array of the products information for all of the products meeting
//			the given requirements
//		- $start, $length INT used for selecting a limited portion of items
//			ex) used for selecting the first 10, then the next 10, etc.
//		- $type, $value used for searching
//			ex) $type="artist" $value="Jack Johnson" --> function will return all items
//				where the artist is Jack Johnson
//		
// get_random_product_infos($limit=1)
//		- referenced: http://www.petefreitag.com/item/466.cfm
//		- returns an array of the product information for a random selection of products
//		- $limit INT selects the number of items to be selected randomly and returned
//
// get_all_options($type)
//		- returns a unique array of all of the values in the database associated with a given column
//		- $type STRING for the column to return
//
// get_orders()
//		- returns an array of all of the orders and their data in the orders table
//
// get_customer($customer_id)
//		- returns all of the data associated with the provided $customer_id
//
//-----------------------------------------------------------------

function get_product_info($item_number)
{
	$query = "SELECT item_number, ISBN, title, price, quantity, genre, image, author, Publisher FROM book_store WHERE item_number=$item_number";
	$result = @mysql_query($query);
	if($result)
	{
		$row = @mysql_fetch_assoc($result);
		$return['item_number'] = $item_number;
		$return['ISBN'] = $row['ISBN'];
		$return['title'] = $row['title'];
		$return['price'] = $row['price'];
		$return['quantity'] = $row['quantity'];
		$return['genre'] = $row['genre'];
		$return['image'] = $row['image'];
		$return['author'] = $row['author'];
		$return ['Publisher'] = $row['Publisher'];

		return $return;
	}
	else
		return false;	
}

function get_all_product_infos($start=-1, $length=-1, $type="", $value="")
{
	//if start or length == -1, then no limit
	//otherwise, limit to start and length
	if($start != -1 and $length != -1){
		$limit_clause = "LIMIT $start, $length";
	}else{
		$limit_clause = "";
	}
	
	//if type and value are set, limit query by the value for the given type
	if($type!="" and $value!=""){
		$where_clause = "WHERE $type LIKE '%$value%'";
	}else{
		$where_clause = "";
	}
	
	$query = "SELECT item_number FROM book_store $where_clause $limit_clause";
	$result = @mysql_query($query);
	if($result)
	{
		while($row = @mysql_fetch_assoc($result))
		{
			$return[$row['item_number']] = get_product_info($row['item_number']);
		}
		return $return;
	}
	else
	{
		return false;
	}
}

function get_random_product_infos($limit=1)
{
	$query = "SELECT item_number FROM book_store ORDER BY RAND() LIMIT $limit";
	$result = @mysql_query($query);
	if($result)
	{
		while($row = @mysql_fetch_assoc($result))
		{
			$return[$row['item_number']] = get_product_info($row['item_number']);
		}
		return $return;
	}
	else
	{
		return false;
	}
}

function get_all_options($type)
{
	$query = "SELECT $type FROM book_store ORDER BY $type ASC";
	$result = @mysql_query($query);
	if($result){
		$values = array();
		while($row = @mysql_fetch_assoc($result)){
			$values[] = $row[$type];
		}
		return array_unique($values);
	}
	else{
		return false;
	}
}

function get_orders()
{
	$query = "SELECT `order_id`, `cust_id`, `order`, `date_ordered`, `shipping` FROM orders";
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result))
	{
		$tmp['order_id'] = $row['order_id'];
		$tmp['cust_id'] = $row['cust_id'];
		$tmp['order'] = $row['order'];
		$tmp['date_ordered'] = $row['date_ordered'];
		$tmp['shipping'] = $row['shipping'];
		$return[$row['order_id']] = $tmp;
	}
	return $return;
}

function get_customer($customer_id)
{
	$query = "SELECT * FROM customers WHERE cust_id=$customer_id";
	$result = @mysql_query($query);
	$row = @mysql_fetch_assoc($result);
	$number_cols = mysql_num_fields($result);
	
	for ($i=0;$i<$number_cols;$i++)
	{	
		$field_name = mysql_field_name($result, $i);
		$return[$field_name] = $row[$field_name];
	}
	return $return;
}

?>