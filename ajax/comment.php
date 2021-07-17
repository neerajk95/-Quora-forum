<?php
include '../include/db.connect.php' ;

$answerId=$_POST['ans_id'];
$userName=$_POST['userName'];
$comment=$_POST['commentText'];


$submit= new InsertData();
$result=$submit->query("INSERT INTO `comments` (`c_Id`, `ans_Id`, `userName`, `comment`) VALUES (NULL, '$answerId', '$userName', '$comment')");

?>