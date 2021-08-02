<?php
include 'include/db.connect.php' ;

 $userName='krish123';
 $password=md5("hellokrish123");


$insert=new InsertData();
	$insert->query("update `users_info` set `password`='$password' where `userName`='$userName'");
	echo "Successfully saved";

?>
