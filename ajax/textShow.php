<?php
include '../include/db.connect.php';
// $answerId=$_POST['ans_id'];
$answerId=$_POST['ans_id'];
$type=$_POST['type'];

$data=new Users();
$answer=$data->getTheData("Select `answer` from `answer` where `ans_id`=$answerId");
foreach($answer as $answer){
	$string=nl2br($answer['answer']);

}
if($type=="more"){
echo $string .= '<a style="cursor: pointer; color:rgb(52, 124, 219);text-decoration: underline;"  type="button"  onclick="showText(\'collapse\',\''.$answerId.'\')" >collapse</a>';
}
if($type=="collapse"){
	$string=substr($string,0,1000);
	echo $string .= '...<a style="cursor: pointer; color:rgb(52, 124, 219);text-decoration: underline;"  onclick="showText(\'more\',\''.$answerId.'\')" >Read more</a>';
}
?>