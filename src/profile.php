<?php
include 'con.php';
session_start();
$user_id=$_SESSION['user_id'];
$passkey=$_GET['passkey'];
if(!isset($user_id)){
header("Location:home.html");
}else{
$new_messages="select distinct receiver_id from messages where sender_id='$user_id' and seen=0 and receiver_id='$user_id'
 union 
select distinct sender_id from messages where receiver_id='$user_id' and seen=0 and receiver_id='$user_id' ";
$result1=mysqli_query($con,$new_messages);
$new_number = mysqli_num_rows($result1);
if(!$result1){
echo 'Sorry, Unable to process your request. Please try again later.';
}
?>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
setInterval (function(){
$.post(
"ajax_updates.php",
{request:"yes"});
.done(function(data){
$("#displaying_messages").html(data);
});
},1000);
</script>
<script>
function hide1(){
$("#password_change").slideUp();
$("#edit").slideToggle();
}
function hide2(){
$("#edit").slideUp();
$("#password_change").slideToggle();
}
function slide(){
$("#edit").slideUp();
$("#password_change").slideUp();
var data=$(this).attr('id')
$("input").not(".submit_button").val('');
}
function editing_profile(){
var name=$("#edit_name").val();
var mobile=$("#edit_mobile").val();
var college=$("#edit_college").val();
var city=$("#edit_city").val();
var state=$("#edit_state").val();
var password=$("#existing_password").val();
var about_me=$("#edit_about_me").val();
$.post(
"settings.php",
{name:name,mobile:mobile,college:college,city:city,state:state,password:password,about_me:about_me})
.done(function(data){
$("#edit").hide();
alert(data);
$("#ajax_box").load('details.php');
});
}
function changing_password(){
var old_password= $("#old_password").val();
var new_password1=$("#new_password1").val();
var new_password=$("#new_password").val();
$.post(
"settings.php",
{old_password:old_password,new_password1:new_password1,new_password:new_password})
.done(function(data){
$("#edit").hide();
alert(data);
$("#ajax_box").load('details.php');
});
}
function checking(){
var new_password=$('#new_password').val();
var new_password1= $('#new_password1').val();
if(new_password==new_password1){
$("#password_match").css("color","yellow");
$("#password_match").html('passwords matched');
}
else{
$("#password_match").html('');
}
}
</script>
<style>
*{
margin: 0px;
padding: 0;
border: 0;
}
#header{
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 15%;
background-color: #05BDBD;
font-family: sans;
color: #107183;
}
#heading{
font-size: 4em;
margin: 0px;
padding-top: 1.2%;
text-indent: 5%;
}
#container{
width: 100%;
height: 80%;
position: absolute;
top: 20%;
color: #90ADA9;
font-family: sans;
background-color: #545F5F;
}
#profile_tags{
position: absolute;
top: 0;
left: 0;
width: 20%;
height: 100%;
background-color: #486D6B;
border-right:0.2em solid yellow;
}
#ajax_box{
position: absolute;
top: 0;
left: 20%;
width: 80%;
height: 100%;
}
#details_box{
padding:2em;
line-height: 2.5em;
font-size: 1.3em;
padding-top: 0;
}
#details_box h3:first-child{
padding-bottom: 1em;
font-size: 1.5em;
}
#profile_tags a{
text-decoration: none;
color: yellow;
}
#navbar{
position: absolute;
top: 15%;
left: 0;
width: 100%;
height: 5%;
background-color: #08928D;
}

#user_msg{
position:absolute;
top:0;
left:0;
width:100%;
height:10%;
background-color:gold;
z-index: 2;
}
#user_msg h2{
padding: 0.5em;
padding-left: 4em;
}
#user_details{
position: absolute;
top: 10%;
height: 90%;
padding-left: 15%;
line-height: 2em;
width: 85%;
}
#user_details table:first-child {
padding-top: 2em;
}
#user_details td{
padding-right: 3em;
line-height: 2em;
font-size: 1.5em;
color: yellow;
}
#about_me{
color: white;
padding-top: 3%;
}
#about_me h2{
padding-bottom: 1%;
}
#display{
position:absolute;
top:11%;
left:0;
width:80%;
height:64%;
margin-left: 10%;
overflow:auto;
}
#display_books{
width:95%;
border: 0.2em solid black;
}
#display_books td,th{
border:0.2em solid black;
line-height: 2em;
color: yellow;
}
#display_books tr td:last-child{
text-align: center;
}
#message_details{
position: absolute;
top: 5%;
left: 0;
width: 90%;
height: 80%;
line-height: 2em;
margin-top: 5%;
padding-left: 10%;
font-size: 1.5em;
}
#message_details a{
text-decoration: none;
color: yellow;
}
#user_msg{
position:absolute;
top:0;
left:0;
width:100%;
height:10%;
background-color:gold;
z-index: 2;
}
#user_msg h2{
padding: 0.5em;
padding-left: 4em;
}
#msg_box{
position: absolute;
top: 10%;
left: 0;
width: 100%;
height: 70%;
background-color: gainsboro;
overflow: auto;
}
#msg_sender{
position: absolute;
top: 80%;
left: 0;
width: 100%;
height: 20%;
background-color: gainsboro;
}
#received{
margin-top: 1%;
text-align:left; 
margin-left:10%;
 margin-right:40%; 
 margin-bottom:1%;
  background-color:white;
  padding:1.5%;
  border-radius:2%;
  clear: both;
  display: inline-block;
}
#sent{
float:right; 
margin-right:10%;
 margin-left:40%;
 margin-bottom: 0.5%; 
 background-color:#007A71;
 padding:1.5%;
 border-radius:2%;
}
#text_sender{
border:0.1em solid black;
position: absolute;
top: 20%;
left: 4%;   
height: 70%;
width: 74.5%;
padding: 1%;
}
#send_button{
position: absolute;
top: 20%;
left: 78.5%;
height: 70%;
width: 10%;
cursor: pointer;
background-color: #007A71;
}
/*styles for settings.php */
#settings_box{
position:absolute;
top: 10%;
padding-top: 2%;
padding-left:5%;
width:95%;
height:86%;
overflow: auto;
}

