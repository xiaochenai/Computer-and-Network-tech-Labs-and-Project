<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<?php
function che_for_exp($month,$year)
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
echo "<html><head><title>Expire Date Check</title></head><body>";
echo "Today's Date: $current_month/$current_year</br>";
echo "Expiration Date: $_POST[month]/$_POST[year]</br>";
if(che_for_exp($_POST["month"],$_POST["year"]))
{
echo "<h2>Your credit card date is valid</h2></br>";
}
else
{
echo "<h2>Your credit card has expired</h2></br>";
}
echo "</body></html>";

?>