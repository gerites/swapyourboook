<?php
include 'con.php' ;
  $username = sanitizeString($_POST['username']);
  $email = sanitizeString($_POST['email']);
 $query="select * from users where email='$email' ";
 $result= mysqli_query($con,$query);
 $num=mysqli_num_rows($result);
 if($num>0){
echo '<script> alert("your email is already registered. check your mailbox "); </script>';
header('location:home.html');
}else{
  $password = sanitizeString($_POST['password']);
  $com_code = md5(uniqid(rand()));
  $sql2 = "INSERT INTO users (username, email, password, com_code) VALUES ('$username', '$email', '$password', '$com_code')";
  $result2 = mysqli_query($con,$sql2) or die(mysqli_error($con));

$to  = $email;
// subject
$subject = 'Verification of email';

// message
$message = '
<html>
<head>
  <title>Verification of email</title>
</head>
<body>
<h1>Please click the link below to verify and activate your account.<br>
<a href="http://www.workspace.hostingsiteforfree.com/root/confirm.php?passkey='.$com_code.'" >Click Here </a></h1>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Admin <admin@workspace.hostingsiteforfree.com>' . "\r\n";

// Mail it
$sentmail=mail($to, $subject, $message, $headers);
 if($sentmail)
            {
   echo "Your Confirmation link Has Been Sent To Your Email Address.";
   }
   else
         {
    echo "Cannot send Confirmation link to your e-mail address";
   }
$query="
INSERT INTO  `u726107590_users`.`profile` (
`username` ,
`email` ,
`mobile` ,
`college` ,
`city` ,
`state`
)
VALUES (
'$username',  '$email', NULL , NULL , NULL , NULL
)";
$ins=mysqli_query($con,$query);

} 

function sanitizeString($str){
	$str= stripslashes($str);
	$str= htmlentities($str);
	$str= strip_tags($str);
	return $str;
	}
	 function sanitizeMYSQL($str){
	 	$str= mysql_real_escape_string($str);
	 	$str= sanitizeString($str);
	 	return $str;
	 	}
  
?>