<script>
$('#msg_box').ready(function (){
$('#msg_box').scrollTop($('#msg_box')[0].scrollHeight);
return false;
});
</script>
<?php
include 'con.php';
session_start();
$user_id=$_SESSION['user_id'];
$pass=$_GET['passkey'];
echo '<script>passkey="'.$pass.'"</script>';
// checking if message was sent 
if(isset($_GET['msg']))
{
$msg=$_GET['msg'];
$msg=htmlentities($msg);
$msg=addslashes($msg);
$time=time();
$query="insert into messages (sender_id,receiver_id,message,time,seen) values('$user_id','$pass','$msg','$time',0)";
$result=mysqli_query($con,$query);
if(!$result){
echo 'Sorry, but there was an error';
}
else{
$query="select message,sender_id,time from messages where sender_id='$user_id' and receiver_id='$pass' 
union
select message,sender_id,time from messages where sender_id='$pass' and receiver_id='$user_id'
order by time asc
";
$result=mysqli_query($con,$query);
while($row = mysqli_fetch_array($result))
  {
  if($row['sender_id']==$user_id)
   {
   echo '<p id="sent">'.$row['message'].'</p>';
echo '<br>';
   }
  if($row['sender_id']==$pass)
   {
   echo '<p id="received">'.$row['message'].'</p>';
echo '<br>';
   }
  }
}
}

// checking if passkey was set

elseif(isset($pass))
{
$query="update messages set seen=1 where sender_id='$pass' and receiver_id='$user_id' ";
$result=mysqli_query($con,$query);
if(!$result){
echo 'Unable to process the request' ;
}
//displaying username
echo '<div id="user_msg">';
$query="select * from profile where user_id='$pass' ";
$result=mysqli_query($con, $query);
$rows=mysqli_num_rows($result);
for($i=0; $i<$rows; ++$i) {
	$row=mysqli_fetch_row($result);
	$username=$row[1];
	$email=$row[2];
echo '<h2>conversation with '.$username ;
} 
//displaying lastseen
$query="select lastseen from users where email='$email' ";
$result=mysqli_query($con,$query);
$rows=mysqli_num_rows($result);
for($i=0; $i<$rows; ++$i) {
	$row=mysqli_fetch_row($result);
	$lastseen=$row[0];
} 
$time=gmdate("Y-m-d",$lastseen);
echo '<em style="font-size:0.65em;">(Last seen:'.$time.')</em></h2></div>';

?>
<style>
.msg_box{
	position: absolute;
	top: 15%;
	left: 0;
	width: 100%;
	height: 75%;
	overflow: auto;
}
#message_sender{
	position: fixed;
bottom: 2%;
left: 0;
height: 7%;
width: 60%;
	}
	.msg_box::-webkit-scrollbar {
    width: 12px;
}

.msg_box::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    border-radius: 10px;
}

.msg_box::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}

</style>
<div id="msg_box">
<?php
//displaying messages

$query="select message,sender_id,time from messages where sender_id='$user_id' and receiver_id='$pass' 
union
select message,sender_id,time from messages where sender_id='$pass' and receiver_id='$user_id'
order by time asc
";
$result=mysqli_query($con,$query);
while($row = mysqli_fetch_array($result))
  {
  if($row['sender_id']==$user_id)
   {
   echo '<p id="sent">'.$row['message'].'</p>';
echo '<br>';
   }
  if($row['sender_id']==$pass)
   {
   echo '<p id="received">'.$row['message'].'</p>';
echo '<br>';
   }
  }
echo '
</div>
<div id="msg_sender" >
<textarea id="text_sender" rows="3" ></textarea>
<button id="send_button" onclick="sending()">Send</button>
</div>';
}
?>

<script>
function sending(){
var message=$("#text_sender").val();
$.get( "messages2.php", {msg:message,passkey:passkey})
.done(function(data){
$("#text_sender").val('');
$("#msg_box").html(data);
});
}
setInterval( function(){
	$.post( "ajax_updates.php", {passkey:passkey})
.done(function(data){
	$("#msg_box").html(data);
//$("#msg_box").html(data).scrollTop($('#msg_box')[0].scrollHeight);
});
	}, 3000);
</script>