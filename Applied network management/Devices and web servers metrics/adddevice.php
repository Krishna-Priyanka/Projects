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
<a  href="deleteserver.php">deleteserver
<a  href="monitor.php">Monitor</a></center>

<script type="text/javascript">
checked=false;
function checkedAll (frm1) {var aa= document.getElementById('frm1'); if (checked == false)
{
checked = true
}
else
{
checked = false
}for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
}
</script>
<center> <h4> Enter the Credentials of the device to monitor </h4></center>
<form action="adddevice.php" method="post">
<table><table align="center">
<tr><td>ip:</td>        <td><input type="text" name="ip" required> </td></tr>
<tr><td>port:</td>        <td>      <input type="text" name="port" required> </td></tr>
<tr><td>community:</td>        <td> <input type="text" name="community" required></td></tr>
</table>
<center><input type="submit" value="add device"></center>
</form>


<?php




if(!empty($_POST["ip"])) {
 $x= $_POST["ip"]; $y=$_POST["port"]; $z=$_POST["community"]; 

$myfile = fopen("../db.conf", "r") or die("Unable to open file!");
eval(fread($myfile,filesize("../db.conf")));
fclose($myfile);
#require "find.php";


$conn = mysqli_connect($host,$username, $password,$database,$port);

// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully<br>";
mysqli_select_db($conn,"$database");

$tbl = "CREATE TABLE IF NOT EXISTS lab2_device ( 
                id int(11) NOT NULL AUTO_INCREMENT,
								IP varchar(255) NOT NULL ,
								PORT int NOT NULL,
								COMMUNITY varchar(255) NOT NULL,
								interfaces varchar(48000) NOT NULL,
								PRIMARY KEY (id),
								UNIQUE KEY(IP,PORT,COMMUNITY)
                )"; 
$query = mysqli_query($conn, $tbl); 
if ($query === TRUE) {
	#echo "<h3>blockedusers table created OK :) </h3>"; 
} else {
	echo "<h3>blockedusers table NOT created :( </h3>"; 
}
$sqls = "INSERT INTO lab2_device (IP,PORT,COMMUNITY)
VALUES (\"$x\", \"$y\", \"$z\")";

if (mysqli_query($conn, $sqls)) {
    echo "New device $x--$y--$z added succesfully<br>\n";
    $a = snmpwalk("$x:$y", "$z", "1.3.6.1.2.1.2.2.1.1"); 
if($a)
{
echo "<form id ='frm1' action='adddevice.php' method='post'>";
foreach ($a as $val) {
    list($b,$c)=explode(" ", $val);
   # echo "$c<br>";
   echo "<input type='checkbox' name='interface[]' value=$x+$y+$z+$c> $c<br>";
}
}
else{echo "device unreachable\n";}
echo "<input type='checkbox' name='intereface[]' onclick='checkedAll(frm1);'>selectAll<br>";
echo "<input type=submit value='monitor interfaces'>";
echo "</form>";
} else {
 echo "error device already exists\n";
    echo "Error: " . $sqls . "<br>" . mysqli_error($conn);
}
}

if(!empty($_POST["interface"])) 
							{
							
							$interfacearray=array();
									foreach($_POST["interface"] as $check2) 
									{
									list($r,$t,$y,$u)=explode("+", $check2);
									#echo "$u";
    array_push($interfacearray, "$u");
    }
    $joined= implode("-", $interfacearray);
    #echo "$joined-$r-$t-$y";
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
    $sqlu = "UPDATE lab2_device SET interfaces='$joined' WHERE IP=\"$r\" AND PORT =\"$t\" AND COMMUNITY=\"$y\"";

if (mysqli_query($conn, $sqlu)) {
    echo "interfaces added succesfully<br>";
    
} else {
    echo "Error: " . $sqlu . "<br>" . mysqli_error($conn);
}
    }

?>


</body>
</html>
