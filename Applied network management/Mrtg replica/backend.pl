#!/usr/bin/perl
use DBI;
use Net::SNMP qw(snmp_dispatcher oid_lex_sort);
use RRD::Simple ();
use Data::Dumper qw(Dumper);
use Cwd 'abs_path'; 

#database connect
$cwd = abs_path(__FILE__);

#Finding the path to db.conf
@finding = split('/', $cwd);
splice @finding, -2;
push(@finding, 'db.conf');
$realpath = join('/', @finding);

require "$realpath";
my $driver = "mysql";

my $dsn = "DBI:$driver:$database:$host:$port";

my $dbh = DBI->connect($dsn, $username, $password ) or die $DBI::errstr;

# table creating
my $ifTableIndex = '1.3.6.1.2.1.2.2.1.1';
my $sth= $dbh->do("CREATE TABLE IF NOT EXISTS lab1
(IP varchar(255) NOT NULL ,
PORT int NOT NULL,
COMMUNITY varchar(255) NOT NULL,
sysuptime TINYTEXT NOT NULL ,
syscontact TINYTEXT NOT NULL,
syslocation TINYTEXT NOT NULL ,
sysdescr TINYTEXT NOT NULL,
sysname TEXT NOT NULL,
interfaces TEXT NOT NULL,
interfacename TEXT NOT NULL,
UNIQUE KEY(IP,PORT,COMMUNITY)
) ;");

my $i=0;
my $x=0;
my %devices;
my %details;

#database fetching
my $sth = $dbh->prepare("SELECT IP, PORT, COMMUNITY FROM DEVICES ");
$sth->execute() or die $DBI::errstr;
while (my @row = $sth->fetchrow_array()) 
{
   my ($ip, $port, $community ) = @row;
	$devices{"device$ip$port$community"}{ip}   = $ip;
	 $devices{"device$ip$port$community"}{port}    = $port;
	 $devices{"device$ip$port$community"}{community}   = $community;
   print $ip."\n";
   my $sth2 = $dbh->prepare("INSERT IGNORE INTO lab1 (IP,PORT,COMMUNITY) values ('$ip','$port','$community')");
			$sth2->execute() or die $DBI::errstr;
			$sth2->finish();
		$i++;
#SNMP session 
								my ($session, $error) = Net::SNMP->session(
									 -hostname    =>  $ip,
									 -community   =>  $community,
									 -port        =>  $port,
									 -nonblocking =>  1,
									 -version     =>  'snmpv2c',
								);
		$details{"device$ip$port$community"}{'sess'}=$session;

				if (!defined($session)) 
				{
					 printf("ERROR: %s.\n", $error);
					next;
				}
				my $result = $session->get_table(-baseoid  => $ifTableIndex,
                                 -callback => [\&print_results_cb, $ip, $port, $community]);
                                
				if (!defined($result))
				{
					 printf "ERROR: Failed to queue get request for host '%s': %s.\n",
								     $session->hostname(), $session->error();
				}
}

snmp_dispatcher();

my @keys = keys %devices;
foreach my $p (@keys){
my $j=0;
my $k=0;
my @y;
my @ifname;
my @oid_ifInOctets;
my @oid_ifOutOctets;
my @subject =keys % {$devices{$p}{"interface"}} ;
foreach my $q (@subject)
       {
           if($devices{$p}{"ifall"}{"1.3.6.1.2.1.2.2.1.3.$q"} != 24 && $devices{$p}{"ifall"}{"1.3.6.1.2.1.2.2.1.8.$q"} == 1 && $devices{$p}{"ifall"}{"1.3.6.1.2.1.2.2.1.5.$q"} != 0)
           {
             $y[$j]=$q;
             $devices{$p}{"filteredinterfaces"}{"$y[$j]"}=$y[$j];
             $devices{$p}{"filterednames"}{"1.3.6.1.2.1.31.1.1.1.1.$y[$j]"}=$devices{$p}{"ifall"}{"1.3.6.1.2.1.31.1.1.1.1.$y[$j]"};
             $ifname[$j]=$devices{$p}{"ifall"}{"1.3.6.1.2.1.31.1.1.1.1.$y[$j]"};
             $oid_ifInOctets[$j]="1.3.6.1.2.1.2.2.1.10.$y[$j]"	;
           	$oid_ifOutOctets[$j]="1.3.6.1.2.1.2.2.1.16.$y[$j]";
             $j++;
           }
           }

           my @b = sort(@y);
           
          my $r=0;
           foreach my $k (@b)
           {
           $ifname[$r]=$devices{$p}{"filterednames"}{"1.3.6.1.2.1.31.1.1.1.1.$k"};
         
          	$r++;
           }
           

   				 if(@b)
						{ 
					
							my $file = "$p.rrd";
							my $rrd = RRD::Simple->new( file => "$file" );
								if(! -e $file )   
										 {my @add1;
										 	print "qwert";
											foreach (@b)
														{
											 				
														 push(@add1,("bytesIn$_" => "COUNTER"), ("bytesOut$_" => "COUNTER"));
										
															}
															print "-----------@add1----------\n";
												$rrd->create($file,"mrtg", @add1);
							
										 			 }
				 			my @oid_octet=(@oid_ifInOctets,@oid_ifOutOctets);
				 			while ((my $r=@oid_octet) > 0)
							{
							my $sess=$details{$p}{"sess"};
						 
						 															 my $result_ifOctet = $sess->get_request(
																          -varbindlist      => [splice @oid_octet, 0, 40],
																          -callback        => [ \&subroutine_ifOct,$p,\@b,\@ifname] ,    # non-blocking
																          );
																       
											if (!defined($result_ifOctet))
														{
									 						printf "ERROR: Failed to queue get request for host '%s': %s.\n",
															 $session->hostname(), $session->error();
														} 
														} 
								
								}
    	
 }
 
snmp_dispatcher();			
my @keys = keys %devices;
foreach my $p (@keys){
 my $rrd = RRD::Simple->new( file => "$p.rrd" );
 my @subject =keys % {$devices{$p}{"interface"}} ;
 my @y;
 my @add2;
 my $j=0;
 
foreach my $q (@subject)
       {
           if($devices{$p}{"ifall"}{"1.3.6.1.2.1.2.2.1.3.$q"} != 24 && $devices{$p}{"ifall"}{"1.3.6.1.2.1.2.2.1.8.$q"} == 1 && $devices{$p}{"ifall"}{"1.3.6.1.2.1.2.2.1.5.$q"} != 0)
           {
             $y[$j]=$q;
             $j++;
             
           }
           }
          
           my @b=sort (@y);
           if(@b){
           my @add2;
           
				foreach my $z (@b)
				{
				push(@add2,("bytesIn$z" => $devices{"$p"}{"ifoctet"}{"1.3.6.1.2.1.2.2.1.10.$z"}), ("bytesOut$z" => $devices{"$p"}{"ifoctet"}{"1.3.6.1.2.1.2.2.1.16.$z"}));

				}
print "--------------@add2\n";
my $x1=time();
			$rrd->update("$p.rrd",$x1,@add2);		
			}
}



sub print_results_cb
{  
	my @x=0;
   my @oid_ifType;
   my @oid_ifSpeed;
   my @oid_ifOperStatus;
   my @oid_ifName;
   my ($session, $ip, $port, $community) = @_;

   if (!defined($session->var_bind_list()))
   {
      printf("ERROR: %s.\n", $session->error());
   } 
   else 
   {
   my $i=0;
   my @x;
      foreach (oid_lex_sort(keys(%{$session->var_bind_list()})))
       {
         
         $x[$i]=$session->var_bind_list()->{$_};
         $devices{"device$ip$port$community"}{"interface"}{"$x[$i]"}=$x[$i];
         $oid_ifType[$i]="1.3.6.1.2.1.2.2.1.3.$x[$i]";
         $oid_ifOperStatus[$i]="1.3.6.1.2.1.2.2.1.8.$x[$i]";
         $oid_ifSpeed[$i]="1.3.6.1.2.1.2.2.1.5.$x[$i]"	;
         $oid_ifName[$i]="1.3.6.1.2.1.31.1.1.1.1.$x[$i]";
         $i++;
      }
		  my $OID_sysUpTime = '1.3.6.1.2.1.1.3.0';
			my $OID_sysContact = '1.3.6.1.2.1.1.4.0';
			my $OID_sysLocation = '1.3.6.1.2.1.1.6.0';
			my $OID_sysDescr=			'1.3.6.1.2.1.1.2.0';
			my $OID_sysName="1.3.6.1.2.1.1.5.0"; 
      my @oid_all=(@oid_ifType,@oid_ifOperStatus,@oid_ifSpeed,@oid_ifName,$OID_sysUpTime,$OID_sysContact,$OID_sysLocation,$OID_sysDescr,$OID_sysName);
  
				  while ((my $h=@oid_all) > 0)
				  {
				  
				  my $result_ifType = $session->get_request(
				                      -varbindlist      => [splice @oid_all, 0, 40],
				                      -callback        => [ \&subroutine_ifType, \@x, $ip, $port, $community] ,    
				                      );
				                   
				  if (!defined($result_ifType))
								{
			 						printf "ERROR: Failed to queue get request for host '%s': %s.\n",
				        	 $session->hostname(), $session->error();
								}
					}
    }
 
 snmp_dispatcher();
  }
  
  

print "\n";
sub subroutine_ifType
{
 my @y;
 my ($session, $xi, $ip, $port, $community) = @_;
 my @x = @$xi;
   my $result =  $session->var_bind_list();
   
   if (!defined $result)
    {
      printf "ERROR: Get request failed for host '%s': %s.\n",
             $session->hostname(), $session->error();
      return;
		}
		else
		{
		foreach (oid_lex_sort(keys(%{$session->var_bind_list()})))
					{
       $devices{"device$ip$port$community"}{"ifall"}{$_}=$result->{$_};
           }
      }

}

    	
   
sub subroutine_ifOct
{
my (@add1,@add2);
		my $i=0,$j=0;
			my ($sess,$p,$bi,$ifnamei) = @_;
			my $p=$p;
			my @b=@$bi;
			my @ifname=@$ifnamei;
			
           #print @ifname
			my $intf=join(':',@b);
			my $intz=join(':',@ifname);
			my $result =  $sess->var_bind_list();
			my $sysuptime=$devices{$p}{"ifall"}{"1.3.6.1.2.1.1.3.0"};
			my $syscontact =$devices{$p}{"ifall"}{"1.3.6.1.2.1.1.4.0"};
			my $sysname =$devices{$p}{"ifall"}{"1.3.6.1.2.1.1.5.0"};
			my $syslocation =$devices{$p}{"ifall"}{"1.3.6.1.2.1.1.6.0"};
			my $interfaces=$intf;
			my $sysdescr=$devices{$p}{"ifall"}{"1.3.6.1.2.1.1.2.0"};
			my $ip=$devices{$p}{"ip"};
			my $port=$devices{$p}{'port'};
			my $community=$devices{$p}{"community"};
			 if (!defined $result)
				{
				  printf "ERROR: Get request failed for host '%s': %s.\n",
				         $sess->hostname(), $sess->error();
				  return;
				}
				else
				{
				
				
				foreach (oid_lex_sort(keys(%{$sess->var_bind_list()})))
					{
		 my $sth7= $dbh->prepare("UPDATE lab1
                        SET   sysuptime='$sysuptime',syscontact ='$syscontact',
												syslocation ='$syslocation',sysname='$sysname',interfaces='$intf',interfacename='$intz',sysdescr='$sysdescr'
                         WHERE IP = '$ip' AND PORT='$port' AND COMMUNITY='$community' ");
						$sth7->execute() or die $DBI::errstr;
						$sth7->finish();
       $devices{"$p"}{"ifoctet"}{$_}=$result->{$_};
       
           }
		}			
}

