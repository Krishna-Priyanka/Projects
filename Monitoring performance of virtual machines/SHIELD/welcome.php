 <!DOCTYPE html>
<html>
<head>
<title>Log In</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<br> 
<h1><center> MONITORING THE PERFORMANCE OF VIRTUAL MACHINES</center></h1>
<br> <br> <br> <br> <br> 
<div id="main">
<div style="align:center;font-family:sans-serif;font-size:10" >
<table border="0" width="350" height="350" bgcolor="#f7f7f7" align="center" >
<tr>
<th>
<img src="1.png" width="140" height="105" align="center">
</th>
</tr>
<form action="login.php" method="post"> 
<tr> 
<th> <input type="text" id="NAME" name="NAME" placeholder="Username" style="height:30px; width:250px; background-color:white; border:1px black; text-align:left; font-family:verdana; font-size:14"> </th>
</tr>

<tr> 
<th> <input type="password" id="PASSWORD" name="PASSWORD" placeholder="Password"  style="height:30px; width:250px; background-color:white; border:1px black; text-align:left; font-family:verdana; font-size:14"> </th>
</tr>

<tr> 
<th><input type="submit" value="Sign in" style="height:30px; width:250px; background-color:#357ae8; border:1px #2f5bb7; text-align:center; font-family:verdana;color:white; font-size:14"> </th>
</tr>
</form> 
<br>

<form action="change.php" method="post"> 
<tr> 
<th> <input type="submit" value="Change Password" style="height:30px; width:250px; background-color:#800080; border:1px #2f5bb7; text-align:center; font-family:verdana;color:white; font-size:14"> </th>
</tr>
</form> 
<br>


</div>

</div>
</body>
<?php
$c=0;
$array = parse_ini_file("db.conf");

foreach ($array as &$value) {
            $in[$c]=$value;
            $c++;

}

$dbhost= $in[0];
$username=$in[1];
$password=$in[2];
$dbname=$in[3];
$dbtable=$in[5];
$out=$in[6];





$con= new mysqli($dbhost,$username,$password,$dbname);
if ($con->connect_error)
  {
  echo "Failed to connect to MySQL: ". $con->connect_error ;
  }

$sql="CREATE TABLE if not exists USERS (ID INT NOT NULL AUTO_INCREMENT ,NAME VARCHAR(20),EMAIL VARCHAR(40),PASSWORD VARCHAR(40),PRIMARY KEY(ID))";
if ($con->query($sql) === TRUE) {
   # echo "Table USERS created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

  $password = filter_var(shield, FILTER_SANITIZE_STRING);
  $password1= sha1($password);
$sql1="INSERT INTO USERS (ID,NAME,EMAIL,PASSWORD)
VALUES ('1','admin','shield@bth.se', '$password1')";
 
$con->query($sql1);
$con->close();
?>

  



</body>
</html> 
