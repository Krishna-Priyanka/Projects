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

	if($_POST[newPassword] && $_POST[confirmPassword] )
{
if($_POST[newPassword] == $_POST[confirmPassword])
	{
		
$newPassword = filter_var($_POST[newPassword], FILTER_SANITIZE_STRING);
$pass1= sha1($newPassword);

$confirmPassword = filter_var($_POST[confirmPassword], FILTER_SANITIZE_STRING);
$pass2= sha1($confirmPassword);

$sql="UPDATE USERS SET Password='$pass1'";

if (mysqli_query($con,$sql))
{
echo "Successfully changed<br><br>";
	 echo "<a href=welcome.php> <font color=blue  size='4pt'> 
Click here to login.</a></font> <br> <br>";	
	}
}
		else
		{
			echo "PASSWORDS DID NOT MATCH";}
}


?>
<h1>Change Password</h1>
<form method="post" action="">

<label for="newPassword">New Password:</label>
<input type="password" id="newPassword" name="newPassword" title="New password" />

<label for="confirmPassword">Confirm Password:</label>
<input type="password" id="confirmPassword" name="confirmPassword" title="Confirm new password" />

<p class="form-actions">
<input type="submit" value="Change Password" title="Change password" />
</p>

</form> 

  



</body>
</html> 
