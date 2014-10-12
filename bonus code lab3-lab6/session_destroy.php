<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<?php
session_start();
session_destroy();
echo "Your session has been destoryed<br>";
echo "Return to <a href=\"session_variable_2.php\">session_variable_2.php</a>";
?>
</body>