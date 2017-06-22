#!/usr/bin/perl 
use DBI;
use Mail::Sender;

require 'db1.conf';

$dsn="DBI:mysql:$database";
$dbh=DBI->connect($dsn,$user,$pwd);

        $query = $dbh->prepare("SELECT * FROM `thresholds`");
        $query->execute;

@row=$query->fetchrow_array();

       	$cpu_max=$row[4];
	$mem_max=$row[6];
	$network_input_max=$row[8];
        $network_ouput_max=$row[10];
        $disk_max=$row[12];
	
$res = "SELECT * FROM DEVICES";
$query1 = $dbh->prepare($res);
$query1->execute;

while (@row1=$query1->fetchrow_array())
{

	$cpu_usage = $row1[5];
	$memory_usage = $row1[6];
	$input_network = $row1[7];
        $output_network = $row1[8];
        $disk_usage = $row1[9];


if($cpu_usage>$cpu_max || $memory_usage>$mem_max || $input_network>$network_input_max || $output_network>$network_ouput_max || $disk_usage>$disk_max )
	{
		
	$query_select ="SELECT * FROM `thresholds`";
        $query = $dbh->prepare($query_select);
        $query->execute;

@row=$query->fetchrow_array();
$email=$row[11];
print "this is $email.\n";


    my $sender = new Mail::Sender
 {
            auth => 'LOGIN',
            authid => 'rakb15@student.bth.se',
            authpwd => 'p87XjZFX',
            smtp => 'smtp.office365.com',
            port => 587,
            from => 'rakb15@student.bth.se',
            to => $email,
            subject => 'Alert',
            msg => 'A device in the data centre is in critical state, it is displayed in the frontend page under Device Status in RED colour',
            
    };

    #my $result =  $sender->MailFile({
    my $result =  $sender->MailMsg({
            msg => $sender->{msg},
            #file => $sender->{file},

    });
    
    print "$sender->{error_msg}\n>>>End.\n";
    
}
}
