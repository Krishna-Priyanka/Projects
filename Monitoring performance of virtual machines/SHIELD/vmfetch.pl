#!usr/bin/perl 
use Net::OpenSSH;
use IPC::System::Simple qw(capture);
use DBI;
use Data::Dumper;
use RRD::Simple;
use FindBin qw($Bin);
require "$Bin/db1.conf";

$dsn = "DBI:mysql:$database";
$dbh = DBI->connect($dsn,$user,$pwd);

  $sth = $dbh->prepare("SELECT * FROM DEVICES where `VMname`= '' ");
  $sth->execute;

while($ary_ref = $sth->fetchrow_arrayref())
{
 $ipaddres=$$ary_ref[1];
 $username=$$ary_ref[2];
 $password=$$ary_ref[3];

my $ssh = Net::OpenSSH->new(host => "$ipaddres", user => "root", password => "$password");
  $ssh->error and
    next;

my @line = $ssh->capture("virsh list | awk '{print \$2}'"); 

$ssh->capture("exit");


  $sth1 = $dbh->prepare("SELECT * FROM `DEVICES` where `IP`='$ipaddres' AND `Username`='$username' AND `Password`='$password'");
  $sth1->execute;
  @VMname_mysql = qw();
  while($ary_ref1 = $sth1->fetchrow_arrayref())
  {
   push (@VMname_mysql,$$ary_ref1[4]);
  }

map (chomp($_),@line);
splice (@line,0,2);
pop(@line);

  foreach (@line)
  {
print "$_\n";
   if("$_"~~@VMname_mysql)
   {
    print "NO ENTRY";
   }
   else
   {
     $dbh1= "INSERT INTO DEVICES (IP,Username,Password,VMname) VALUES ('$ipaddres','$username','$password','$_')";
     $dbh->do($dbh1);
     #$dbh2= "DELETE FROM DEVICES WHERE VMName='$line[1]'";
     #$dbh->do($dbh2); 
    # $dbh3= "DELETE FROM DEVICES WHERE VMName='$line[0]'";
   #  $dbh->do($dbh3);
     print "DONE\n";
   }
  }
}
 
$!=1;
