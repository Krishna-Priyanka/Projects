---------------------------------------------------------------------------------------------------------------------------------------------
                        SCALE
---------------------------------------------------------------------------------------------------------------------------------------------
==>> This assignment folder contains five files. They are:
backend
backend.pl
index.php
lab4.php
readme.txt

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
->In this assignment, you need to execute the backend script by typing perl backend command in the terminal in order to find the non responsive devices.
-> In the frontend you can find the devices which are reponding and which are not responding based on the colour codes.
->By, clicking on the respective device you can view th estatistics of the device like the ip, port, community, successful requests, failed requets, total requests and also the sysuptime.

