<?php
$uid=$_GET[id];

$count=0;
$ini_array = parse_ini_file("db.conf");

foreach ($ini_array as &$value) {
            $in[$count]=$value;
            $count++;

}

$dbhost= $in[0];
$usrnm=$in[1];
$pwd=$in[2];
$dbname=$in[3];
$dbtable=$in[5];

$con=mysql_connect($dbhost,$usrnm,$pwd);
mysql_select_db($dbname, $con) or die ("Cannot select DB");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
$data1 = mysql_query( "SELECT * FROM `$dbtable` where ID='$uid'") 
 or die(mysql_error()); 
 $r = mysql_fetch_array($data1);


$data3=mysql_query("DELETE FROM $dbtable where ID='$uid'")
or  die(mysql_error()); 

header('Location: AD.php');

?>


