<?php
include 'con.php';
session_start();
$logged=$_SESSION['logged'];
$search=$_GET['search'];
$value=$_GET['value'];
if($search=="book"){
$query="select user_id from books where title='$value'";
$msg="searching for people having the book: ".$value;
}
elseif($search=="author")
{
	$query="select user_id from books where author='$value'";
	$msg="searching for people having books with the author: ".$value." in their books list";
}
elseif($search=="college"){
	$query="select username,college,city,user_id from profile where college='$value'";
	$msg="searching for people within the college:".$value;
	}
	else{
		$query="select username,college,city,user_id from profile where city='$value'";
			$msg="searching for people within the city:".$value;
	}

$result=mysqli_query($con,$query);
$rows=mysqli_num_rows($result);
?>
<html><head>
<title>User Details</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(start);
function start(){
$("#modal").hide();
$("#sign_up_form").hide();
$("#login_form").hide();
$("input").not("#submit,#login_button").val('');
$("#search_details a").click(login_form);
}

function login_form(){
$("#sign_up_form").hide();
$("#modal").show();
$("#login_form").show();
id = $(this).attr('id');
$("#passkey").val(id);
return false;
}
function sign_up(){
$("#login_form").hide();
$("#modal").show();
$("#sign_up_form").show();
}
function keyListner(e){
if(!e){
e=window.event;
}
if(e.keyCode == 27){
$("#modal").hide();
$("#sign_up_form").hide();
$("#login_form").hide();
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
#footer{
position: absolute;
bottom: 0;
width: 100%;
height: 5%;
background-color: #05BDBD;
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
top: 15%;
color: #A1B6B3;
font-family: sans;
background-color: #545F5F;
}

body{
background-color:#545F5F ;
}

#container h1
{
text-align: center;
font-size: 2em;
}
p
{
text-align: center;
font-size: 1em;
}
a
{
text-decoration: none;
color: black;
}
a:hover
{
text-decoration: underline;
color: blue;
}
#buttons{
position: absolute;
top: 30%;
left: 65%;
}
#button{
height: 3em;
width: 6em;
margin-right: 2em;
background-color: #05BDBD;
font-size: 1em;
font-family: sans;
border: 0.2em solid white;
color: white;
border-radius:0.5em;
}
#button:hover{
background-color: white;
color: #05BDBD;
cursor: pointer;
}
#modal{
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: black;
z-index: 1;
opacity: 0.8;
display: none;
}
#login_form{
position: absolute;
top: 30%;
left: 30%;
width: 40%;
height: 40%;
background-color:  #05BDBD;
z-index: 2;
font-family: sans;
text-indent: 10%;
display: none;
}
#table{
margin-left: 15%;
}
.small_buttons{
background-color:  #05BDBD;
border:0.1em solid #575757;
font-size: 1em;
border-radius:0.3em;
}
.small_buttons:hover{
cursor: pointer;
border:0.1em solid white;
}
.type1{
font-size: 1.5em;
padding: 0.3em;
}
.type2{
padding:0.2em;
}
.input{
border:none;
height: 1.5em;
margin-left: 20%;
width: 100%;
margin-bottom: 5%;
}
#sign_up_form{
position: absolute;
top: 27%;
left: 30%;
width: 40%;
height: 46%;
background-color:  #05BDBD;
z-index: 2;
font-family: sans;
text-indent: 10%;
display: none;
}
#bottom{
margin-left: 10%;
}

