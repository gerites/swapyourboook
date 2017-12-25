<?php
include 'con.php';
session_start();
$user_id=$_SESSION['user_id'];
$new_members = $_POST['new_members'];
if(isset($new_members)){
$result =mysqli_query($con,$new_members);
$number= mysqli_num_rows($result);
if($number>0){
echo '('.$number.')';
}
}
$pass=$_POST['passkey'];
if(isset($pass)){
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
?>