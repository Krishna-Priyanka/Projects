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
break;
}
?>
	<h1><center> MONITORING THE PERFORMANCE OF VIRTUAL MACHINES</center></h1>
<a href=main.php><img align=left src= "http://png-1.findicons.com/files/icons/1580/devine_icons_part_2/512/home.png" border = "0" alt= "enter" width = "50" height ="50"></a>

<a href=logout.php><img align=right src= "http://image.shutterstock.com/display_pic_with_logo/535639/535639,1272387653,5/stock-photo-logout-metal-icon-51893320.jpg" border = "0" alt= "enter" width = "50" height ="50"></a>

<h2> <center>Click on view to see the statistics/graphs</center></h2><br>
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

$con=mysql_connect($dbhost,$username,$password);
mysql_select_db($dbname, $con) or die ("Cannot select DB");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	
}
mysql_select_db($dbname) or die(mysql_error());	
 Print "<center><table border cellpadding=10></center>"; 
 print "<tr>";
 print "<th>IP</th> ";
 print "<th>Username</th> ";
 print "<th>VM Name</th> ";
 print "<th>Select </th>";
 print "<th>View:</th> ";
 
 print "</tr>";
$data1 = mysql_query( "SELECT MAX(id) AS MAX_ID FROM `$dbtable`") 
  or die(mysql_error()); 
 $r = mysql_fetch_array($data1);
 $max_s1= "$r[MAX_ID]";
		for($j=1;$j<=$max_s1;$j++) 
		 {
		  $data3 = mysql_query( "SELECT * FROM `$dbtable` WHERE id='$j'") 
 or die(mysql_error()); 
$info3 = mysql_fetch_array( $data3 );
if($info3[ID]===NULL)
{continue;
	}
	else{
		
 print "<tr>";
 
print "<form action=view.php method='GET'>"; 
print "<td>".$info3[IP]."</td>";
print "<td>".$info3[Username]."</td>";
print "<td>".$info3[VMname]."</td>";
print "<td>";


?>

<p>
	<form action=view.php method="GET">
<select name="metric">
  
  <option value="cpuusage">CPU Usage</option>
  <option value="memoryusage">Memory Usage </option>
  <option value="inputnetworkusage">Network Input Usage</option>
  <option value="outputnetworkusage">Network Output Usage</option>
  <option value="diskusage">Disk Usage </option>

<?php   
print "<input type='hidden' name='id' value='$info3[ID]'> ";   
print "<input type='hidden' name='ip' value='$info3[IP]'> ";    
print "<input type='hidden' name='username' value='$info3[Username]'> ";  
print   "<input type='hidden' name='VMname' value='$info3[VMname]'> ";       
?>

<td> <input type=submit name=submit value=view> </td>
 

</select>
</p>
</form>
<?php
print"</td>";
#echo "<td><html><a href='nn.php?id=$info3[ID],'>view</html></td>";

print "</tr>";
	 }
		}
		
				 print"</table><br><br>";
	?>
<br><br><br><br><br><br>

</body>
</html>