#submit_button{
cursor: pointer;
border:0.2em solid white;
background-color: #545F5F;
color: white;
padding: 0.3em;
border-radius:10%;
margin-left: 0px;
width: 15%;
font-size: 1.5em;
}
#submit_button:hover{
color: #545F5F;
background-color: white;
}
#box{
position: absolute;
top: 10%;
left: 5%;
width: 90%;
height: 85%;
overflow: auto;
}
#search_details{
margin-left: 0px;
position: absolute;
top: 0;
left: 0;
width: 100%;
border: 0.2em solid black;
line-height: 3em;
color: white;
}
#search_details tr td {
border: 0.1em solid black;
}
#search_details th{
background-color: gold;
}
#search_details tr:first-child{
z-index:5;
}
#books_table{
position:absolute;
top:10%;
left:10%;
width:90%;
height:80%;
}
#user_msg{
position:0;
left:0;
height:9%;
width:100%;
text-align:left:
margin-top:1%
margin-left:10%;
}
#results{
position:absolute;
top:5%;
left:15%;
width:70%;
height:90%;
}
#showing_data{
position:absolute;
top:15%;
left:50%;
width:50%;
height:80%;
background-color:white;
display:none;
}
</style>
</head>
<body onkeydown="keyListner()">
<div id="header">
<h1 id="heading">Swap Your Book</h1>
<?php
if(!$logged=="yes"){
echo '
<span id="buttons">
<button id="button" onclick="login_form()">Login</button>
<button id="button" onclick="sign_up()">Sign Up</button>
</span> ';
}
?>
</div>

<div id="container">
<div id="results">
<div id="user_msg">
<p><?php echo $msg; ?> </p>
<p><?php echo $rows; ?> results found </p>
</div>
<div id="box">
<table id="search_details">
<tr>
<th>Username</th>
<th>College</th>
<th>City</th>
</tr>
<?php
if($search=="book" || $search=="author"){
for($i=0;$i<$rows;$i++){
$row= mysqli_fetch_row($result);
$user_id=$row[0];
$query1="select username,college,city from profile where user_id= '$user_id' ";
$result1=mysqli_query($con,$query1);
$rows1=mysqli_num_rows($result1);
for($j=0;$j<$rows1;$j++){
$row1 = mysqli_fetch_row($result1);
echo '<tr><td><a href="#" id="'.$user_id.'">'.$row1[0].'</a></td>';
echo '<td>'.$row1[1].'</td>';
echo '<td>'.$row1[2].'</td></tr>';
}
}
}
else{
for($i=0;$i<$rows;$i++){
$row= mysqli_fetch_row($result);
echo '<tr><td><a href="#" id="'.$row[3].'">'.$row[0].'</a></td>';
echo '<td>'.$row[1].'</td>';
echo '<td>'.$row[2].'</td></tr>';
}
}
?>
</table>
</div>
</div>
</div>
<div id="footer">
<p style="text-align:left;">©  gerites</p>
</div>
<div id="modal">

</div>
<div id="login_form">
<h1 style="margin:3%;">Welcome back!</h1>
<p style="margin-bottom:2%;">Please enter your login details below to continue</p>
<table id="table">
<tbody>
<form action="login_process.php" method="post">
<tr>
<td>
Email
</td>
<td>
<input class="input" type="text" name="email" placeholder="enter your email here" id="login_email">
</td>
</tr>
<tr>
<td>
Password
</td>
<td>
<input class="input" type="password" name="password" placeholder="enter password here" id="login_password">
</td>
</tr>
<tr>
<td><br></td>
</tr>
<tr>
<td>
<input type="hidden" value="" id="passkey" name="passkey">
<input type="submit" class="small_buttons type1" id="login_button" value="login"></input>
</form>
</td>
<td>Or, <button class="small_buttons type2 " onclick="sign_up()"> Sign Up</button></td>
</tr>
</tbody></table>
</div>
<div id="sign_up_form">
<h1 style="margin:3%;">Welcome!</h1>
<p style="margin-bottom:2%; text-align:left; text-ident:10%;">Please enter your details below to Sign Up</p>
<table id="table">
<form action="process.php" method="post">
<tbody><tr>
<td>
Username
</td>
<td>
<input class="input" type="text" name="username" placeholder="enter your Username	 here">
</td>
</tr>
<tr>
<td>
Email
</td>
<td>
<input class="input" type="text" name="email" placeholder="enter your email here">
</td>
</tr>
<tr>
<td>
Password
</td>
<td>
<input class="input" type="password" name="password" placeholder="enter password here">
</td>
</tr>
</tbody></table>
<div id="bottom">
<input type="checkbox" name="terms" id="terms_conditions">
I accept the <a href="" style="text-decoration:none;">Terms &amp; Conditions</a>
<div style="margin-top:1em;">
<button class="small_buttons type1">Sign Up</button>
</form>
Or, <button class="small_buttons type2" onclick="login_form()"> Login</button>
</div>
</div>
</div>
</body></html>