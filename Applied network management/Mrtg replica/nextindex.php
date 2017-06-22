<html>

<body>

<?php
//$ip="demo.snmplabs.com";
//$community="public";
//$f=array(1,2,3);
//$i=count($f);
//foreach($f as $i => $value){
//$z=$f[$i];
$x= $_POST["login"];
//echo $x."\n";
list($ip,$port,$community,$z,$sysuptime,$syscontact,$syslocation,$sysdescr,$sysname,$ifname) = explode("+", $x);
echo "<h2><font color=\"#8f2f2f\">Traffic Analysis for #$ifname -- $ip -- $community---$sysname</font></h2>";
echo "<table>";
echo "<tr><td>";
echo "<b>System Name:<b></td>"."<td>".$sysname."</td></tr>";
echo "<tr><td>";
echo "<b>Maintainer:<b>"."<td>".$syscontact."</td></tr>";
echo "<tr><td>";
echo "<b>System location:<b>"."<td>".$syslocation."</td></tr>";

echo "<tr><td>";
echo "<b>ifName:<b>"."<td>".$ifname."</td></tr>";
echo "</table>";
//create_graphh($ip,$community,$z,"hour$ip$port$community-$z.png", "-1h", "Hourly $ip-$community-$z");
create_graphd($ip,$port,$community,$z,"day$ip$port$community-$z.png", "-1d", "Daily graph$ip-$community-$z");
create_graphw($ip,$port,$community,$z,"week$ip$port$community-$z.png", "-1w", "Weekly graph$ip-$community-$z");
create_graphm($ip,$port,$community,$z,"month$ip$port$community-$z.png", "-1m", "Monthly graph$ip-$community-$z");
create_graphy($ip,$port,$community,$z,"year$ip$port$community-$z.png", "-1y", "Yearly graph$ip-$community-$z");
echo "<h2>`Daily' Graph (5 Minute Average)</h2>";
echo "<table>";
echo "<tr><td>";
echo "<img src='day$ip$port$community-$z.png' alt='Generated RRD image'>";
echo "</td></tr>";
echo "</table>";
echo "<table>";
echo "<h2>`Weekly' Graph (30 Minute Average)</h2>";
echo "<tr><td>";
echo "<img src='week$ip$port$community-$z.png' alt='Generated RRD image'>";
echo "</td></tr>";
echo "</table>";
echo "<table>";
echo "<h2>`Monthly' Graph (2 Hour Average)</h2>";
echo "<tr><td>";
echo "<img src='month$ip$port$community-$z.png' alt='Generated RRD image'>";
echo "</td></tr>";
echo "</table>";
echo "<table>";
echo "<h2>`Yearly' Graph (1 Day Average)</h2>";
echo "<tr><td>";
echo "<img src='year$ip$port$community-$z.png' alt='Generated RRD image'>";
echo "</td></tr>";
echo "</table>";
echo "<form action=\"index.php\">";
echo "<button>back</button>";
echo "</form>";
#exit;

