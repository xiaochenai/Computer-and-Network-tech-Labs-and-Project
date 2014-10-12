<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<?php
session_start();
echo "You session ID #: ";
// The session_id() function prints your session ID to the 
// screen. The print() function is similar to the echo()
// function
print(session_id());
?>
</body>