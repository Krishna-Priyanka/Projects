<!DOCTYPE html>
<html>
<head>

<h1><center>Lab2</center></h1>
</head>
<body bgcolor="#00FFFF">
<center><a  href="index.html">Home
<a href="adddevice.php">adddevice
<a  href="addserver.php">addserver
<a  href="deletedevice.php">deletedevice
<a  href="deleteserver.php">deleteserver
<a  href="monitor.php">Monitor</a></center>
<center> <h3> Select the device to be removed </h3></center>
 <?php 
 $myfile = fopen("../db.conf", "r") or die("Unable to open file!");
eval(fread($myfile,filesize("../db.conf")));
fclose($myfile);
# require "find.php";
$conn = mysqli_connect($host,$username, $password,$database,$port);
// Checkconnection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully<br>";
mysqli_select_db($conn,"$database");
if (!empty($_POST['delete_list1'])) 
{
foreach($_POST['delete_list1'] as $value)
										 {
														echo "$value<br>"; 
														$sql = "DELETE FROM lab2_device WHERE id=$value";

														if (mysqli_query($conn, $sql)) {
																echo "Record deleted successfully";
														} else {
																echo "Error deleting record: " . mysqli_error($conn);
														}
												
										}


}
 echo "<form action='' method=post>";
 $result = mysqli_query($conn,"SELECT id,IP, PORT, COMMUNITY  FROM lab2_device");
 echo "<center><table>";
 echo "<tr><th>Select</th><th>Ip</th><th>Port</th><th>Community</th></tr></center>";
 
 while($row = mysqli_fetch_array($result))
 {
 echo "<tr><td><input type='checkbox' name='delete_list1[]' value=$row[id]></td><td>$row[IP]</td><td>$row[PORT]</td><td>$row[COMMUNITY]</td></tr>";
 
 }
 
  echo "</table>";
 echo "<center><input type=submit value='delete device'></center>";
 echo "</form>";


 
 
 ?>

