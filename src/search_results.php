<?php
include 'con.php';
session_start();
$logged=$_SESSION['logged'];
$search=$_GET['area'];
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


<style>
#user_msg{
position:absolute;
top:0;
left:0;
width:100%;
height:10%;
background-color:gold;
z-index: 2;
}
#user_msg p{
margin-left: 5%;
margin-top: 1.2%;
font-size: 1.5em;
}
#search_results{
position: absolute;
top: 10%;
left: 0;
width: 99%;
height: 90%;
overflow: auto;
}
#results_table{
position: absolute;
top: 5%;
left: 5%;
width: 80%;
}
#results_table tr,th,td{
border: 0.1em solid black;
}
#results_table td{
line-height: 3em;
text-align: center;
color: white;
}
#results_table tr:first-child{
background-color: rgb(120, 138, 136);
}
#results_table a{
color:white;
text-decoration:none;
}
</style>
<script>
$(function(){
	$("#results_table a").click(search_details);
	})
	function search_details(){
		id= $(this).attr('id');
		$("#ajax_box").load("books.php?passkey="+id);
		}
</script>
<div id="user_msg">
<p><?php echo $msg.' '.$rows; ?> results found </p>
</div>
<div id="search_results">
<table id="results_table">
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