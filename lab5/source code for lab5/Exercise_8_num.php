<?php
function check_prefix_length($number,$type)
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
echo "<html><head><title>Credit Card Number Check</title></head><body>";
echo "Credit Card Type : \"$_POST[type]\"</br>";
echo "Credit Card Number : \"$_POST[cardnumber]\"</br>";
if(check_prefix_length($_POST["cardnumber"],$_POST["type"]))
{
	echo "Your Credit Card Number is Valid";
}
else
{
	echo"Your Credit Card Number is NOT Valid";
}



?>