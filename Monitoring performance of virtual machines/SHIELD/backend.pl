#!usr/bin/perl 
use Net::OpenSSH;
use IPC::System::Simple qw(capture);
use DBI;
use DBD::mysql;
use Data::Dumper;
use RRD::Simple;

require 'db1.conf';

$dsn = "DBI:mysql:$database";
$dbh = DBI->connect($dsn,$user,$pwd);

 
  $sth = $dbh->prepare("SELECT * FROM DEVICES");
  $sth->execute;

while($ary_ref = $sth->fetchrow_arrayref())
{

 $ipaddres=$$ary_ref[1];
 $username=$$ary_ref[2];
 $password=$$ary_ref[3];
 $vmname=$$ary_ref[4];

  if($$ary_ref[4])
    {

					my $ssh = Net::OpenSSH->new($ipaddres, user => "$username", password => "$password");
						$ssh->error and
							next;


					my @cmd=$ssh->capture("virt-top --stream -n 2 | grep '$vmname' | awk '{print \$7}'");
					my @cmd1=$ssh->capture("virt-top --stream -n 2 | grep '$vmname' | awk '{print \$8}'");
					my @net = $ssh->capture("virt-top --stream -n 2 | grep '$vmname' | awk '{print \$5}'");
					my @net1 = $ssh->capture("virt-top --stream -n 2 | grep '$vmname' | awk '{print \$6}'");
					my @net2 = $ssh->capture("virt-top --stream -n 2 | grep '$vmname' | awk '{print \$2+\$3}'");


					print "$cmd[1]\n";
					print "$cmd1[1]\n";
					print "$net[1]\n";
					print "$net1[1]\n";
					print "$net2[1]\n";
          

					$cmd[1] =~ s/\,/./g;
					$cmd1[1] =~ s/\,/./g;
					$net[1] =~ s/\,/./g;
					$net1[1] =~ s/\,/./g;
					$net2[1] =~ s/\,/./g;


					$cpu=$cmd[1];
					$memory=$cmd1[1];
					$networkinput=$net[1];
					$networkoutput=$net1[1];
					$disk=$net2[1];

					chomp($cpu);
					chomp($memory);
					chomp($networkinput);
					chomp($networkoutput);
					chomp($disk);
print "****************************\n";
					print "$cpu\n"; 
					print "$memory\n";
					print "$networkinput\n";
					print "$networkoutput\n";
					print "$disk\n";
print "****************************\n";

					my $sth = $dbh->prepare("UPDATE DEVICES  SET cpu = '$cpu' WHERE VMname = '$vmname' AND IP = '$ipaddres'");
					my $srh = $dbh->prepare("UPDATE DEVICES  SET memory = '$memory' WHERE VMname = '$vmname' AND IP = '$ipaddres'");
					my $seh = $dbh->prepare("UPDATE DEVICES  SET networkinput = '$networkinput' WHERE VMname = '$vmname' AND IP = '$ipaddres'");
					my $swh = $dbh->prepare("UPDATE DEVICES  SET networkoutput = '$networkoutput' WHERE VMname = '$vmname' AND IP = '$ipaddres'");
					my $sqh = $dbh->prepare("UPDATE DEVICES  SET disk = '$disk' WHERE vmname = '$vmname' AND IP = '$ipaddres'");


					$sth->execute() or die $DBI::errstr;
					$srh->execute() or die $DBI::errstr;
					$seh->execute() or die $DBI::errstr;
					$swh->execute() or die $DBI::errstr;
					$sqh->execute() or die $DBI::errstr;

					print "Number of rows updated :";

					$sth->finish();
					$srh->finish();
					$seh->finish();
					$swh->finish();
					$sqh->finish();
$ssh->capture("exit");

					chomp($vmname);
					$filename = "$username-$ipaddres-$vmname.rrd";
					 

					my $rrd = RRD::Simple->new(
									 file => $filename,
									 rrdtool => "/var/www/html/SHIELD/",
									 default_dstype => "GAUGE",
									 on_missing_ds => "add",
							 );
					unless (-e $filename )
					{
						$rrd->create(
										   cpuusage => "GAUGE",
										   memoryusage => "GAUGE",
										   inputnetworkusage => "GAUGE",
										   outputnetworkusage => "GAUGE",
										   diskusage => "GAUGE",
						 );
					}

						 $rrd->update(
										  cpuusage => $cpu,
										  memoryusage => $memory,
										  inputnetworkusage => $networkinput,
										  outputnetworkusage => $networkoutput,
										  diskusage => $disk,
					);

					 my $info = $rrd->info($filename);
					 
						}
  

 else
{

my $ssh = Net::OpenSSH->new($ipaddres, user => "$username", password => "$password");
  $ssh->error and
    next;


my @cmd=$ssh->capture("top -b -n 2 | sed '3q;d' | awk '{print \$2+\$3}'");
my @cmd1=$ssh->capture("free -m | grep 'Mem' | awk '{print \$3/\$2}'");
my @cmd2=$ssh->capture("netstat -i | grep 'eth0' | awk '{print \$4}'");
my @cmd3=$ssh->capture("netstat -i | grep 'eth0' | awk '{print \$8}'");
my @cmd4=$ssh->capture("iostat -d | grep 'sda' | awk '{print \$2}'");
$ssh->capture("exit");

chomp $cmd[0];
chomp $cmd1[0];
chomp $cmd2[0];
chomp $cmd3[0];
chomp $cmd4[0];

print "@cmd \n";
print "@cmd1 \n";
print "@cmd2 \n";
print "@cmd3 \n";
$cmd4[0] =~ s/\,/./g;
print "$cmd4[0] \n";

my $sth = $dbh->prepare("UPDATE DEVICES  SET cpu = '$cmd[0]' WHERE IP = '$ipaddres' AND VMname = ''");
my $srh = $dbh->prepare("UPDATE DEVICES  SET memory = '$cmd1[0]' WHERE IP = '$ipaddres' AND VMname = ''");
my $seh = $dbh->prepare("UPDATE DEVICES  SET networkinput = '$cmd2[0]' WHERE IP = '$ipaddres' AND VMname = ''");
my $swh = $dbh->prepare("UPDATE DEVICES  SET networkoutput = '$cmd3[0]' WHERE IP = '$ipaddres' AND VMname = ''");
my $sqh = $dbh->prepare("UPDATE DEVICES  SET disk = '$cmd4[0]' WHERE IP = '$ipaddres' AND VMname = ''");

$sth->execute() or die $DBI::errstr;
$srh->execute() or die $DBI::errstr;
$seh->execute() or die $DBI::errstr;
$swh->execute() or die $DBI::errstr;
$sqh->execute() or die $DBI::errstr;

print "Number of rows updated :";

$sth->finish();
$srh->finish();
$seh->finish();
$swh->finish();
$sqh->finish();

 $filename = "$username-$ipaddres.rrd";

my $rrd = RRD::Simple->new(
         file => $filename,
         rrdtool => "/var/www/html/SHIELD/",
         default_dstype => "GAUGE",
         on_missing_ds => "add",
     );

unless (-e $filename )
  {
  $rrd->create($filename ,
             cpuusage => "GAUGE",
             memoryusage => "GAUGE",
             inputnetworkusage => "GAUGE",
             outputnetworkusage => "GAUGE",
             diskusage => "GAUGE",   
   );
   } 

 $rrd->update($filename ,
             cpuusage => $cmd[0],
             memoryusage => $cmd1[0],
             inputnetworkusage => $cmd2[0],
             outputnetworkusage => $cmd3[0],
             diskusage => $cmd4[0],        
   );

 my $info = $rrd->info($filename);
 print Dumper $info;
  }

}
