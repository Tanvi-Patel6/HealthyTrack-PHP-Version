<!-- ----Database Connection---- -->

<?php

$cn = mysqli_connect('localhost','root','','healthytrack');
if(!$cn){
	die("Connection faild: ").mysqli_connect_error();

}

?>