<?php
include 'con.php';
session_start();
$user_id=$_SESSION['user_id'];
$query="select password from users where user_id='$user_id'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_row($result);
$correct_password=$row[0];
if(!$row){
echo 'sorry but there was an error. Please try later';
}
if(isset($_POST['name'])){
$username=$_POST['name'];
$mobile=$_POST['mobile'];
$college=$_POST['college'];
$city=$_POST['city'];
$state=$_POST['state'];
$password=$_POST['password'];
$about_me=$_POST['about_me'];
if($correct_password==$password){
$query="update profile set username='$username',mobile='$mobile',college='$college',city='$city',state='$state',about_me='$about_me' where user_id='$user_id'";
$result=mysqli_query($con,$query);
if(!$result){
echo 'unable to process the request. Try after some time';
}else{
echo 'Details Updated successfully';
}
}
else{
echo 'Incorrect password provided';
}
}
elseif(isset($_POST['new_password'])){
$old_password=$_POST['old_password'];
$new_password1=$_POST['new_password1'];
$new_password=$_POST['new_password'];
if($correct_password==$old_password){
if($new_password==$new_password1){
$query="update users set password='$new_password' where user_id='$user_id'";
$result=mysqli_query($con,$query);
if(!$result){
echo 'unable to process request. Try after some time.';
}
else{
echo 'Password changed successfully';
}
}
}else{
echo 'Incorrect password provided';
}
}
else{ 
echo '
<script>
$(function(){
$("#edit").hide();
$("#password_change").hide();
})
</script>
<div id="user_msg">
<h2> Settings </h2>
</div>
<div id="settings_box" onload="hiding()">
<h3 class="div_tags" onclick="hide1()"> Edit Profile </h3>
<div id="edit" class="slide">';
$query="select username,mobile,college,city,state,about_me from profile where user_id='$user_id'";
$res=mysqli_query($con,$query);
$details = mysqli_fetch_array($res);
echo '
<table>
<tr><td>Name:</td>  <td><input type="text" value="'.$details[0].'" id="edit_name"></input> </td></tr>
<tr><td>Mobile:</td>  <td> <input type="text" value="'.$details[1].'" id="edit_mobile"></input> </td></tr>
<tr><td>College:</td>  <td> <input type="text" value="'.$details[2].'" id="edit_college"></input> </td></tr>
<tr><td>City:</td> <td> <input type="text" value="'.$details[3].'" id="edit_city"></input> </td></tr>
<tr><td>State:</td> <td> <input type="text" value="'.$details[4].'" id="edit_state"></input> </td></tr> 
<tr><td>your password: </td><td><input type="password" placeholder="existing password" id="existing_password"></input></td></tr>
<tr><td>About Me:</td><td><textarea cols="50" rows="2"  style="padding:0.3em;" id="edit_about_me">'.$details[5].'</textarea></td></tr>
</table>
<button class="edit_button" id="edit_confirm" onclick="editing_profile()">Save Changes </button>
<button class="edit_button" onclick="slide()">Discard </button>
</div>
<h3 id="changing_password" class="div_tags" onclick="hide2()"> Change Password </h3>
<div  id="password_change">
<table>
<tr><td> Enter current password:</td>  <td><input type="password" placeholder="enter value" id="old_password"></input> </td></tr>
<tr><td>Enter new password:</td>  <td> <input type="password" placeholder="enter value" id="new_password1"></input> </td></tr>
<tr><td>Confirm new password: </td>  <td> <input type="password" placeholder="enter value" id="new_password"  onkeyup="checking()"></input> <span id="password_match"></span></td></tr>
</table>
<button class="edit_button" onclick="changing_password()">Save Changes </button>
<button class="edit_button" onclick="slide()">Discard </button>
</div>
</div> ';
}
?>