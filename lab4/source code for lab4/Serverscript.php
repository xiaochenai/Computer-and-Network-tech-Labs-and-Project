<html>
<body>
<?php
$resp=$_REQUEST["zip"];
echo "Verrified zip code ".$resp." is received and saved in zipCode.txt!";
$file = fopen("zipCode.txt","w+");
fwrite($file, $resp);
fclose($file);
?>
<script language="javascript">
var myWindow=window.open('','','width=200,height=200')
var txt1="<html><body>The verified and saved result: </br>";
var txt2="</body></html>";
myWindow.document.writeln(txt1);
myWindow.document.writeln("zip code:  "+ "<?=$resp;?>"+ "</br>");
myWindow.document.write(txt2);
myWindow.document.close();
var t=setTimeout("myWindow.close()",3000);
</script>
</body>
</html>