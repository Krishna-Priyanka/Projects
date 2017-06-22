<!DOCTYPE html>
<html>
<head>
<title>Shield</title>
<link href="style.css" rel="stylesheet">
</head>
<a href=AD.php><img align=left src= "http://png-1.findicons.com/files/icons/1580/devine_icons_part_2/512/home.png" border = "0" alt= "enter" width = "50" height ="50"></a>
<?php
$c=0;
$ini_array = parse_ini_file("db.conf");
session_start();
foreach ($ini_array as &$value) {
            $ini[$c]=$value;
            $c++;

}
if (isset($_SESSION['NAME'])){
$_SESSION['IP']=$_POST['IP'];
//echo $_SESSION['IP'];
}
$host= $ini[0];
$user=$ini[1];
$password=$ini[2];
$dbname=$ini[3];
$dbtable=$ini[5];

$con=mysqli_connect($host,$user,$password,$dbname);
// Check connection
if (mysqli_connect_errno())
{
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
//echo"successfully connected";
}

$sql="CREATE TABLE IF NOT EXISTS DEVICES(
ID INT NOT NULL AUTO_INCREMENT, 
IP VARCHAR(20) NOT NULL,
Username VARCHAR(20) NOT NULL,
Password VARCHAR(20) NOT NULL,
VMname VARCHAR(20) NOT NULL,
cpu FLOAT(20) NOT NULL,
memory FLOAT(20) NOT NULL,
networkinput FLOAT(20) NOT NULL,
networkoutput FLOAT(20) NOT NULL,
disk FLOAT(20) NOT NULL,

PRIMARY KEY(ID)
)";
if ($con->query($sql) === TRUE) {
    //echo "Table  created successfully";
} else {
    //echo "Error creating table: " . $conn->error;
}


$ip=$_POST[IP];
//echo "$ip"."/n";
if(!filter_var($ip,FILTER_VALIDATE_IP))
{
	echo "<center><b><i>Not a Valid IP Address</i></b></center>";
}
else
{
$sql1="INSERT INTO $dbtable (IP,Username,Password,cpu,memory,networkinput,networkoutput,disk)
VALUES ('$ip','$_POST[username]','$_POST[password]','0','0','0','0','0')"; 
$con->query($sql1);

$con->close();


header('Location: AD.php');
}
?>


</html>
