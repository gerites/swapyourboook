 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php
include 'con.php';
session_start();
$num = count($_POST);   
for($i=0;$i<$num+1;$i++) {
$buk = $_POST['book'.$i];
if($buk!='') {
	$query ="delete from books where book_id='$buk' ";
	$res=mysqli_query($con,$query);
}
}
	if($res) {
		echo '<script> alert("selected books removed successfully");
		window.location.href = "profile.php";
		</script>
		';
	}
	else {
    	echo '<script> alert("sorry,but there is an error.Try after some time.")
    	window.location.href = "profile.php";
    	</script>';
		}
?>