<?php
include 'con.php';
$email=$_POST['email'];
$pass=$_POST['password'];
if($email=='' || $pass=='') {
	echo '<script> alert("Don\'t try to enter with empty values!");</script> ';
	}
	else {
$query="select password from users where email='$email' AND com_code=''";
$result=mysqli_query($con,$query);
$rows=mysqli_num_rows($result);
for($i=0; $i<$rows; ++$i) {
	$row=mysqli_fetch_row($result);
		$password= $row[0];
		 if($password==$pass) {
		 	session_start();
		 	$_SESSION['email']=$email;
$query="select user_id from profile where email='$email' ";
$result=mysqli_query($con,$query);
$rows=mysqli_num_rows($result);
for($i=0; $i<$rows; ++$i) {
	$row=mysqli_fetch_row($result);
	$user_id=$row[0];
}
$_SESSION['user_id']=$user_id;
$_SESSION['logged']="yes";
$time=time();
$query1="update users set lastseen='$time',logged=1 where email='$email'";
$result1=mysqli_query($con,$query1);
if(isset($_POST['passkey'])){
$passkey=$_POST['passkey'];
header('Location:profile.php?passkey='.$passkey);
}
else{
		 	header('Location:profile.php');
}
		 }
		 else {
		 	echo ' <script> alert("Incorrect Email/Password")</script>';

		 }
	}
	if($rows==0)
	{
		echo '<script> alert("Your email is not registered yet!")</script> ';
		}
	}
?>