<?php
include 'con.php';
$passkey=$_GET['passkey'];
$query="update  users set com_code='' where com_code='$passkey'";
$result=mysqli_query($con,$query);
if(!result)
{
echo 'Failed to confirm your email';
}
else{
echo 'Your email is now activated  and now you can <a href="home.php">Login </a> using your email. ';
}
?>