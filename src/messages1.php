<script>
$("#message_details p a").click(function(){
clearInterval(refresh);
var data=this.href;
$("#ajax_box").load(data);
return false;
});
var refresh=setInterval(function(){
	$("#messages1_box").load('messages1.php')
	},3000);
</script>
<style>
#messages1_box{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
}
</style>
<?php
include 'con.php';
session_start();
$user_id=$_SESSION['user_id'];
echo '<div id="messages1_box">
<div id="user_msg">
<h2>Messages Received</h2>
</div>
<div id="message_details">
';
$query="select distinct receiver_id from messages where sender_id='$user_id'
 union 
select distinct sender_id from messages where receiver_id='$user_id' ";
$result=mysqli_query($con,$query);
$rows=mysqli_num_rows($result);
for($i=0;$i<$rows;$i++) {
	$row=mysqli_fetch_array($result);
	$receiver_id=$row[0];
	$name="select  username from profile where user_id='$receiver_id' ";
$names=mysqli_query($con,$name);
$num=mysqli_num_rows($names);
for($j=0;$j<$num;$j++) {
  $num=mysqli_fetch_array($names);
 $username= $num[0];
 $number="select message from messages where sender_id='$receiver_id' and seen=0 and receiver_id='$user_id'
 union 
select message from messages where receiver_id='$receiver_id' and seen=0 and receiver_id='$user_id'";
$seen=mysqli_query($con,$number);
$new=mysqli_num_rows($seen);
if(!$username==''){
echo '<p><a href="messages2.php?passkey='.$receiver_id.'" >'.$username;
 if(!$new==0){echo  '('.$new.')' ;}'</a></p>';
}
}
}
echo '</div></div>';
?>