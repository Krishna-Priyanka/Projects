<!DOCTYPE html>
<html>
<head>
<title>Log out</title>
<link href="style.css" rel="stylesheet">
</head>

<body>

<div id="main">
<h1><center>
MONITORING THE PERFORMANCE OF VIRTUAL MACHINES</center></h1>
<center>
<img align=center src= "http://thegriefrecoverycourse.com/wp-content/uploads/2013/01/Logout1a.png"  border = "0"  width = "400" height ="100">
</center>
<?php 
session_start();
session_destroy();
print "<br><br><br><br><br><br>";
echo "<a href=welcome.php> <font color=#9932CC  size='4pt'>  
<center> Click here to login again </center> </font></a> <br><br>";
print"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
include "footer.php"; 
 ?>
</head>
</html>
