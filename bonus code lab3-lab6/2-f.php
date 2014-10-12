<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<?php
$user_r=$_REQUEST["user"];
$zip_r=$_REQUEST["zip"];
echo "Verrified user name ".$user_r. " is received!"."</br>";
echo "Verrified zip code ".$zip_r. " is received!"."</br>";
$file = fopen("test.txt","a+");
fwrite($file, "<username>".$user_r."</username>"."\n");
fwrite($file, "<zipcode>".$zip_r."</zipcode> "."\n");
fclose($file);
// echo $response
?>
<script language="javascript">
var myWindow=window.open('','','width=200,height=200')
// varnewDoc=myWindow.document.open("text/html","replace");
var txt1="<html><body>The verified and saved result: </br>";
var txt2="</body></html>";
myWindow.document.writeln(txt1);
myWindow.document.writeln("username  "+ "<?=$user_r;?>"+"</br>");
myWindow.document.writeln("zip code:  "+ "<?=$zip_r;?>");
myWindow.document.write(txt2);
myWindow.document.close();
var t=setTimeout("myWindow.close()",50000);
</script>
</body>
</html>

