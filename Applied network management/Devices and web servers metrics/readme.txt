-------------------------------------------------------------------------------------------------------------------------------------------
                                               	              DEVICES AND WEB SERVERS METRICS
-------------------------------------------------------------------------------------------------------------------------------------------

==>> This assignment folder contains twelve files. They are:
                       
server.pl					
device.pl					
backend				
index.php					 								
adddevice.php		
addserver.php		
deletedevice.php				
deleteserver.php 				
readme.txt					
Monitor.php					
getting.php
gettingserver.php

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
-> In the frontend, you can add the device or server by clicking on the respective options
-> For adding the device, you need to click the add device option and then give the ip, port and community of the device in the respective fields,
-> Then, the interfaces of the device are displayed and you may select the interfaces which you want to monitor and then select the monitor interfaces option.
-> Similarly, for adding the server, you have to select the add server option in the first page and then you have to provide the ip address of the server to add it.
-> If you want to delete the server or delete the device, you can choose the delete server for server and delete device for delelting device in the home page.
-> For deleting them, you can choose the device or server you want to delete by clicking the clicable option provided.
->After adding the device and server, you have to execute the backend using perl backend command in the terminal.
-> Then in the frontend in order to monitor the device, you can click on the moitor option in the home page and then choose the device and its interfaces to which you want to monitor and also you can choose the type of graph as hourly, daily, weekly and yearly. Then, rrd graph for the device is displayed.
-> Similarly, to monitor servers, you have to go to the monitor option and then you can choose the server and its metrics to monitor them. Then, the rrd graph for server is also displayed.
-> You can also monitor the server and devices at the same time by adding both at once.
