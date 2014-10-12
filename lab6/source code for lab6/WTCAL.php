<?php
$q=$_GET["q"];

if (@($q.length)>0)
  {$height=$q;}
 	if($height < 110) {
 		echo ("no suggestion");
 	}
 	else {
 		echo ($height-110);
 	}
?>