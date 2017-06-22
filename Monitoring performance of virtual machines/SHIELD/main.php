<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<link href="style.css" rel="stylesheet">
</head>
<body>
	<h1><center> MONITORING THE PERFORMANCE OF VIRTUAL MACHINES</center></h1>
<div id="main">
	<?php
	session_start();
$perl_result = 'perl $var_www_html_shield_mix.pl';
if (!isset($_SESSION['NAME']))
{
echo "<h2>Please Login</h2>";
echo "<a href=welcome.php> <font color=#9932CC  size='4pt'>  
Click here to login.</font></a> <br><br>";
break;
}
?>
	<a href=logout.php><img align=right src= "http://image.shutterstock.com/display_pic_with_logo/535639/535639,1272387653,5/stock-photo-logout-metal-icon-51893320.jpg" border = "0" title="logout" alt= "enter" width = "50" height ="50"></a>


</h1>
<br><br>
<center>
	<?php
echo "<a href=AD.php> <font color=blue  size='4pt'>  
Click here to add/delete devices</a> <br><br>"; 
echo "<a href=graph.php> <font color=blue  size='4pt'>  
Click here for usage graphs and statistics</a> <br><br>";
echo "<a href=threshold.php> <font color=blue  size='4pt'>  
Device Status</a> <br><br>";  
  
?>
	  </center>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php

include "footer.php"; 
?>

</div>

</body>

</html> 

