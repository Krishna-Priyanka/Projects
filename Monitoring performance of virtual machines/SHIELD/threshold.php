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

<a href=logout.php><img align=right src= "http://image.shutterstock.com/display_pic_with_logo/535639/535639,1272387653,5/stock-photo-logout-metal-icon-51893320.jpg" border = "0" alt= "enter" width = "50" height ="50"></a>
	
	
	
	
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


$connection=mysqli_connect("$dbhost","$username","$password","$dbname");
  
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function update_clients()
{
    mysql_query( "UPDATE DEVICES SET ID = ID + 1 LIMIT 1" );
}

$sql="CREATE TABLE IF NOT EXISTS `thresholds` (
`id` INT(18) NOT NULL,
`cpu_min` VARCHAR(4800) NOT NULL,`cpu_max` VARCHAR(4800) NOT NULL,
`memory_min` VARCHAR(4800) NOT NULL,`memory_max` VARCHAR(4800) NOT NULL,
`networkinput_min` VARCHAR(4800) NOT NULL,`networkinput_max` VARCHAR(4800) NOT NULL,
`networkoutput_min` VARCHAR(4800) NOT NULL,`networkoutput_max` VARCHAR(4800) NOT NULL,
`disk_min` VARCHAR(4800) NOT NULL,`disk_max` VARCHAR(4800) NOT NULL,
`Emailid` VARCHAR(4800) NOT NULL,
PRIMARY KEY (`id`)  ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

mysqli_query($connection,$sql);

$sql2=mysqli_query($connection,"INSERT INTO `thresholds` (id,cpu_min,cpu_max,memory_min,memory_max,networkinput_min,networkinput_max,networkoutput_min,networkoutput_max,disk_min,disk_max,Emailid) VALUES ('1','4','5','0.92','0.98','2711000','2711700','798900','799000','4.22','4.27','1') ");    


$result = mysqli_query($connection,"SELECT * FROM DEVICES ");
$result1 = mysqli_query($connection,"SELECT * FROM thresholds");


?>
<h><center><b> Device Status </b></center></h>
<br>
<center>
<table border='1'>
<thead class='header_row'>

<th>IP </th>
<th>Username</th>
<th>VMname</th>
<th>cpu</th>
<th>memory</th>
<th>networkinput</th>
<th>networkoutput</th>
<th>disk</th>
</thead>
</center>


<?php
$row1 = mysqli_fetch_array($result1);
while($row = mysqli_fetch_array($result))
{
if(count($_POST)>0)
{
$threscpu1 = preg_replace('#(^A-Za-z)#i','',$_POST["cpu_min"]);
$threscpu2 = preg_replace('#(^A-Za-z)#i','',$_POST["cpu_max"]);
$thresmem1 = preg_replace('#(^A-Za-z)#i','',$_POST["memory_min"]);
$thresmem2 = preg_replace('#(^A-Za-z)#i','',$_POST["memory_max"]);
$thresni1 = preg_replace('#(^A-Za-z)#i','',$_POST["networkinput_min"]);
$thresnin2 = preg_replace('#(^A-Za-z)#i','',$_POST["networkinput_max"]);
$thresno1 = preg_replace('#(^A-Za-z)#i','',$_POST["networkouput_min"]);
$thresnou2 = preg_replace('#(^A-Za-z)#i','',$_POST["networkouput_max"]);
$thresd1 = preg_replace('#(^A-Za-z)#i','',$_POST["disk_min"]);
$thresd2 = preg_replace('#(^A-Za-z)#i','',$_POST["disk_max"]);

$Emailid=htmlspecialchars($_POST["Emailid"]);
echo "EMAIL: $_POST[Emailid]";

$sql3 = "UPDATE thresholds SET cpu_min='$threscpu1',cpu_max='$threscpu2',memory_min='$thresmem1',memory_max='$thresmem2',networkinput_min='$thresni1',networkinput_max='$thresnin2',networkoutput_min='$thresno1',networkoutput_max='$thresnou2',disk_min='$thresd1',disk_max='$thresd2',Emailid='$_POST[Emailid]' WHERE id=1";

mysqli_query($connection,$sql3);

  if (($row['cpu'] <= $threscpu1) && ($row3['memory'] <= $thresmem1) && ($row['networkinput'] <= $thresnin1) && ($row['networkoutput'] <= $thresnou1 ) && ($row['disk'] <= $thresd1 ))
    {
     $color_class = 'green';
     //echo "green";
    }
    elseif (($threscpu1 < $row['cpu'] and $threscpu2 >= $row['cpu']) || ($thresmem1 < $row['memory'] and $thresmem2 >= $row['memory']) || ($thresnin1 < $row['networkinput'] and $thresnin2 >= $row['networkinput']) || ($thresnou1 < $row['networkoutput'] and $thresnou2 >= $row['networkoutput']) || ($thresd1 < $row['disk'] and $thresd2 >= $row['disk']))
     {
      $color_class = 'orange';
       //echo "orange";
      }
     else
     {
         $color_class = 'red';
	 }
         
        echo "<tr class={$color_class}>";
    
    echo "<td>" . $row['IP'] . "</td>";
    echo "<td>" . $row['Username'] . "</td>";
    echo "<td>" . $row['VMname'] . "</td>";
    echo "<td>" . $row['cpu'] . "</td>";
    echo "<td>" . $row['memory'] . "</td>";
    echo "<td>" . $row['networkinput'] . "</td>";
    echo "<td>" . $row['networkoutput'] . "</td>";
    echo "<td>" . $row['disk'] . "</td>";
    echo "</tr>";

//echo "</table>"; 
?>
<link rel='stylesheet' type='text/css' href='stylesheet.css'/> 
<?php
}
else
{
$threscpu1 = 4;
$threscpu2 = 5;
$thresmem1 = 0.92;
$thresmem2 = 0.98;
$thresnin1 = 2711000;
$thresnin2 = 2711700;
$thresnou1 = 798900;
$thresnou2 = 799000;
$thresd1 = 4.22;
$thresd2 = 4.27;
   
 if (($row['cpu'] <= $threscpu1) && ($row['memory'] <= $thresmem1) && ($row['networkinput'] <= $thresnin1) && ($row['networkoutput'] <= $thresnou1 ) && ($row['disk'] <= $thresd1 ))
    {
     $color_class = 'green';
     // echo "green";
    }
    elseif (($threscpu1 < $row['cpu'] and $threscpu2 >= $row['cpu']) || ($thresmem1 < $row['memory'] and $thresmem2 >= $row['memory']) || ($thresnin1 < $row['networkinput'] and $thresnin2 >= $row['networkinput']) || ($thresnou1 < $row['networkoutput'] and $thresnou2 >= $row['networkoutput']) || ($thresd1 < $row['disk'] and $thresd2 >= $row['disk']))
     {
      $color_class = 'orange';
       //echo "orange";
      }
     else
     {
         $color_class = 'red';
         
          //echo "red";
     }
    echo "<tr class={$color_class}>";
    
    echo "<td>" . $row['IP'] . "</td>";
    echo "<td>" . $row['Username'] . "</td>";
    echo "<td>" . $row['VMname'] . "</td>";
    echo "<td>" . $row['cpu'] . "</td>";
    echo "<td>" . $row['memory'] . "</td>";
    echo "<td>" . $row['networkinput'] . "</td>";
    echo "<td>" . $row['networkoutput'] . "</td>";
    echo "<td>" . $row['disk'] . "</td>";
    echo "</tr>";

 
}

}

