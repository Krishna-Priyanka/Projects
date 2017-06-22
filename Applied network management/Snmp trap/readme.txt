---------------------------------------------------------------------------------------------------------------------------------------------
                             SNMP TRAP 
---------------------------------------------------------------------------------------------------------------------------------------------

==>> This folder contains three files. They are:
index.php
readme.txt
trapDaemon.pl

==>> REQUIREMENTS/INSTALLATIONS:

Before starting with installations, execute following commands.
	# sudo apt-get update
	# sudo apt-get upgrade

-> Web Server:
	# sudo apt-get install apache2
	
-> PHP:
	# sudo apt-get install php5 libapache2-mod-php5
	# sudo apt-get install php5-cli php5-dev
	# sudo apt-get install mysql-server
	# sudo apt-get install php5-mysql
	# sudo apt-get install php5-snmp
	# sudo apt-get install sqlite php5-sqlite

Restart the web server using the command, 
	# sudo service apache2 restart

-> MySQL: 
	# sudo apt-get install mysql-server (Enter the password for MySQL root user during installation)
	# sudo service mysql restart 

	Also install 
	# sudo apt-get install php5-mysql

-> RRD Tool:
	# sudo apt-get install rrdtool
	# sudo apt-get install php5-rrd

-> SNMP:
	# sudo apt-get install snmp 
	# sudo apt-get install snmpd

-> Net-SNMP:
	# wget http://sorceforge.net/projects/net-snmp/files/net-snmp/5.4.4/net-snmp-5.4.4.tar.gz
	# tar -xvzf net-snmp-5.4.4.tar.gz
	# sudo apt-get install libperl-dev
	# cd net-snmp-5.4.4
	# ./configure
	# make
	# sudo make install
	# > echo export LD_LIBRARY_PATH=/usr/local/lib >> .bashrc
	# cd perl
	# perl Makefile.PL
	# make
	# sudo make install

-> PERL Modules:
	# sudo cpan (cpan command line opens)
		upgrade (exit after completed)
	# sudo perl -MCPAN -e "install DBI"
	# sudo apt-get install librrds-perl
	# sudo apt-get install libnet-snmp-perl
	# sudo apt-get install libperl-dev
	# sudo apt-get install libsnmp-dev
	# sudo perl -MCPAN -e "install RRD::Editor"
	# sudo perl -MCPAN -e "install RRD::Simple"
	# sudo perl -MCPAN -e "install Net::SNMP"
	# sudo perl -MCPAN -e "install LWP::Simple"

==>> Procedure:
-> Add the following lines to this file /etc/snmp/snmtrapd.conf:
   disableAuthorization yes
   #doNotLogTraps yes
   snmpTrapdAddr udp:50162
   traphandle 1.3.6.1.4.1.41717.10.* perl /var/www/et2536-sakc15/assignment3/trapDaemon.pl
-> Edit the file as following
   TRAPDRUN=no to TRAPDRUN=yes
-> Restart snmpd service using this command. sudo service snmpd restart.
-> Add the details of the device in the frontend(/localhost/et2536-sakc15/assignment3/index.php/)
-> Execute the following command in the terminal
   sudo snmptrap -v 1 -c public 192.168.0.17:50162 .1.3.6.1.4.1.41717.10 192.168.1.1 6 247 '' .1.3.6.1.4.1.41717.10.1 s "orange" .1.3.6.1.4.1.41717.10.2 i 3
-> Return to frontend to check the status.



 