/*
function create_graphh($ip,$port,$community,$f,$output, $start, $title) {
$file = "device$ip$port$community.rrd";
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
    //"--x-grid",
					//"HOUR:1:HOUR:2:HOUR:2:0:%H",
					"--units=si", "--grid-dash", "1:3", "--alt-autoscale-max","--lower-limit","0",
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
					"COMMENT:   LAST\\n",
					"AREA:inBytes#00FF00:In traffic\\t",
					"GPRINT:max_in: %6.2lf %SBps\\t",
					"GPRINT:avg_in: %6.2lf %SBps\\t",
					"GPRINT:last_in: %6.2lf %SBps\\n",
					"LINE1:outBytes#0000FF:Out traffic\\t",
					"GPRINT:max_out: %6.2lf %SBps\\t",
					"GPRINT:avg_out: %6.2lf %SBps\\t",
					"GPRINT:last_out: %6.2lf %SBps\\n",
    
  );

  $ret = rrd_graph($output, $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
}*/
function create_graphd($ip,$port,$community,$f,$output, $start, $title) {
$file = "device$ip$port$community.rrd";
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
   // "--x-grid",
					//"HOUR:1:HOUR:2:HOUR:2:0:%H",
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
					"COMMENT:   LAST\\n",
					"AREA:inBytes#00FF00:In traffic\\t",
					"GPRINT:max_in: %6.2lf %SB/s\\t",
					"GPRINT:avg_in: %6.2lf %SB/s\\t",
					"GPRINT:last_in: %6.2lf %SB/s\\n",
					"LINE1:outBytes#0000FF:Out traffic\\t",
					"GPRINT:max_out: %6.2lf %SB/s\\t",
					"GPRINT:avg_out: %6.2lf %SB/s\\t",
					"GPRINT:last_out: %6.2lf %SB/s\\n",
    
  );

  $ret = rrd_graph($output, $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
}
function create_graphw($ip,$port,$community,$f,$output, $start, $title) {
$file = "device$ip$port$community.rrd";
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
   //"--x-grid",
					//"HOUR:1:HOUR:2:HOUR:2:0:%H",
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
					"COMMENT:   LAST\\n",
					"AREA:inBytes#00FF00:In traffic\\t",
					"GPRINT:max_in: %6.2lf %SB/s\\t",
					"GPRINT:avg_in: %6.2lf %SB/s\\t",
					"GPRINT:last_in: %6.2lf %SB/s\\n",
					"LINE1:outBytes#0000FF:Out traffic\\t",
					"GPRINT:max_out: %6.2lf %SB/s\\t",
					"GPRINT:avg_out: %6.2lf %SB/s\\t",
					"GPRINT:last_out: %6.2lf %SB/s\\n",
    
  );

  $ret = rrd_graph($output, $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
}
function create_graphm($ip,$port,$community,$f,$output, $start, $title) {
$file = "device$ip$port$community.rrd";
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
   //"--x-grid",
					//"HOUR:1:HOUR:2:HOUR:2:0:%H",
					"--units=si", "--grid-dash", "1:3", "--alt-autoscale-max","--lower-limit","0",
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
					"COMMENT:   LAST\\n",
					"AREA:inBytes#00FF00:In traffic\\t",
					"GPRINT:max_in: %6.2lf %SB/s\\t",
					"GPRINT:avg_in: %6.2lf %SB/s\\t",
					"GPRINT:last_in: %6.2lf %SB/s\\n",
					"LINE1:outBytes#0000FF:Out traffic\\t",
					"GPRINT:max_out: %6.2lf %SB/s\\t",
					"GPRINT:avg_out: %6.2lf %SB/s\\t",
					"GPRINT:last_out: %6.2lf %SB/s\\n",
    
  );

  $ret = rrd_graph($output, $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
}
function create_graphy($ip,$port,$community,$f,$output, $start, $title) {
$file = "device$ip$port$community.rrd";
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
    //"--x-grid",
					//"HOUR:1:HOUR:2:HOUR:2:0:%H",
					"--units=si", "--grid-dash", "1:3", "--alt-autoscale-max","--lower-limit","0",
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
					"COMMENT:   LAST\\n",
					"AREA:inBytes#00FF00:In traffic\\t",
					"GPRINT:max_in: %6.2lf %SB/s\\t",
					"GPRINT:avg_in: %6.2lf %SB/s\\t",
					"GPRINT:last_in: %6.2lf %SB/s\\n",
					"LINE1:outBytes#0000FF:Out traffic\\t",
					"GPRINT:max_out: %6.2lf %SB/s\\t",
					"GPRINT:avg_out: %6.2lf %SB/s\\t",
					"GPRINT:last_out: %6.2lf %SB/s\\n",
    
  );

  $ret = rrd_graph($output, $options);
  if (! $ret) {
    echo "<b>Graph error: </b>"."\n".rrd_error()."\n";
  }
}


?>
</body>
</html>