echo "</table>"; 
?>
<br><br>
<h><center><b>Current Threshold Values</b></center></h>
<br>

<?php 


$c=0;
$array = parse_ini_file("threshold.conf");

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

$query = "SELECT * FROM thresholds";

$result=mysql_query($query);

echo "<table border='1' cellpadding='10'>";
    echo "<tr> 
			<th>cpu_min</th> 
			<th>cpu_max</th> 
			<th>memory_min </th> 
			<th>memory_max</th> 
			<th>networkinput_min</th> 
			<th>networkinput_max</th> 
			<th>networkoutput_min</th> 
			<th>networkoutput_max</th> 
			<th>disk_min</th> 
			<th>disk_max</th> 
		</tr>";

 while($row = mysql_fetch_array($result))
 {
  echo '<td>' . $row['cpu_min'] . '</td>';
  echo '<td>' . $row['cpu_max'] . '</td>';
  echo '<td>' . $row['memory_min'] . '</td>';
  echo '<td>' . $row['memory_max'] . '</td>';
  echo '<td>' . $row['networkinput_min'] . '</td>';
  echo '<td>' . $row['networkinput_max'] . '</td>';
  echo '<td>' . $row['networkoutput_min'] . '</td>';
  echo '<td>' . $row['networkoutput_max'] . '</td>';
  echo '<td>' . $row['disk_min'] . '</td>';
  echo '<td>' . $row['disk_max'] . '</td>';
  echo "</tr>"; 
  }
 echo "</table>";

?>






<link rel='stylesheet' type='text/css' href='stylesheet.css'/>

<form method ="POST" ACTION="">
<p>cpu</p>
<input type="text" placeholder="lower limit" name="cpu_min"><br>
<input type="text" placeholder="upper limit" name="cpu_max"><br>
<p>memory</p>
<input type="text" placeholder="lower limit" name="memory_min"><br>
<input type="text" placeholder="upper limit" name="memory_max"><br>
<p>network input</p>
<input type="text" placeholder="lower limit" name="networkinput_min"><br>
<input type="text" placeholder="upper limit" name="networkinput_max"><br>
<p>network output</p>
<input type="text" placeholder="lower limit" name="networkoutput_min"><br>
<input type="text" placeholder="upper limit" name="networkoutput_max"><br>
<p>disk</p>
<input type="text" placeholder="lower limit" name="disk_min"><br>
<input type="text" placeholder="upper limit" name="disk_max"><br>

Emailid: <br>
<input type="text" placeholder="email" name="Emailid"> <br>

<td colspan="2"><input type="submit" value="Update"></td>
</form>

</html>
