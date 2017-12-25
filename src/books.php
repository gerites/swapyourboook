<style>

#user_msg h2 a{
color : white;
text-decoration : none;
}

#add_books{

position:absolute;

top:25%;

left:35%;

width:30%;

height:50%;

background-color:#545F5F;

display:inherit;

 border:0.2em solid white;

 color: white;

font-size: 1.6em;

cursor: pointer;

z-index:5;

}

#add_books:hover{

background-color:white;

color:#545F5F;

}

#entering_books{

position:absolute;

top:20%;

left:25%;

width:50%;

height:60%;

background-color:orange;

z-index:5;

}

#entering_table{

position:absolute;

top:0;

left:0;

width:100%; 

height:35%;

background-color:gold;

}

#modal{

position:absolute;

top:0;

left:0;

width:100%;

height:100%;

background-color:black;

opacity: 0.6;

}

#adding_table{

position:absolute;

top:5%;

left:20%;

width:60%; 

height:95%;

}

#adding_table tr{

margin-bottom: 1em;

line-height:3em;

}

#adding_table td{

padding-right:1em;

}

#confirmation{
position: absolute;
top: 35%;
left: 25%;
height: 30%;
width: 50%;
background-color: orange;
z-index: 10;
}
#confirmation p{
text-align: center;
font-size: 2em;
color: white;
font-size: 2em;
padding-top: 5%;
padding-bottom: 5%;
}
#confirmation .button{
padding:3%;
margin-left: 15%;
margin-right:20%;
cursor: pointer;
background-color: rgb(255, 113, 2);
}
#remove_form{
display: inline;
}

</style>

<script>

i=0,j=0;

$(function (){
 $("#entering_books").hide();
 $("#modal").hide();
 $("#remove_button").hide();
 $("#confirmation").hide();
 $(".books_list").change(removal);
 $("#user_msg h2 a").click(function(){
id= $(this).attr('href');
 $("#ajax_box").load(id);
return false;
})

})
	var myfun;
function removal(){

 book_id=$(this).attr('id');
if($("#"+book_id).is(":checked")){
	var buk_id=$("#"+book_id).val();
	  j++;
	   $("#add_books").hide();
	   $("#confirmation #remove_form").append('<input type="hidden" value="'+buk_id+'" id="'+book_id+'" name="book'+j+'"></input>');
	clearTimeout(myfun);
	myfun=setTimeout(function () {
 $("#confirmation").show();
 $("#modal").show();
  $("#confirmation p").html("Are you sure to delete "+j+" book(s)?");
 },3000);
}else{
	clearTimeout(myfun);
	$("#confirmation #remove_form #"+book_id).remove();
		myfun=setTimeout(function () {
 $("#confirmation").show();
 $("#modal").show();
  $("#confirmation p").html("Are you sure to delete "+j+" book(s)?");
 },2000);
j--;
}
if(j==0){
rem_can();
}
}

function rem_can() {
	j=0;
	clearTimeout(myfun);
$("#add_books").show();
$("#confirmation").hide();
$("#modal").hide();
$("#confirmation #remove_form").html('<input type="submit" class="button" value="delete"></input>');
$(".books_list").prop('checked', false);
}

function entering(){

$("#entering_books").toggle();

if(i%2==0){

$("#add_books").html("Enter");

$("#add_books").css("top","37%");

$("#modal").show();

i++;

}else{

$("#add_books").html("Add Books");

$("#add_books").css("top","25%");

$("#modal").hide();

i++;

if(i>1){

var title= $("#title").val();

var author= $("#author").val();

var publisher= $("#publisher").val();

var status= $("#status").val();

$.post(

"books.php",

{title:title,author:author,publisher:publisher,status:status})

.done(function(data){

$("#modal").hide();

$("#add_books").css("top","25%");

$("#ajax_box").html(data);

});

}

}

}

</script>

<?php

include 'con.php';

session_start();

$email=$_SESSION['email'];

$passkey=$_GET['passkey'];

//$email="p.seshukumar777@gmail.com";

if(!isset($email)){

 header('Location: home.php');

  }

  if(isset($passkey)){

  $query="select username,user_id from profile where user_id='$passkey'";

  $result=mysqli_query($con,$query);

  $username=mysqli_fetch_array($result);

  $user=$username[0];
  $passkey=$username[1];

    $usermsg='Books Possessed by : <a href="details.php?passkey='.$passkey.' ">'.$user.'</a>';

  }else{

    $usermsg="Books in your list";

  }

$user_id=$_SESSION['user_id'];

if(isset($_POST['title'] ) || isset($user_id) ){

$title = $_POST['title'];

if($title != ''){

$author = $_POST['author'];

$publisher = $_POST['publisher'];

$status = $_POST['status'];

$query = "insert into books (title,author,publisher,status,user_id)

values

('$title','$author','$publisher','$status','$user_id')

";

$result=mysqli_query($con,$query);

if(!$result){

echo 'sorry, unable to process the request';

}

}

  

echo '

<div id="user_msg">

<h2>'.$usermsg.' </h2>

</div>

<div id="display">

<table id="display_books">
<tr>
<th>S.no</th>

<th>Title</th>

<th>Author</th>

<th>Publication</th>

<th>Status</th> ';

if(!isset($passkey)){

echo '<th>Remove</th>

</tr>';

}

if(isset($passkey)){

$query="select title,author,publisher,status from books where user_id='$passkey' ";

}

else{

$query="select title,author,publisher,status,book_id from books where user_id='$user_id' ";

}

$result=mysqli_query($con,$query);

$rows=mysqli_num_rows($result);

echo '<input type="hidden" name="count" value="'.$rows.'">';

for($i=0; $i<$rows; ++$i) {

  $j=$i+1;

	$row=mysqli_fetch_row($result);

	echo'<tr><td>'.$j.'</td>';

	echo'<td> ' .$row[0].'</td>' ;

	echo '<td>  ' .$row[1].'</td>';

	echo '<td>  ' .$row[2].'</td>';

	echo ' <td>'.$row[3]. '</td>';

	if(!isset($passkey)){echo '<td> <input name="book_id'.$i.'" value="'.$row[4].'" type="checkbox" class="books_list" id="book_id'.$i.'"> </td>';	}

	echo '</tr>';



	}

echo '</table>
</div>';

}

if(!isset($passkey)){

echo '<div style="position:absolute; top:80%;  left:0; width:100%; height:20%;">
<button id="add_books" onclick="entering()">Add Books </button>
</div>

<div id="entering_books">

<div id="adding_table">

<h3>Enter the Following details</h3>

<table style="margin-top:1.5em;">

<tr><td>Title</td><td><input type="text" placeholder="Title of the book" id="title"></input></td></tr>

<tr><td>Author</td><td><input type="text" placeholder="Author" id="author"></input></td></tr>

<tr><td>Publisher</td><td><input type="text" placeholder="Publication" id="publisher"></input></td></tr>

<tr><td>Status</td><td><input type="text" placeholder="ex- available, wish" id="status"></input></td></tr>

</table>

</div>

</div>

<div id="modal">

</div>
<div id="confirmation">
<p></p>
<form action="remove.php"  method="post"  id="remove_form" >

<input type="submit" class="button" value="delete"></input>
</form>
<button class="button" onclick="rem_can()" >Exit</button>
</div>';

}

?>