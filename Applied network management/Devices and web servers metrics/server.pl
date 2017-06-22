use LWP::Simple;
use RRD::Simple ();
use DBI;
use Cwd 'abs_path';

$cwd = abs_path(__FILE__);

@finding = split('/', $cwd);
splice @finding, -2;
push(@finding, 'db.conf');
$realpath = join('/', @finding);

require "$realpath";
my $driver = "mysql";

my $dsn = "DBI:$driver:$database:$host:$port";

my $dbh = DBI->connect($dsn, $username, $password ) or die $DBI::errstr;
my $sth = $dbh->prepare("SELECT server FROM lab2_server ");
$sth->execute() or die $DBI::errstr;
while (my @row = $sth->fetchrow_array()) 
{
   my ($ser ) = @row;
my($url)="http://$ser/server-status?auto";
my($server_status)=get($url);
my($total_accesses,$total_kbytes,$cpuload,$uptime, $reqpersec,$bytespersec,$bytesperreq,$busyservers, $idleservers);

if (! $server_status) {
print "Can't access $url\nCheck apache configuration\n\n";

}

$cpuload = $1 if ($server_status =~ /CPULoad:\ ([\d|\.]+)/gi);
$uptime = $1 if ($server_status =~ /Uptime:\ ([\d|\.]+)/gi);
$reqpersec = $1 if ($server_status =~ /ReqPerSec:\ ([\d|\.]+)/gi);
$bytespersec = $1 if ($server_status =~ /BytesPerSec:\ ([\d|\.]+)/gi);
$bytesperreq = $1 if ($server_status =~ /BytesPerReq:\ ([\d|\.]+)/gi);
#$cpuusage=$cpuload*$uptime/100;
print "uptime $uptime";
print "cpuload $cpuload";
#print "cpu usage $cpuusage\n";
my $file = "server$ser.rrd";
if(!-e $file){
							my $rrd = RRD::Simple->new( file => "$file" );
							push(@add1,("cpuload" => "GAUGE"), ("requestspersec" => "GAUGE"),("transfbytespersec" => "GAUGE"), ("bytesperrequest" =>"GAUGE"));
							$rrd->create($file,"year",@add1);
							}
							else{print "file alreasy exists";}
							
							push(@add2,("cpuload" => "$cpuload"), ("requestspersec" => "$reqpersec"),("transfbytespersec" => "$bytespersec"), ("bytesperrequest" => "$bytesperreq"));

my $x1=time();
my $rrd = RRD::Simple->new( file => "$file" );
			$rrd->update("$file",$x1,@add2);		
			print "updated $file\n";
			}
