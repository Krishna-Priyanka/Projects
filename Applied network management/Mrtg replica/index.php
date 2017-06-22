<html>
<head><style>
h1 {text-align:center;}
img {
    float: right;
    margin: 0 0 10px 10px;
}
#picture {
		float:left;
	}
	
</style></head>
<body>
<h1>ANM ASSIGNMENT 1</h1>
<?php

require "find.php";
// Create connection
$conn = mysqli_connect($host,$username, $password,$database,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

$sql = "SELECT IP, PORT, COMMUNITY,interfaces,interfacename,sysname,sysuptime,syscontact,syslocation,sysdescr FROM lab1";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
        //echo "ip: " . $row["IP"]. " port: " . $row["PORT"]. " community" . $row["COMMUNITY"]."interfaces".$row["interfaces"]."\n";
        $ip=$row["IP"];
        $port=$row["PORT"];
        $community=$row["COMMUNITY"];
        $interface=$row["interfaces"];
        $interfacename=$row["interfacename"];
        $sysuptime=$row["sysuptime"];
        $syscontact=$row["syscontact"];
        $syslocation=$row["syslocation"];
        $sysdescr=$row["sysdescr"];
        $sysname=$row["sysname"];
        $pieces = explode(":", $interface);
        $excies = explode(":", $interfacename);
							if (empty($interface))
							{		
									
								}
								else
									
{
	
							foreach($pieces as $i => $value)
									{ 
echo "<div id='picture'>";
									$z=$pieces[$i];
									$d=$excies[$i];

									create_graphd($ip,$port,$community,$z,"day$ip$port$community-$z.png", "-1d", "Daily graph-$ip-$port-$community-".' '."$z");
		
echo"<form id = \"login\" method = \"POST\" action = \"nextindex.php\">";
									
									
									echo "<h3> #$d $ip$community$sysname</h3></br>";
									echo "<button form = \"login\" type=\"submit\" name = \"login\" style='float: left' value=\"$ip+$port+$community+$z+$sysuptime+$syscontact+$syslocation+$sysdescr+$sysname+$d\"><img src='day$ip$port$community-$z.png' height='180' width='500' alt='Generated RRD image' style='float: left'></button>";
									
									
									
	echo"</form>"	;	
echo "</div>";						
}
									}
									
								
			}
}		
else {
    echo "0 results";
}
	
function create_graphd($ip,$port,$community,$f,$output, $start, $title) {

$file = "device$ip$port$community.rrd";
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
    "--x-grid",
					"HOUR:1:HOUR:2:HOUR:2:0:%H",
					"--units=si", 
					"--grid-dash", "1:3", "--alt-autoscale-max","--lower-limit","0",
					"--vertical-label=Bytes per Second",
					"DEF:inBytes=$file:bytesIn$f:AVERAGE",
					"DEF:outBytes=$file:bytesOut$f:AVERAGE",
					"VDEF:avg_in=inBytes,AVERAGE",
					"VDEF:avg_out=outBytes,AVERAGE",
					"VDEF:last_in=inBytes,LAST",
					"VDEF:last_out=outBytes,LAST",
					"VDEF:max_in=inBytes,MAXIMUM",
					"VDEF:max_out=outBytes,MAXIMUM",
				//	"CDEF:base_line=outBytes, 0, UN, outBytes, IF",
					"CDEF:incdef=inBytes,8,*",
					"CDEF:outcdef=outBytes,8,*",
					"COMMENT: \\n",
					"COMMENT: \\t",
					"COMMENT: \\tMAXIMUM\\t",
					"COMMENT:  AVERAGE\\t",
					"COMMENT:  LAST\\n",
					"AREA:inBytes#00FF00:In traffic\\t",
					"GPRINT:max_in: %6.2lf %sB/s\\t",
					"GPRINT:avg_in: %6.2lf %sB/s\\t",
					"GPRINT:last_in: %6.2lf %sB/s\\n",
					"LINE1:outBytes#0000FF:Out traffic\\t",
					"GPRINT:max_out: %6.2lf %sB/s\\t",
					"GPRINT:avg_out: %6.2lf %sB/s\\t",
					"GPRINT:last_out: %6.2lf %sB/s\\n",
    
  );

  $ret = rrd_graph($output, $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
}



?>
</body>
</html>
