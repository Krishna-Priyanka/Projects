<h><center><b>Current Threshold Values</b></center></h>


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

