<?php
session_start();
$uid= $_SESSION['user_id'];
echo $uid;
?>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var myVar;
function start() {
      clearTimeout(myVar);
    myVar = setTimeout(function(){alert("Hello")}, 3000);
}
</script>
<script>
setTimeout(function(){
$("#fuck").hide()
alert('function 1');
$("#fuck").show()
fun2();
}, 2000)
function fun2(){
alert('function 2');
}
</script>
<input type="text"  onkeyup="start()"></input>
<div id="fuck">
<h1>hey</h1>
</div>