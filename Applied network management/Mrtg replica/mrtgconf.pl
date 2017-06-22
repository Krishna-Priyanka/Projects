#!/usr/bin/perl
use DBI;
use Net::SNMP;
use Net::SNMP::Interfaces;
use RRD::Simple;
use Data::Dumper;
use FindBin;

# Locating the path of db.conf file.     
my$pwd=$FindBin::Bin;
my@split=split("/",$pwd);
pop(@split);
push(@split,"db.conf");
my$originalpath=join("/",@split);
my (@names,@credentials);
my $a=0;
my ($id,$ip,$p,$c,$name);

# Open & Reads the credential datafile to access the devices table.
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
my $driver = "mysql";
my $dsn = "DBI:mysql:database=$database;host=$host;port=$port";
my $dbh = DBI->connect($dsn, $username, $password) 
	or die $DBI::errstr;


my $sth = $dbh->prepare("SELECT IP, PORT, COMMUNITY FROM `DEVICES` ");

$sth->execute() or die $DBI::errstr;

system ("mkdir /etc/mrtg ");
system ("mv /etc/mrtg.cfg /etc/mrtg");
open(my $file, '>', "/var/www/mrtg/index.html");
$str="";
while (my ($IP, $PORT, $COMMUNITY)=$sth->fetchrow_array())
{
$str.="$COMMUNITY\@$IP:$PORT ";
}	

system (`cfgmaker --global "WorkDir: /var/www/mrtg" --global "Options[_]: growright,bits" --global "RunAsDaemon: Yes" --global "Interval: 5" --output=/etc/mrtg/mrtg.cfg $str `);
system ("mkdir /var/www/mrtg");

system ("indexmaker --output=/var/www/mrtg/index.html /etc/mrtg/mrtg.cfg");
system ("env LANG=C /usr/bin/mrtg /etc/mrtg/mrtg.cfg --logging /var/log/mrtg.log");

$|=1; 

