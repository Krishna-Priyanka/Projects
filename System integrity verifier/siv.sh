#!/bin/bash

#To check the command using number of arguments
a="5"
if [ $# = $a ]
then

#To check the hash function
b="sha1"
c="md5"
pwd=$(pwd)
if [ \( "$5" = "$b" \) -o \( "$5" = "$c" \) ]
then

#To check if it is intialization mode
d="-i"
if [ $1 = $d ] 
then
find . -type f -name "*~" -exec rm -f {} \;
date1=$(date -u +"%s")
echo "              "
echo "                         "
echo "    ************THIS IS INITIALIZATION MODE************     "
echo "                         "
echo "                         "

#To verify that the specified monitored directory exists
echo "Directory:$2"
if [ -d "$2" ]
then
echo  "          "
echo "===>>Specified monitored directory exists"
echo "     "
else
echo "===>>Specified monitored directory does not exists"
echo " "
fi

#To verify that the specified verification file is outside the monitored directory
if [ ! -f "$2/$3" ]; then
echo "===>>Verification file is not present inside the monitored directory"
echo " "
else
echo "===>>Verification file is present inside the monitored directory"
echo "  "
fi

#To verify that the specified report file is outside the monitored directory
if [ ! -f "$2/$4" ]; then
echo "===>>Report file is not present inside the monitored directory"
echo " "
else
echo "===>>Report file is present inside the monitored directory"
echo "   "
fi

#To verify if the same name of verification file exists
if [ -f "$3" ] 
then
echo " OOPS!! Verification file with that name already exists!!! Do you want to overwrite the file?yes/no:" 
read value
e="yes"

#Initialization mode iterations for verification file
if [ $value = $e ]
then																																						
echo "---Verification File overwrites"
echo "  "
echo " ">$3
for line in $(find $2 -type f)
do
echo "$line#$(stat -c%s "$line")#$(stat -c%U "$line")#$(stat -c%G "$line")#$(stat -c%a "$line")#$(stat -c%y "$line")#$($5sum $line | awk -F" " '{print $1}')">>$3
done
for line in $(find $2 -type d)
do
echo "$line#$(stat -c%s "$line")#$(stat -c%U "$line")#$(stat -c%G "$line")#$(stat -c%a "$line")#$(stat -c%y "$line")">>$3
done

else
echo "   "
echo " "
echo "*****Please change the file name in order to proceed***** "
echo "*************GOOD BYE!! HAVE A NICE DAY************"
echo " "
echo "  "
exit 0
fi

else
echo "===>>Verification file with that name doesnot exist before so, no problem"
echo " "
echo " ">$3
for line in $(find $2 -type f)
do
echo "$line#$(stat -c%s "$line")#$(stat -c%U "$line")#$(stat -c%G "$line")#$(stat -c%a "$line")#$(stat -c%y "$line")#$($5sum $line | awk -F" " '{print $1}')">>$3
done
for line in $(find $2 -type d)
do
echo "$line#$(stat -c%s "$line")#$(stat -c%U "$line")#$(stat -c%G "$line")#$(stat -c%a "$line")#$(stat -c%y "$line")">>$3
done

fi

#To verify if the report file with the same name exists
if [ -f "$4" ] 
then
echo " OOPS!! Report file with that name already exists!!! Do you want to overwrite the file?yes/no:" 
read value
g="yes"

#Initialization mode iterations for report file
if [ $value = $g ]
then																																								
echo "---Report File overwrites"
echo " "

echo "Full pathname to the monitored directory is : $2">$4

echo "Full pathname to Verification file  : $pwd/$3">>$4

g=`find $2 -type d | wc -l `
echo "Number of directories parsed : $g">>$4
h=`find $2 -type f | wc -l `
echo "Number of files parsed : $h">>$4
date2=$(date -u +"%s")
diff=$(($date2-$date1))
echo "Time to complete the initialization mode : $(($diff / 60)) minutes and $(($diff % 60)) seconds elapsed.">>$4
else
echo "   "
echo " "
echo "*****Please change the file name in order to proceed***** "
echo "*************GOOD BYE!! HAVE A NICE DAY************"
echo " "
echo "  "
exit 0
fi

else
echo "===>>Report file with that name doesnot exist before so, no problem"
echo " "
echo "Full pathname to the monitored directory is : $2">$4

echo "Full pathname to the verification file is : $pwd/$3">>$4
g=`find $2 -type d | wc -l `
echo "Number of directories parsed : $g">>$4
h=`find $2 -type f | wc -l `
echo "Number of files parsed : $h">>$4
date2=$(date -u +"%s")
diff=$(($date2-$date1))
echo "Time to complete the initialization mode : $(($diff / 60)) minutes and $(($diff % 60)) seconds elapsed.">>$4
fi

#loop for the verification file
else
echo " "
echo " "
echo "     ************THIS IS VERIFICATION MODE************ "
echo "  "
echo " "
date1=$(date -u +"%s")

#to verify that the verification file exists
if [ -f "$3" ] 
then
echo "===>>The specified verification file exists"
echo " "
else
echo "===>>The specified verification file does not exist"
echo " "
fi

#To verify that the specified verification file is outside the monitored directory
if [ ! -f "$2/$3" ]
then
echo "===>>Verification file is outside the monitored directory  "
echo " "
else
echo "===>>Verification file is present inside the monitored directory "
echo " "
fi

#To verify that the specified report file is outside the monitored directory
if [ ! -f "$2/$4" ]; then
echo "===>>Report file is outside the monitored directory  "
echo " "
else
echo "===>>Report file is present inside the monitored directory "
echo " "
fi

#Verification mode of iterations for verification file
echo " ">vert
for line in $(find $2 -type f)
do
echo "$line#$(stat -c%s "$line")#$(stat -c%U "$line")#$(stat -c%G "$line")#$(stat -c%a "$line")#$(stat -c%y "$line")#$($5sum $line | awk -F" " '{print $1}')">>vert;
done
for line in $(find $2 -type d)
do
echo "$line#$(stat -c%s "$line")#$(stat -c%U "$line")#$(stat -c%G "$line")#$(stat -c%a "$line")#$(stat -c%y "$line")">>vert;
done

#comparing the changes between two moded verification files
cmp -s vert $3 > /dev/null

#If loops for changes taht are recorded.
if [ $? -eq 1 ]; then
echo "       WARNINGS!!" > warnings;

echo " " >> warnings;

#Warnings for added files/Directories
echo " " >> warnings;
cat vert | awk -F"#" '{print $1}' > vertemp
cat $3 | awk -F"#" '{print $1}' > initemp 
echo "       WARNING!!! The files that are added" >> warnings;
diff vertemp initemp | grep "<" | awk -F" " '{print $2}' >> warnings;
diff vertemp initemp | grep "<" | awk -F" " '{print $2}' > temp1;
w1=`diff vertemp initemp | grep "<" | awk -F" " '{print $2}' | wc -l`

#Warnings for removed files/Directories
echo " ">>warnings;
echo "       WARNING!!! The files that are removed" >> warnings;
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> warnings;
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> temp1;
w2=`diff vertemp initemp | grep ">" | awk -F" " '{print $2}' | wc -l`

array=$(cat temp1)
echo ${array[*]} > temp2

#Warnings for files with different sizes
echo " " >> warnings;
echo "      WARNING!!! The files with different size than recorded" >> warnings;
cat vert | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $2}}' > vertemp
cat $3 | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $2}}' > initemp
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> warnings;
w3=`diff vertemp initemp | grep ">" | awk -F" " '{print $2}' | wc -l`

