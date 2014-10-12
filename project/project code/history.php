<?PHP
//history.php
//------------------------------------------------------------------------------------------
// This page is used for show the history of the user that with the right information in the 
// cookie.
//------------------------------------------------------------------------------------------
//functions called:
// include_header(string title) - include the page header and shopping cart
// include_footer() - close the page and include my footer text
// readXML() - read xml from order in table table orders
//------------------------------------------------------------------------------------------
require_once('./includes/functions.php');
require_once('./includes/xml_functions.php');

include_header('My First CD Store.com');
?>
<h3 style="font-family:Arial, Helvetica, sans-serif">Your history<h3>
<?PHP
// Connect to the database
$dbcnx = mysql_connect("localhost", "root","lx64498908") or die("Could not connect
to the database server.");
// Choose which database you would use
mysql_select_db("book_store",$dbcnx) or die("Can not select database");
//get username and mail from cookie
$uname = $_COOKIE["username"];
$umail = $_COOKIE["mail"];


//Find user's id in database;
$sql="SELECT cust_id FROM customers WHERE last_name=\"$uname\" AND email=\"$umail\"";
$rs=mysql_query($sql);
$number_cols = mysql_num_rows($rs);
//display the result on webpage
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
<tr><td>Order ID</td><td>Customer ID</td><td>Order</td><td>Shipping</td><td>Date ordered</td></tr>";
while ($row = mysql_fetch_array($rs))
{
  for ($i=0;$i<$number_cols;$i++)
  {
    //find this user's orders
    @$query="SELECT * FROM orders WHERE cust_id=\"$row[$i]\" ";
    $result=mysql_query($query);
    $number = mysql_num_fields($result);

    while ($line = mysql_fetch_row($result))
   {
      /*display the order's information*/
      echo "<tr>";
      for ($j=0;$j<2;$j++)
      {
        echo "<td>$line[$j]</td>";
      }
      /*Dispaly Order, Parse the XML and display detailed information include item_number and quantity.*/
      echo "<td><ul>";
      $tdb = readXML($line[2]);
      for($counttdb=0;$counttdb<count($tdb);$counttdb++)
      {
		
        echo "<li>Item_ID:";
        echo $tdb[$counttdb]["item_number"];
        echo ";          ";
        echo "Quntity:";
        echo $tdb[$counttdb]["quantity"];
        echo "</li>";

      }
      echo "</ul></td>";
      /*display order's information*/
      for ($j=3;$j<5;$j++)
      {
         echo "<td>$line[$j]</td>";
      }
      echo "</tr>";
    }
  }
}
include_footer();
?>
