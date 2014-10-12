<html>
<head>
<title>My exercise3.php</title>
</head>
<body>
Welcom <?php echo $_GET["name"];?></br>
Your password is <?php echo $_GET["password"];?></br>
Sex you select is <?php echo $_GET["Sex"];?></br>
Your favorite color is <?php echo $_GET["color"];?></br>
Do you have a car? <?php if (isset($_GET["Car"])) {echo "YES";} else {echo "NO";}?></br>
Do you have a bike? <?php echo isset($_GET["Bike"])?"YES":"NO";?></br>
Your comments is : <?php echo $_GET["commentbox"];?></br>
</body>
</html>