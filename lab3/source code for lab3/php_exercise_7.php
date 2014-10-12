<?php
include 'php_exercise_7.inc';
echo "<HTML><HEAD><TITLE>Month Display</TITLE></HEAD></HTML>";
for($i=1;$i < 14; $i++)
{
$month = display_month_name($i);
if($month != '')
{
echo "My Name is Xiao Lin and I was born in $month </br>";
}
}
?>