#settings_box table{
padding-top:1em;
color:yellow;
font-size: 1em;
}
#settings_box table td,input{
padding: 0.4em;
}

#changing_password{
margin-top:2%;
}
.edit_button{
border: 0.1em solid white;
background-color: #545F5F;
font-size: 1em;
margin-top:2%;
margin-left: 2%;
color: white;
cursor:pointer;
padding:0.2em;
border-radius: 5px;
}
.edit_button:hover{
background-color:white;
color:#545F5F;
}
.div_tags{
display: block;
cursor: pointer;
width:30%;
line-height:2em;
}
#search_box{
position:absolute;
top:25%;
left:55%;
margin-right:5%;
width:40%;
height:50%;
}
#search_box p,button,input,select{
display:inline;
}
#search_content{
position:absolute;
top:35%;
width:100%;
padding:0.4em;
height:100%;
}
#button{
background-color: #05BDBD;
font-family: sans;
border: 0.2em solid white;
color: white;
border-radius:0.2em;
}
#button:hover{
background-color: white;
color: #05BDBD;
cursor: pointer;
}


/* Search_page styles */

#search_results{
position:absolute;
top:10%;
left:0;
width:85%;
height:85%;
margin-left:0.3%;
overflow:auto;
}
#search_table{
position:absolute;
width:95%;
border: 0.2em solid black;
}
#search_table td,th{
border:0.1em solid black;
line-height: 3em;
color: white;
}
#search_table tr td{
text-align: center;
}
#search_msg{
position:absolute;
top:0;
left:0;
width:100%;
height:10%;
background-color:gold;
z-index: 2;
}
#search_msg h2{
padding: 0.5em;
}

#search_table th{
color:rgb(104, 124, 122);
background-color: gold;
}
#search_table a{
color: white;
text-decoration:none;
}
</style>
<?php
echo '<script> var passkey='.$passkey.'</script>';
?>
<script>
$(start);
function start(){
<?php if(!isset($passkey)){
echo '$("#ajax_box").load("books.php");';
}
else{
 echo '$("#ajax_box").load("books.php?passkey='.$passkey.'");';
}
?>
$("#details_box  h3 a").not("#logout").click(function(){
var data = this.href;
$("#ajax_box").load(data);
return false;
});
$(".submit_button").click(getting_results)
}
function getting_results(){
	var area=$("#search").val();
	var value=$("#value").val().replace(/\s/g, "+");
	$("#ajax_box").load("search_results.php?area="+area+"&value="+value);
	}
</script>
<div id="header">
<h1 id="heading">Swap Your Book</h1>
<div id="search_box">
<span id="search_content">
<p style="height:50%;">Search by</p>
<select style="height:50%;" name="search" id="search">
<option>book</option>
<option>author</option>
<option>college</option>
<option>city</option>
</select>
<input type="text" style="width:50%;height:50%;" name="value" id="value"></input>
<input type="submit" id="button" style="height:50%; padding:0.2em;" value="search" class="submit_button"></input>
</span>
</div>
</div>
<div id="navbar">

</div>
<div id="container">
<div id="profile_tags">
<div id="details_box">
<h3>Account Information</h3>
<h3><a href="details.php" id="details">Profile</a></h3>
<h3><a href="books.php" id="books">Books</a></h3>
<h3><a href="messages1.php" id="messages">Messages</a><span id="displaying_messages">
<?php if($new_number>0){echo '('.$new_number.')';} ?>
</span></h3>
<h3><a href="settings.php" id="settings">Settings</a></h3>
<h3><a href="logout.php" id="logout">Log Out</a></h3>
</div>
</div>
<div id="ajax_box">

</div>
</div>
<?php
}
?>