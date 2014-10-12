<?php
function display_month_name($month)
{
//  change the month number to string and return the string value
switch($month)
{
	case 1:
	$string = 'January';
	break;
	case 2:
	$string = 'Feburary';
	break;
	case 3:
	$string = 'March';
	break;
	case 4:
	$string = 'April';
	break;
	case 5:
	$string = 'May';
	break;
	case 6:
	$string = 'June';
	break;
	case 7:
	$string = 'July';
	break;
	case 8:
	$string = 'August';
	break;
	case 9:
	$string = 'September';
	break;
	case 10:
	$string = 'October';
	break;
	case 11:
	$string = 'November';
	break;
	case 12:
	$string = 'December';
	break;
	default:
	$string = '';
	echo "eror month number $month </br>";
	echo "month number must within 1 to 12 </br>";
	
	
}
return $string;

} 
?>