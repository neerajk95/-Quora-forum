<?php
include '../include/db.connect.php';

$answerId=$_POST['sno'];

$update=new InsertData();
$result=$update->query("UPDATE `answer` set `ansImg`=null where `ans_id`=$answerId");

?>