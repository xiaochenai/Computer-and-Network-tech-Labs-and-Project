<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<?php
//function to validate credit card
function check_number($number,$type)
{
// turn the number into a string
	$n = "$number";
// find its length
	$c = strlen($n);
	$t = 1;
	

// switch on type
switch ($type)
{
	// check Visa for starting 4
	case "Visa":
		if ($number[0] == 4 && ($c == 16 || $c == 13)) break;
		else return 0;
		break;
	// check Master Card for starting 51-55
	case "MasterCard":
		if ($number[0] == 5 && $number[1] < 6 && $number[1] > 0 && $c == 16) break;
		else return 0;			
		break;
	// check Discover for starting 6011
	case "Discover":
		if ($number[0] == 6 && $number[1] == 0 && $number[2] == 1 && $number[3] == 1 && $c == 16) break;
		else return 0;
		break;
	// American Express prefix no is 34 or 47 length is 15
	case "American Express":
		if($number[0] == 3 && ($number[1] == 4 ||$number[1] == 7) && $c==15) break;
		else return 0;
		break;
	// Amex Corporate prefix no is 34 or 37 length is 15
	case "Amex Corporate":
		if($number[0] == 3 && ($number[1] == 4 || $number[1] == 7) && $c == 15) break;
		else return 0;
		break;
	//Dinners Club prefix no is 36 38 300-305 length is 14
	case"Dinners Club":
		if($number[0] == 3 && (($number[1] == 0 && $number[2]<6) || ($number[1] == 6 || $number[1] == 8)) && $c == 14) break;
		else return 0;
		break;
	
	default:
		return 0;
}
$value=0;
for($i = ($c - 1); $i >= 0; $i--)
{
	// mult. by 1 or 2
	$temp = $n[$i] * $t;
	// toggle between 1 and 2
	if($t == 1) $t = 2;
	else $t = 1;
	$value = "$value$temp";
}
// loop and sum up each idiv. digit
$l = strlen($value);
$checksum=0;
for($i = 0; $i < $l; $i++)
{
	$checksum = $checksum + $value[$i];
}
// mod the checksum by 10
$verified = $checksum % 10;
// if not 0 return 0 
if ($verified != 0) return 0;
return 1;
}
function check_expiration($month,$year)
{
	$date = getdate();
	$current_month = $date["mon"];
	$current_year = $date["year"];
	if($year < $current_year) return 0 ;
	else if(($month < $current_month) && ($year == $current_year)) return 0;
	return 1;
}
$date = getdate();
$current_month = $date["mon"];
$current_year = $date["year"];
echo "<html><head><title>Credit Card Check</title></head><body>";
echo "<p>Today's Date : $current_month/$current_year</p></br>";
echo "<p>Expiration Date : $_POST[month]/$_POST[year]</p></br>";
echo "<p>Credit Card Type : $_POST[type]</p></br>";
echo "<p>Credit Card Number : $_POST[cardnumber]</p></br>";
if(check_expiration($_POST["month"],$_POST["year"]))
{
	echo"<h2>Your Credit Card Expiration Date is Valid</h2></br>";
}
else
{
	echo"<h2>Your Credit Card Has Expired</h2></br>";
}
if(check_number($_POST["cardnumber"],$_POST["type"]))
{
	echo"<h2>Your Credit Card Number is Valid</h2></br>";
}
else
{
	echo "<h2>Your Credit Card Number is NOT Valid</h2></br>";
}
?>