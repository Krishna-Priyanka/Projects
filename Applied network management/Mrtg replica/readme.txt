---------------------------------------------------------------------------------------------------------------------------------------------
                    MRTG REPLICA
----------------------------------------------------------------------------------------------------------------------------------------------
==>> This assignment, consists of seven files: 

mrtgconf.pl
backend
backend.pl
find.php
index.php
netindex.php
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

==>> Procedure
->In the terminal firstly run the mrtgconf.pl using perl mrtgconf.pl command
-> Simultaneously in the another tab execute backend file with perl backend command
-> In the browser, type localhost and then go to the respective assignment1 directory to view the rrd graphs
-> In order to view the in/out bytes for the interface, click on the respective interface graph.
-> Also go to the mrtg folder to view the mrtg graphhs and compare it with rrd graphs to find the correlation between them.