#Warnings for files with different message digest
echo " " >> warnings; 
echo "      WARNING!!! The files with different message digest" >> warnings;
cat vert | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $7}}' > vertemp
cat $3 | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $7}}' > initemp
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> warnings;
w4=`diff vertemp initemp | grep ">" | awk -F" " '{print $2}' | wc -l`

#Warnings for files with different user or group names
echo " " >> warnings;
echo "       WARNING!!! The files with different User/group names" >> warnings;
cat vert | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $3 " " $4}}' > vertemp
cat $3 | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $3 " " $4}}' > initemp
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> warnings;
w5=`diff vertemp initemp | grep ">" | awk -F" " '{print $2}' | wc -l`

#Warnings for files with different access rights
echo " " >> warnings;
echo "       WARNING!!! The files with different access rights" >> warnings;
cat vert | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $5}}' > vertemp
cat $3 | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $5}}' > initemp
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> warnings;
w6=`diff vertemp initemp | grep ">" | awk -F" " '{print $2}' | wc -l`

#Warnings for files/Directories with different modification date
echo " " >> warnings;
echo "       WARNING!!! The files with different modification date" >> warnings;
cat vert | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $6}}' > vertemp
cat $3 | awk -F"#" '{ getline line<"temp2"; if (line !~ $1) {print $1 " " $6}}' > initemp
diff vertemp initemp | grep ">" | awk -F" " '{print $2}' >> warnings;
w7=`diff vertemp initemp | grep ">" | awk -F" " '{print $2}' | wc -l`

#else loop for no changes
else
echo "No warnings are issued which means no changes were made" > warnings;
w1="0";
w2="0";
w3="0";
w4="0";
w5="0";
w6="0";
w7="0";
fi


#Verification mode of iterations for report file
echo "Full pathname to the monitored directory : $2">$4

echo "Full pathname to the verification file is : $pwd/$3">>$4
echo "Full pathname to the report file : $pwd/$4">>$4
y=`find $2 -type d | wc -l `
echo "Number of directories parsed : $y">>$4
x=`find $2 -type f | wc -l `
echo "Number of files parsed : $x">>$4
echo "  ">>$4
echo " ">>$4
cat warnings >> $4;
cat vert > $3;
echo " ">>$4;
count=$(($w1+$w2+$w3+$w4+$w5+$w6+$w7));
echo "The number of warnings issued are: $count " >>$4;
echo " ">>$4;
date2=$(date -u +"%s")
diff=$(($date2-$date1))
echo "Time to complete the verification mode : $(($diff / 60)) minutes and $(($diff % 60)) seconds elapsed.">>$4
#rm -f warnings;

 

if [[ -f "warnings" ]]; then
rm -rf warnings;
fi
if [[ -f "vertemp" ]]; then
rm vertemp;
fi
if [[ -f "initemp" ]]; then
rm initemp;
fi
if [[ -f "temp1" ]]; then
rm temp1;
fi
if [[ -f "temp2" ]]; then
rm temp2;
fi
if [[ -f "vert" ]]; then
rm vert;
fi
exit 0
fi

#closing loop for hash function
else
echo " "
echo "************Please check the hash function************"
echo " "
exit 0
fi

#closing loop for the command
else
echo "************please check the command************"
exit 0
fi
