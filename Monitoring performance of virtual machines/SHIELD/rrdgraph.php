<?php

$path=dirname(__FILE__);
unlink("$path/day.png");
unlink("$path/week.png");
unlink("$path/month.png");
unlink("$path/year.png");


	$filename=$argv[1];
	$metric=$argv[2];
	$unit=$argv[3];
#print "$unit";
 $opts_d = array( "--start", "-1d", "--vertical-label", "$metric",
		         "DEF:bps1=$filename.rrd:$metric:AVERAGE",
		
		         "LINE1:bps1#FF0000:In traffic\\r",
			 
			 "--dynamic-labels",
			 "--title=One day graph",
	  		 "--color=BACK#CCCCCC",      
		    	 "--color=CANVAS#CCFFFF",    
		    	 "--color=SHADEB#9999CC",
		         "COMMENT:\\n",
		         "GPRINT:bps1:LAST:Last In \: %6.2lf %S$unit",
		         "COMMENT:  ", 
			
			 "GPRINT:bps1:MAX:Maximum In \: %6.2lf %S$unit",
		         "COMMENT:  ",
			 
			 "GPRINT:bps1:MIN:Minimum In \: %6.2lf %S$unit",
			 "COMMENT:  ",
			 
			 "GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S$unit",
		         "COMMENT:  ",                  
		         
		       );
#echo "This is EPIC : $path\n";

	  $ret_d = rrd_graph("day.png", $opts_d);
echo rrd_error();
 $opts_w = array( "--start", "-1w", "--vertical-label", "$metric",
		         "DEF:bps1=$filename.rrd:$metric:AVERAGE",
		
		         "LINE1:bps1#FF0000:In traffic\\r",
			 
			 "--dynamic-labels",
			 "--title=Week graph",
	  		 "--color=BACK#CCCCCC",      
		    	 "--color=CANVAS#CCFFFF",    
		    	 "--color=SHADEB#9999CC",
		         "COMMENT:\\n",
		         "GPRINT:bps1:LAST:Last In \: %6.2lf %S$unit",
		         "COMMENT:  ", 
			
			 "GPRINT:bps1:MAX:Maximum In \: %6.2lf %S$unit",
		         "COMMENT:  ",
			 
			 "GPRINT:bps1:MIN:Minimum In \: %6.2lf %S$unit",
			 "COMMENT:  ",
			 
			 "GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S$unit",
		         "COMMENT:  ",                  
		         
		       );

	  $ret_w = rrd_graph("week.png", $opts_w); 
	  
	  
	  
	  $opts_m = array( "--start", "-1m", "--vertical-label", "$metric",
		         "DEF:bps1=$filename.rrd:$metric:AVERAGE",
		
		         "LINE1:bps1#FF0000:In traffic\\r",
			 
			 "--dynamic-labels",
			 "--title=monthly graph",
	  		 "--color=BACK#CCCCCC",      
		    	 "--color=CANVAS#CCFFFF",    
		    	 "--color=SHADEB#9999CC",
		         "COMMENT:\\n",
		         "GPRINT:bps1:LAST:Last In \: %6.2lf %S$unit",
		         "COMMENT:  ", 
			
			 "GPRINT:bps1:MAX:Maximum In \: %6.2lf %S$unit",
		         "COMMENT:  ",
			 
			 "GPRINT:bps1:MIN:Minimum In \: %6.2lf %S$unit",
			 "COMMENT:  ",
			 
			 "GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S$unit",
		         "COMMENT:  ",                  
		         
		       );

	  $ret_m = rrd_graph("month.png", $opts_m); 
	  
	  $opts_y = array( "--start", "-1y", "--vertical-label", "$metric",
		         "DEF:bps1=$filename.rrd:$metric:AVERAGE",
		
		         "LINE1:bps1#FF0000:In traffic\\r",
			 
			 "--dynamic-labels",
			 "--title=yearly  graph",
	  		 "--color=BACK#CCCCCC",      
		    	 "--color=CANVAS#CCFFFF",    
		    	 "--color=SHADEB#9999CC",
		         "COMMENT:\\n",
		         "GPRINT:bps1:LAST:Last In \: %6.2lf %S$unit",
		         "COMMENT:  ", 
			
			 "GPRINT:bps1:MAX:Maximum In \: %6.2lf %S$unit",
		         "COMMENT:  ",
			 
			 "GPRINT:bps1:MIN:Minimum In \: %6.2lf %S$unit",
			 "COMMENT:  ",
			 
			 "GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S$unit",
		         "COMMENT:  ",                  
		         
		       );

	  $ret_y = rrd_graph("year.png", $opts_y);



?>
