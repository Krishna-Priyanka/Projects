#! /usr/local/bin/perl
use DBI;
use Net::SNMP;
use Data::Dumper;
use FindBin;

# Locating the path of db.conf file.     
my$pwd=$FindBin::Bin;
my@split=split("/",$pwd);
pop(@split);
push(@split,"db2.conf");
my$originalpath=join("/",@split);
my (@names,@credentials);
my $a=0;
my ($id,$ip,$p,$c,$name);

# Credentials to access the database.
open FILE,"$originalpath" or die $!;
while(<FILE>)
{

	($names[$a],$credentials[$a])=split(/[=;]/,$_);
	$credentials[$a]=~s/^"|"$//g;
       	$a++;

}
my $host=$credentials[0];
my $port=$credentials[1];
my $database=$credentials[2];
my $username=$credentials[3];
my $password=$credentials[4];
my $driver= "mysql";



my $dsn="DBI:mysql:$database;host=$host;port=$port";

my $dbh=DBI->connect($dsn, $username, $password) 
	or die $DBI::errstr;

my $ddl="CREATE TABLE IF NOT EXISTS `lab4` (`id` int(11) NOT NULL AUTO_INCREMENT, 
					  `IP` tinytext NOT NULL,
					  `PORT` int(11) NOT NULL,
					  `COMMUNITY` tinytext NOT NULL,
					  `SYSUPTIME` tinytext NOT NULL,
					  `HITS` int(11) NOT NULL,
					  `FAILURE` int(11) NOT NULL,
					  `FAILURE1` int(11) NOT NULL, 
					  `TOTAL_REQ` int(11) NOT NULL, 
					  `TIME` mediumtext NOT NULL,
					   PRIMARY KEY (id) )
					  ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$dbh->do($ddl);

my $sth=$dbh->prepare("SELECT IP, PORT, COMMUNITY FROM `DEVICES` ");

$sth->execute() or die $DBI::errstr;


while (my @row=$sth->fetchrow_array())
{
my ($IP, $PORT, $COMMUNITY)=@row;
#Snmp session with non blocking for all the devices

my $session=Net::SNMP->session( -hostname=>"$IP:$PORT",
      			        -community=>"$COMMUNITY",
			        -nonblocking=>1,
				-timeout=>1,
			        -version=>'snmpv2c',
			        ); 

my $oid_uptime='1.3.6.1.2.1.1.3.0';

my $systemuptime=$session->get_request( -varbindlist=>[$oid_uptime],
					  -callback=>[\&uptime_callback, $IP,$PORT,$COMMUNITY,$oid_uptime],
					);
if(!defined $systemuptime)
{
 print "Irresponsive\n";
}

}

snmp_dispatcher();


sub uptime_callback
{
my $time=localtime();
my ($session,$IP,$PORT,$COMMUNITY,$oid_uptime)=@_;
my $result=$session->var_bind_list($oid_uptime);
my $sysuptime=$result->{$oid_uptime};
#If the sysuptime is defined and was in the table before
if (defined $sysuptime)
 {printf "\n systemuptime for $IP,$PORT,$COMMUNITY=$sysuptime\n";

  my $sth1=$dbh->prepare("SELECT * FROM lab4 where IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
  $sth1->execute();

            while(my $row1=$sth1->fetchrow_hashref())
                {
                    $present=1;
                }

                    if ($present!=1)
                        {
                         #If the device is not in the table, then insert it 
                                 $sth2=$dbh->prepare("INSERT INTO `lab4` (`IP`,`PORT`,`COMMUNITY`,`SYSUPTIME`, `HITS`,`FAILURE1`, `TOTAL_REQ`, `TIME`) VALUES ('$IP', '$PORT', '$COMMUNITY', '$sysuptime', '1', 0,'1', '$time')");
                                  $sth2->execute();
                         }
                    else
                          
                           {
                           #If the device is present then, select it and update its success and total 
                                    $sth3=$dbh->prepare("SELECT `HITS`, `TOTAL_REQ` FROM `lab4` WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
                                    $sth3->execute();

                                    my @row2=$sth3->fetchrow_array();
                                    my($HITS,$TOTAL_REQ)=@row2;
                                    $HITS++;
                                    $TOTAL_REQ++;

                                     $sth4=$dbh->prepare("UPDATE `lab4` SET HITS=$HITS, TOTAL_REQ=$TOTAL_REQ, FAILURE1='0' WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
                                     $sth4->execute();
                               }
  }

#for the devices with not defined sysuptime
else
{
 $sth5=$dbh->prepare("SELECT * FROM lab4 where IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth5->execute();

                    while( $row3 = $sth5->fetchrow_hashref())
                       {
                            $present=1;
                       }

                           if ($present!=1)
                                 {
                                 #For devices which are not present in table, insert them
                                     $sth6=$dbh->prepare("INSERT INTO `lab4` (`IP`,`PORT`,`COMMUNITY`,`SYSUPTIME`, `FAILURE`,`FAILURE1`,`TOTAL_REQ`, `TIME`) VALUES ('$IP', '$PORT', '$COMMUNITY', 'NOT_DEFINED', '1','1', '1', '$time')");
                                     $sth6->execute();
                                  }
                            else
                                {
                                 #For devices which are present in the table, select and update 
                                      $sth7=$dbh->prepare("SELECT `FAILURE`, `TOTAL_REQ` FROM `lab4` WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
                                   $sth7->execute();

                                   @row4=$sth7->fetchrow_array();
                                   ($FAILURE,$TOTAL_REQ1)=@row4;
                                    $FAILURE++;
                                    $TOTAL_REQ1++;

                                     $sth8=$dbh->prepare("UPDATE `lab4` SET FAILURE=$FAILURE, FAILURE1=$FAILURE,TOTAL_REQ=$TOTAL_REQ1 WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth8->execute();
                                  }
    }
}
















