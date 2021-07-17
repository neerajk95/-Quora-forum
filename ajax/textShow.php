<?php
include '../include/db.connect.php';
// $answerId=$_POST['ans_id'];
$answerId=$_POST['answer'];

$data=new Users();
$answer=$data->getTheData("Select `answer` from `answer` where `ans_id`=$answerId");
foreach($answer as $answer){
	echo nl2br($answer['answer']);
}
?>