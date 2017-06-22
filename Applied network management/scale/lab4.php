<html>
<body bgcolor="#00FFFF">
<?php
$get=$_GET[id];
 
$path=dirname(__FILE__);

$pathh=explode("/",$path,-1);
$pathh[count($pathh)+1]='db2.conf';
$finalpath=implode("/",$pathh);
$handle=fopen($finalpath, "r");
$values=array();
while ($line=fgets($handle)) 
{
$n=explode ('"',$line);
array_push($values,$n[1]);
}
$host=$values[0];
$port=$values[1];
$database=$values[2];
$username=$values[3];
$password=$values[4];


$conn=mysql_connect("$host:$port",$username,$password);
 
if (!$conn)
{
  die('! Connection Failed: ' . mysql_error());
}

mysql_select_db($database,$conn)
 or die(mysql_error());
echo"<br>";
$query=mysql_query( "SELECT * FROM `lab4` WHERE id='$get'") 
 or die(mysql_error()); 
$fetch=mysql_fetch_array( $query);

$ip="$fetch[IP]";
$port="$fetch[PORT]";
$community="$fetch[COMMUNITY]";
$sysuptime="$fetch[SYSUPTIME]";
$hits="$fetch[HITS]";
$failure="$fetch[FAILURE]";
$total="$fetch[TOTAL_REQ]";
$time="$fetch[TIME]";

print "<center><table border cellpadding=5 ></center>"; 
print "<tr>";
print "<center><tr><th>DEVICE: $get </tr></td></center>";	
print "<center><tr><td>IP: $ip </center></tr></td>";
print "<center><tr><td>Port: $port <center></tr></td>";
print "<center><tr><td>Community: $community <center></tr></td>";
print "<center><tr><td>Systemuptime: $sysuptime<center></tr></td>";
print "<center><tr><td>Successful Requests:$hits<center></tr></td>";
print "<center><tr><td>Failed requests: $failure <center></tr></td>";
print "<center><tr><td>Total Requests sent: $total <center></tr></td>";
print "<center><tr><td>Last Update Time: $time <center></tr></td>";
print "</tr>";
?>
</body>
</html>









