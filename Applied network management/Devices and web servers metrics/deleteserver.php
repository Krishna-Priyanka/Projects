<!DOCTYPE html>
<html>
<head >

<h1><center>Lab2</center></h1>
</head>
<body bgcolor="#00FFFF">
<center><a  href="index.html">Home
<a  href="adddevice.php">adddevice
<a  href="addserver.php">addserver
<a  href="deletedevice.php">deletedevice
<a  href="deleteserver.php">deleteserver
<a  href="monitor.php">Monitor</a></center>

 <h3><center> Select the server to be removed</center> </h3>
 
 
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
if (!empty($_POST['delete_list2'])) 
{
foreach($_POST['delete_list2'] as $value)
										 {
														echo "$value<br>"; 
														$sql = "DELETE FROM lab2_server WHERE id=$value";

														if (mysqli_query($conn, $sql)) {
																echo "Record deleted successfully";
														} else {
																echo "Error deleting record: " . mysqli_error($conn);
														}
												
										}


}
 echo "<form action='' method=post>";
 $result = mysqli_query($conn,"SELECT id,server  FROM lab2_server");
 echo "<center><table></center>";
 echo "<tr><th>Select</th><th>Server</th></tr>";
 
 while($row = mysqli_fetch_array($result))
 {
 echo "<tr><td><input type='checkbox' name='delete_list2[]' value=$row[id]></td><td>$row[server]</td></tr>";
 
 }
 
  echo "</table>";
 echo "<center><input type=submit value='delete server'></center>";
 echo "</form>";


 
 
 ?>
