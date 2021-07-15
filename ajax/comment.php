<?php
include '../include/db.connect.php' ;

$type=$_POST['type'];
$answerId=$_POST['ans_id'];
$userName=$_POST['userName'];
$comment=$_POST['commentText'];

switch ($type) {
	case "comment":
		$sql=;
        case "reply":
		$sql="INSERT INTO `reply` (`reply_id`, `ans_id`, `cid`, `userName`, `reply`) VALUES (NULL, '$answerId', '$cid', '$userName', '$reply');";
	}

$submit= new InsertData();
$result=$submit->query("INSERT INTO `comments` (`c_Id`, `ans_Id`, `userName`, `comment`) VALUES (NULL, '$answerId', '$userName', '$comment')");



?>