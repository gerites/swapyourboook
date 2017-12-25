<style>
#msg_sender{
background-color: transparent;
width: 70%;
margin-left:10%;
}
#user_msg h2 a{
color : white;
text-decoration : none;
}
</style>
<?php
include 'con.php';
session_start();
$email=$_SESSION['email']; 
$passkey=$_GET['passkey'];
echo '<script>passkey="'.$passkey.'"</script>';
if(!isset($email) && !isset($passkey)){
 header('Location: home.php');
  }
if(isset($passkey)){
  $query="select username from profile where user_id='$passkey'";
  $result=mysqli_query($con,$query);
  $username=mysqli_fetch_array($result);
  $user=$username[0];
  $usermsg='Details About :<a href="books.php?passkey='.$passkey.'"> '.$user.'</a>';
}
else{
  $usermsg="Your Details";
}
echo '<div id="user_msg">
<h2>'.$usermsg.'</h2>
</div>
<div id="user_details">
<table>'
;
if(!isset($passkey)){$query="select * from profile where email='$email'";}
else{$query="select * from profile where user_id='$passkey'";}
$result=mysqli_query($con,$query);
$rows=mysqli_num_rows($result);
for($j=0;$j<$rows;++$j) {
	$row=mysqli_fetch_row($result);
echo '<tr><td>Name</td>  <td>'.$row[1].' </td></tr>';
echo '<tr><td>Mobile</td>  <td>'.$row[3].' </td></tr>';
echo '<tr><td>College</td>  <td>'.$row[4].' </td></tr>';
echo '<tr><td>City</td> <td>'.$row[5].' </td></tr>';
echo '<tr><td>State</td> <td>'.$row[6].' </td></tr>';
echo '</table><div id="about_me">
<h2>About Me:</h2>
<h3>'.$row[8].'</h3>
</div>';
}
if(isset($passkey)) {
	echo '<div id="msg_sender" >
<textarea id="text_sender" rows="3" placeholder="Start conversation with the user...";></textarea>
<button id="send_button" onclick="sending()">Send</button>
</div>';
}
?>
<script>
$(function () {
	 $("#user_msg h2 a").click(function(){
id= $(this).attr('href');
 $("#ajax_box").load(id);
return false;
})
})
function sending(){
var message=$("#text_sender").val();
$.get( "messages2.php", {msg:message,passkey:passkey})
.done(function(data){
$("#text_sender").val('');
$("#ajax_box").load('messages2.php?passkey='+passkey);
});
}
</script>