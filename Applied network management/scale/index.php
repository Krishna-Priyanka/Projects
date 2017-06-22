<html> 
<body bgcolor="#00FFFF">
<h1><center>SYSUPTIME DETAILS</h1>
<style>
#section {margin: auto ;}
</style>
<?php 
 
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

#connect to db;display table
$conn=mysql_connect("$host:$port",$username,$password);
 
if (!$conn)
{
  die('! Connection Failed: ' . mysql_error());
}

mysql_select_db($database,$conn);
echo"<br>";

print "<center><table border cellpadding=5 ></center>"; 
print "<tr>";
print "<th>ID</th>";
print "<th>IP</th> ";
print "<th>PORT</th> ";
print "<th>COMMUNITY</th> ";
print "<th>STATUS</th> ";
print "<th>STATISTICS</th>";
print "</tr>";

$query2=mysql_query( "SELECT MAX(id) AS MAX_ID FROM `lab4`"); 
$fetch=mysql_fetch_array($query2);

$max_id="$fetch[MAX_ID]";
 
for($i=1;$i<=$max_id;$i++) 
{
$query3=mysql_query( "SELECT * FROM `lab4` WHERE id='$i'"); 
$value=mysql_fetch_array( $query3);

$count=$value[FAILURE1];

if ($count==0 )
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFFFFF></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==1)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFEEEE></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==2)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFEBEB></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==3)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFD6D6></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==4)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFC2C2></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==5)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFADAD></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=9)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF9999></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==10)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF9999></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=15)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF8585></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=18)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF7070></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=20)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF7070></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=25)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF5C5C></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=28)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF4747></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==29)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF4747></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==30)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF3333></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count>30)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF0000></td>";
print "<td><font ><html><a href='lab4.php?id=$value[id]'>STATISTICS</a></html></font></td>";
?>
<?php
print "</tr>";
}
}
 ?>
</body>
</html>





