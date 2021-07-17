<?php
include '../include/db.connect.php';

$type = $_POST['type'];
$like_id = $_POST['like_id'];
$answerId = $_POST['ans_id'];
$questionId = $_POST['ques_id'];
$userName = $_POST['userName'];




switch ($type) {
	case "like":
		$checkSql = "select * from `likes` where `ans_id`='$answerId' and `ques_id`='$questionId' and `liked_userName`= '$userName'";
		$insertSql = "INSERT INTO `likes` (`likeId`, `ques_id`, `ans_id`, `liked_userName`) VALUES (NULL, '$questionId', '$answerId', '$userName');";
		$deleteSql = "DELETE FROM `dislikes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `dislike_userName`='$userName'";
		$countLike = "select * from `likes` where `ans_id`='$answerId'";
		$countDislike = "select * from `dislikes` where `ans_id`='$answerId'";
		$checkAlready = "select * from `likes` where `ans_id`='$answerId' and `liked_userName`='$userName'";
		$checkDelete = "DELETE FROM `likes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `liked_userName`='$userName'";
		break;
	case "dislike":
		$checkSql = "select * from `dislikes` where `ans_id`='$answerId' and `ques_id`='$questionId' and `dislike_userName`= '$userName'";
		$insertSql = "INSERT INTO `dislikes` (`dislike_id`, `ques_id`, `ans_id`, `dislike_userName`) VALUES (NULL, '$questionId', '$answerId', '$userName');";
		$deleteSql = "DELETE FROM `likes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `liked_userName`='$userName'";
		$countLike = "select * from `likes` where `ans_id`='$answerId'";
		$countDislike = "select * from `dislikes` where `ans_id`='$answerId'";
		$checkAlready = "select * from `dislikes` where `ans_id`='$answerId' and `dislike_userName`='$userName'";
		$checkDelete = "DELETE FROM `dislikes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `dislike_userName`='$userName'";
		break;


	case "clike":
		$checkSql = "select * from `likes` where `ans_id`='$answerId' and `ques_id`='$questionId' and `liked_userName`= '$userName'";
		$insertSql = "INSERT INTO `likes` (`likeId`, `ques_id`, `ans_id`, `liked_userName`) VALUES (NULL, '$questionId', '$answerId', '$userName');";
		$deleteSql = "DELETE FROM `dislikes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `dislike_userName`='$userName'";
		$count = "select * from `likes` where `ans_id`='$answerId'";
		break;
	case "cdislike":
		$checkSql = "select * from `dislikes` where `ans_id`='$answerId' and `ques_id`='$questionId' and `dislike_userName`= '$userName'";
		$insertSql = "INSERT INTO `dislikes` (`dislike_id`, `ques_id`, `ans_id`, `dislike_userName`) VALUES (NULL, '$questionId', '$answerId', '$userName');";
		$deleteSql = "DELETE FROM `likes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `liked_userName`='$userName'";
		$count = "select * from `dislikes` where `ans_id`='$answerId'";
		break;


	case "rlike":
		$checkSql = "select * from `likes` where `ans_id`='$answerId' and `ques_id`='$questionId' and `liked_userName`= '$userName'";
		$insertSql = "INSERT INTO `likes` (`likeId`, `ques_id`, `ans_id`, `liked_userName`) VALUES (NULL, '$questionId', '$answerId', '$userName');";
		$deleteSql = "DELETE FROM `dislikes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `dislike_userName`='$userName'";
		$count = "select * from `likes` where `ans_id`='$answerId'";
		break;
	case "rdislike":
		$checkSql = "select * from `dislikes` where `ans_id`='$answerId' and `ques_id`='$questionId' and `dislike_userName`= '$userName'";
		$insertSql = "INSERT INTO `dislikes` (`dislike_id`, `ques_id`, `ans_id`, `dislike_userName`) VALUES (NULL, '$questionId', '$answerId', '$userName');";
		$deleteSql = "DELETE FROM `likes` WHERE `ques_id`='$questionId' and `ans_id`='$answerId' and `liked_userName`='$userName'";
		$count = "select * from `dislikes` where `ans_id`='$answerId'";
		break;
}

$check = new CheckFields();
$perform = new InsertData();
$get = new Users();

$checkAlreadyLiked = $check->check($checkAlready);
if ($checkAlreadyLiked == 1) {
	$delete = $perform->query($checkDelete);
} else {
	$checkFunction = $check->check("$checkSql");
	if ($checkFunction == 0) {
		$insert = $perform->query("$insertSql");
		$delete = $perform->query("$deleteSql");
	}
}
//Outputing the count of likes and dislikes
$like = $check->check("$countLike");
$dislike = $check->check("$countDislike");
$a = array($like, $dislike);
$checkAlreadyLiked = $check->check($checkAlready);

if ($checkAlreadyLiked == 1) {
	array_push($a, "btn-danger");
	foreach ($a as $a) {
		echo $a;
	}
} else {
	foreach ($a as $a) {
		echo  $a;
	}
}
