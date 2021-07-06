<?php
session_start();
include 'include/db.connect.php';
include 'include/Validation.php';
include 'include/pagination.php';

//--------------------------------------------------------------------------------------------------------------------------
$questionId=$_SESSION['ques_id'];
$sql="SELECT users_info.userName as aUserName,users_info.userImage,questions.userName as qUserName,questions.post, questions.question,answer.answer,answer.ansImg,answer.DT FROM questions INNER JOIN answer on questions.ques_id=$questionId and answer.ques_id=$questionId INNER JOIN users_info on answer.userName=users_info.userName ORDER by  answer.DT desc ";

$answerSet=new Users();
$answerCount=$answerSet->getTheData("SELECT * FROM `answer` where `ques_id`=$questionId");
$data = new Pagination($sql,2,0);
 $dataSet = $data->get(0);
 $pageNumber = $data->pageNumber("SELECT * FROM `answer` where `ques_id`=$questionId");

foreach($dataSet as $aQuestions){
	$aUserName=$aQuestions['qUserName'];
	$aQuestion=$aQuestions['question'];
	$aDate=$aQuestions['post'];
}
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['pagebutton'])) {
	$value = htmlspecialchars($_REQUEST['pagebutton']);
	$offset = $value * 2;

	$data = new Pagination($sql, 2, $offset);
	$dataSet = $data->get();
	$pageNumber = $data->pageNumber("SELECT * FROM `answer` where `ques_id`=$questionId");
}
//--------------------------------------------------------------------------------------------------------------------------


if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['postfeedback'])) {
	$fUserName=$_SESSION['userName'];
	$fQuestionId=
	$feedbackInsert=new InsertData();
	$feedbackInsert->query("INSERT INTO `answer-feedback` (`ans_Id`, `ques_id`, `Likes`, `dislikes`, `datetime`) VALUES ('67', '98', 'kirsh123', 'kirsh123', '2021-07-06 15:53:18.000000')");
}


?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
		crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/answer.css">
	<link rel="stylesheet" href="css/navbar.css">
	<title>Answer</title>
</head>

<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
		crossorigin="anonymous">
	</script>

	<?php
    //include //'partials/navbar.php';
?>



	<div class="conatner main">
		<!-- Answer post -->
		<div class="conatiner answer-post">
			<h3 class=""><span style="color:#669999">
					<?php echo $aQuestion; ?>
				</span></h1>
				<p style="font-weight:bold;">-<span style="color: #5A79A5;">
						<?php echo $aUserName." ";?><span>
							<?php echo $aDate;?>
				</p>
				<form action="answer.editor.php" method="POST"></form>
				<p class="answer-btn">Answer</p>
				</form>

				<hr>
				<p><strong>
						<?php echo count($answerCount); ?> Answers
					</strong></p>
				<hr>
		</div>

		<div class="container post-answer my-4">
			<?php 

		foreach($dataSet as $aSet)
			echo '
			<div class="user-container">
				<img class="profile-pic user_img"  data-toggle="dropdown"  src="data:image/png;base64,'.base64_encode($aSet["userImage"]).'" alt="">
				<p class="user-college" style="color:#5A79A5;font-weight:bold;">From IIT Kharagpur</p>
				<p class="user-name"><strong>'.$aSet["aUserName"].'</strong></p>
				<p class="user-date" style="color:#5A79A5;font-weight:bold;">answerd on '.$aSet["DT"].'</p>
			</div>
			<div class="user-post my-4">
			'.nl2br($aSet['answer']).'

			<form method="post" action="'.$_SERVER["PHP_SELF"].'">
			<div class="container flex my-4">
				<input type="text" style="display: none;" name="answerId" value="'.$aSet[ans_id].'">;
				<button type="submit" class="btn btn-primary"  id="like" name="postfeedback" value="">Likes(12)</button>
				<button type="submit" class="btn btn-primary" id="dislike" name="postfeedback" value="">Dislikes(1)</button>
			</form>

				<button type="button" class="btn btn-primary">Comments</button>	
			</div>
			<div class="container rounded comment my-4">
				<input type="text" class="form-control rounded" id="comment" placeholder="Comment here......">
			<hr>
			<div class="container comments">
			<div class="user-container">
				<img class="profile-pic lol user_img"  data-toggle="dropdown"  src="data:image/png;base64,'.base64_encode($aSet["userImage"]).'" alt="">
				<p class="user-college" style="color:#5A79A5;font-weight:bold;"><a href="like">like</a> (12) <a href="">dislike</a> (1) <a href="">reply</a></p>
				<p class="user-name"><strong>'.$aSet["aUserName"].'</strong></p>
				<p class="user-date" style="color:#5A79A5;font-weight:bold;">Commented on '.$aSet["DT"].'</p>
			</div>
			<div class="container comments">
			<p class="my-2 comment-left" style="margin-left: 50px; ">Nice One!</p>
		        </div>	
			<p class="my-2 text-center"; "><a href="">View Replies</a></p>	
			<p class="my-2 text-center"; "><a href="">Collaspe</a></p>
			
				<input type="text" class="form-control rounded" id="comment" placeholder="Reply here">
			
			<div class="user-container my-2" style="margin-left:50px">
				<img class="profile-pic lol user_img"  data-toggle="dropdown"  src="data:image/png;base64,'.base64_encode($aSet["userImage"]).'" alt="">
				<p class="user-college" style="color:#5A79A5;font-weight:bold;"><a href="like">like</a> (12) <a href="">dislike</a> (1) <a href="">reply</a></p>
				<p class="user-name"><strong>'.$aSet["aUserName"].'</strong></p>
				<p class="user-date" style="color:#5A79A5;font-weight:bold;">Replied on '.$aSet["DT"].'</p>
			</div>
			<p class="" style="margin-left:100px; ">Thanks</p>
			<p class="my-2 text-center"; "><a href="">Show more</a></p>	
			<p class="my-2 text-center"; "><a href="">Collaspe</a></p>		
		        </div>
			</div>
		      			
		       </div>
		           
		       <hr>
		       ';

?>

			<div class="btn-toolbar my-4" role="toolbar" aria-label="Toolbar with button groups">
				<div class="btn-group me-2" role="group" aria-label="First group">
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<button type="" class="btn pagebuttton btn-primary">Page no.</button>
						<?php
					//Displaying numbers of pages
					for ($i = 0; $i < $pageNumber; $i++) {
						echo '<button type="submit" name="pagebutton" id="pgBtn" value="' . $i . '" class="btn ml-1 pagebuttton btn-primary">' . $i . '</button>';
					}
					?>
					</form>
				</div>
			</div>
		</div>
	</div>


</body>

</html>