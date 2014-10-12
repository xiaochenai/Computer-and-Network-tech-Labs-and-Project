<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<?php
$firstname_r=$_REQUEST["firstname"];
$lastname_r=$_REQUEST["lastname"];
$telephonenumber_r=$_REQUEST["telephonenumber"];
$address_r=$_REQUEST["address"];
echo "Verified  name ".$firstname_r." " .$lastname_r. " is received!"."</br>";
echo "Verified telephonenumber ".$telephonenumber_r. " is received!"."</br>";
echo "Verified address ".$address_r." is received!"."</br>";
$file = fopen("test1.txt","a+");
fwrite($file, "<username>".$firstname_r.$lastname_r."</username>"."\r\n");
fwrite($file, "<telephone>".$telephonenumber_r."</telephone> "."\r\n");
fwrite($file, "<address>".$address_r."</address>"."\r\n");
fclose($file);
// echo $response
?>
<script language="javascript">
var myWindow=window.open('','','width=200,height=200')
// varnewDoc=myWindow.document.open("text/html","replace");
var txt1="<html><body>The verified and saved result: </br>";
var txt2="</body></html>";
myWindow.document.writeln(txt1);
myWindow.document.writeln("username  "+ "<?=$firstname_r;?>"+"<?=$lastname_r;?>"+"</br>");
myWindow.document.writeln("telephonen:  "+ "<?=$telephonenumber_r;?>"+"</br>");
myWindow.document.writeln("address:" + "<?=$address_r;?>");
myWindow.document.write(txt2);
myWindow.document.close();
var t=setTimeout("myWindow.close()",90000);
</script>
</body>
</html>