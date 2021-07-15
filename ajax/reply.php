<?php
include '../include/db.connect.php' ;

$answerId=$_POST['ans_id'];
$userName=$_POST['userName'];
$replyText=$_POST['replyText'];
$cid=$_post['cid'];

$submit= new InsertData();
$result=$submit->query("INSERT INTO `comments` (`c_Id`, `ans_Id`, `userName`, `comment`) VALUES (NULL, '$answerId', '$userName', '$comment')");



?>