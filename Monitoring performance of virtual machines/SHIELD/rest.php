<?php

header ('Content-Type:application/json');




$metric = $_GET[resource];
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

if(!empty($metric))
{
	$sel = "SELECT * FROM DEVICES";
	$query = mysql_query($sel);
	echo "ID,"."IP,"."username,"."VM,"."$metric"."\n";
	while($fetch = mysql_fetch_array($query))
	{
		if(!empty($fetch['VMname']))
		{
			
		
		echo json_encode($fetch['ID']);
		echo json_encode($fetch['IP']);
		echo json_encode($fetch['Username']);
		echo json_encode($vm);
		echo json_encode($fetch["$metric"]);
		echo "\n";
		}
		else
		{
			echo json_encode($fetch['ID']);
			echo json_encode($fetch['IP']);
			echo json_encode($fetch['Username']);
			echo json_encode($fetch["$metric"]);
			echo "\n";	
		}
	}
}
else
{
	echo json_encode("No entry found"."\n");
}
?>
