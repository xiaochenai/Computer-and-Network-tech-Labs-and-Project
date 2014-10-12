<?php
//get form details
$cd1price = $_GET["cd1price"];
$cd1quantity = $_GET["cd1quantity"];
$cd7price = $_GET["cd7price"];
$cd7quantity = $_GET["cd7quantity"];
$movieAprice = $_GET["movieAprice"];
$movieAquantity = $_GET["movieAquantity"];
//caculate total
$cd1total = $cd1price * $cd1quantity;
$cd7total = $cd7price * $cd7quantity;
$movieAtotal = $movieAprice * $movieAquantity;
$shippingtotal = 0.05 * ($cd1total + $cd7total + $movieAtotal);
$total = $shippingtotal + $cd1total + $cd7total + $movieAtotal;
//response to Client
echo "$cd1total,$cd7total,$movieAtotal,$shippingtotal,$total";
?>