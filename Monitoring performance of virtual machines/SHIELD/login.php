<!DOCTYPE html>
<html>
<head>
<title>SHIELD</title>
<link href="style.css" rel="stylesheet">
</head>

<body>

<div id="main">

<h1><center>
MONITORING THE PERFORMANCE OF VIRTUAL MACHINES</center></h1>


<?php
session_start();
if($_POST[NAME] && $_POST[PASSWORD])
{
	$pass = filter_var($_POST['PASSWORD'], FILTER_SANITIZE_STRING);
    $pass1 = sha1( $pass );
$c=0;
$ini_array = parse_ini_file("db.conf");
foreach ($ini_array as &$value) {
            $in[$c]=$value;
            $c++;

}

$dbhost= $in[0];
$username=$in[1];
$pass=$in[2];
$dbname=$in[3];
$dbtable=$in[5];
$con=mysqli_connect($dbhost,$username,$pass,$dbname);

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$data1 = mysqli_query($con, "SELECT * FROM `USERS` where NAME='$_POST[NAME]'") 
 or die(mysql_error()); 
 $r = mysqli_fetch_array($data1);
 print "$r[NAME] == $_POST[NAME] &&  $r[PASSWORD] == $pass1 ";
if ($r[NAME]==$_POST[NAME] && $r[PASSWORD]==$pass1)
   
   {
	   
	   	$_SESSION['NAME'] = $r[NAME];
	header("location: main.php");
	

	  # echo "logged";
	  exit;
	   }
	   else{
		   
		   print"Invalid USER NAME and PASSWORD <br>";
 echo "<a href=welcome.php> <font color=blue  size='4pt'> 
Click here to try login.</a> </font><br> <br><br><br> <br><br> <br><br> <br><br> <br><br> <br>";
		   }

}
else{
	
	print "Login fields empty..please check <br>";
	echo "<a href=welcome.php> <font color=blue  size='4pt'> 
Click here to try login.</a> </font><br> <br><br> <br><br> <br><br> <br><br> <br><br> <br>";

	}
	include "footer.php";
?>
