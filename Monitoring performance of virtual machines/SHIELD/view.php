<!DOCTYPE html>

<html>
<head>
<title>Shield</title>
<link href="style.css" rel="stylesheet">
</head>

<div id="main">
	<?php
	session_start();
if (!isset($_SESSION['NAME']))
{
echo "<h2>Please Login</h2>";
echo "<a href=welcome.php> <font color=#9932CC  size='4pt'>  
Click here to login.</font></a> <br><br>";
#break;
}
?>
	<h1><center> MONITORING THE PERFORMANCE OF VIRTUAL MACHINES</center></h1>
<a href=main.php><img align=left src= "http://png-1.findicons.com/files/icons/1580/devine_icons_part_2/512/home.png" border = "0" alt= "enter" width = "50" height ="50"></a>

<a href=logout.php><img align=right src= "http://image.shutterstock.com/display_pic_with_logo/535639/535639,1272387653,5/stock-photo-logout-metal-icon-51893320.jpg" border = "0" alt= "enter" width = "50" height ="51"></a>

<a href=graph.php><img align=bottomleft src= "http://icons.iconarchive.com/icons/rafiqul-hassan/blogger/512/Arrow-Back-icon.png" border = "0" alt= "enter" width = "45" height ="52"></a>


<?php 
$c=0;
$array = parse_ini_file("db.conf");

foreach ($array as &$value) {
            $in[$c]=$value;
            $c++;

}

$dbhost= $in[0];
$username=$in[1];
$password=$in[2];
$dbname=$in[3];
$dbtable=$in[5];
$out=$in[6];

$con=mysqli_connect($dbhost,$username,$password,$dbname);
mysqli_select_db($con,$dbname) or die ("Cannot select DB");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	
}
print "";


print "<center><table border cellpadding=10></center>"; 
 print "<tr>";
 print "<th>IP</th> ";
 print "<th>Username</th> ";
 print "<th>VM Name</th> ";
 print "<th>cpu</th> ";
 print "<th>memory</th> ";
 print "<th>networkinput</th> ";
 print "<th>networkoutput</th> ";
 print "<th>disk</th> ";
 print "</tr>";

$data3 = "SELECT * FROM `$dbtable` WHERE ID='$_GET[id]' ";
		  
 $result=mysqli_query($con, $data3);
 
	  while ($row=mysqli_fetch_array($result))
    {
	
    print "<td>".$row[IP]."</td>";
    print "<td>".$row[Username]."</td>";
    print "<td>" .$row[VMname]."</td>";
    print "<td>" .$row[cpu]."</td>";
    print "<td>".$row[memory]."</td>";
    print "<td>".$row[networkinput]."</td>";
    print "<td>".$row[networkoutput]."</td>";
    print "<td>".$row[disk]."</td>";
    
    
    }
  mysqli_free_result($result);


mysqli_close($con);



$metric = htmlspecialchars($_GET['metric']);
$VMname = htmlspecialchars($_GET['VMname']);
$ipaddres = htmlspecialchars($_GET['ip']);
$name = htmlspecialchars($_GET['username']);

if ($VMname)
{
	$filename="$name-$ipaddres-$VMname"; 
	echo "$filename";
}
else
{
	$filename="$name-$ipaddres";
	echo "$filename";
} 	

if ($metric == 'cpuusage'){
$unit= "percent";
}
elseif($metric == 'memoryusage'){
$unit= 'bytes';
}
elseif ($metric == 'inputnetworkusage'){
$unit= 'bps';
}
elseif($metric == 'outputnetworkusage'){
$unit= 'bps';
}
else{
$unit= 'bytes';
}

#print "$metric $unit dkwdnkd";	
#$unit = htmlspecialchars($_GET['unit']);
#echo "Not a valid ip address";
shell_exec('php /var/www/html/shield/rrdgraph.php "'.$filename.'" "'.$metric.'" "'.$unit.'"');
$path=dirname(__FILE__);

if (file_exists("$filename.rrd")) 
{
#echo "there";}
}
else {
echo "\nDevice is down / Not a valid IP";
}
 ?>
<br><img src="day.png"> 
<br><img src="week.png"> 
<br><img src="month.png"> 
<br><img src="year.png">

</body>
</html>

