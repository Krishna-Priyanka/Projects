<!DOCTYPE html>
<html>
<head>

<h1><center>Lab2</center></h1>
</head>
<body bgcolor="#00FFFF">
<center><a  href="index.html">Home
<a  href="adddevice.php">adddevice
<a  href="addserver.php">addserver
<a  href="deletedevice.php">deletedevice
<a  href="deleteserver.php">deleteserver</a></center>

 <center><h3> Enter the ip of the server to monitor</h3> </center>
<form action="addserver.php" method="post">
<center>ip:        <input type="text" name="serverip" required><br></center>
<center><input type="submit" value="add server"></center>

</form>
<?php
if(!empty($_POST["serverip"])) {
 $x= $_POST["serverip"];  


#require "find.php";
$myfile = fopen("../db.conf", "r") or die("Unable to open file!");
eval(fread($myfile,filesize("../db.conf")));
fclose($myfile);

$conn = mysqli_connect($host,$username, $password,$database,$port);

// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully<br>";
mysqli_select_db($conn,"$database");

$tbl = "CREATE TABLE IF NOT EXISTS lab2_server ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                server VARCHAR(255) NOT NULL,
                
                PRIMARY KEY (id),
                UNIQUE (id,server) 
                )"; 
$query = mysqli_query($conn, $tbl); 
if ($query === TRUE) {
	#echo "<h3>blockedusers table created OK :) </h3>"; 
} else {
	echo "<h3>blockedusers table NOT created :( </h3>"; 
}
$sqls = "INSERT INTO lab2_server (server)
VALUES (\"$x\")";

if (mysqli_query($conn, $sqls)) {
    echo "New server '$x' added succesfully";
} else {
 echo "error server already exists";
    echo "Error: " . $sqls . "<br>" . mysqli_error($conn);
}
}

?>

</html>
