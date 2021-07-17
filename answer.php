<?php
session_start();
include 'include/db.connect.php';
include 'include/Validation.php';
include 'include/pagination.php';
$userName=$_SESSION['userName'];
$questionId=$_SESSION['ques_id'];

//--------------------------------------------------------------------------------------------------------------------------

$sql="SELECT answer.ansImg,answer.ans_id,users_info.userName as aUserName,users_info.userImage,questions.userName as qUserName,questions.post, questions.question,answer.answer,answer.ansImg,answer.DT FROM questions INNER JOIN answer on questions.ques_id=$questionId and answer.ques_id=$questionId INNER JOIN users_info on answer.userName=users_info.userName ORDER by  answer.DT desc ";

$answerSet=new Users();
$answerCount=$answerSet->getTheData("SELECT * FROM `answer` where `ques_id`=$questionId");
$data = new Pagination($sql,2,0);
 $dataSet = $data->get(0);
 $pageNumber = $data->pageNumber("SELECT * FROM `answer` where `ques_id`=$questionId");

 
foreach($dataSet as $aQuestions){
	$aUserName=$aQuestions['qUserName'];
	$aQuestion=$aQuestions['question'];
	$dateTime=$aQuestions['post'];
	$answerId=$aQuestions['ans_id'];
	
}
echo $answerId;
//Checking if user already answere the question
$check=new Users();
$answerCheck=$check->getTheData("SELECT * FROM `answer` WHERE `ques_id`=$questionId and `ans_id`='$answerId' and `userName`='$userName' ");
if(!empty($answerCheck)){
	$displayAnswer="d-none";
}
$phpdate = strtotime($dateTime);
$aDate = date( 'j  F, Y @ g:i a', $phpdate );
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
if(isset($_POST['answer'])){
	$_SESSION['questionId']=$questionId;
	header("location:answer.editor.php");
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
	<script src="script/jquery.js" type="text/javascript"></script>
	<title>Answer</title>
</head>

<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
		crossorigin="anonymous">
	</script>

	<?php
    include 'partials/navbar.php';
?>



	<div class="conatner main">
		<!-- Answer post -->
		<div class="conatiner answer-post">
			<h1 class=""><span style="color:#669999">
					<?php echo $aQuestion; ?>
				</span></h1>
			<p style="font-weight:bold;">-<span style="color: #5A79A5;">
					<?php echo $aUserName." ";?><span>
						<?php echo $aDate;?>
					</span>
			</p>
			<form action="answer.php" method="POST">
				<button class="answer-btn btn btn-primary <?php echo $displayAnswer ?? ''; ?> "
					type="submit" name="answer">Answer</button>
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
				if(empty($aSet)){
					echo '<p style="color:red";font-weight:bold;>No one Answered</p>';
				}
				$phpdate = strtotime( $aSet['DT'] );
				$mysqldate = date( 'j  F, Y @ g:i a', $phpdate );	
				if($aSet['ansImg']==Null){
					$displayImage="d-none";
				}	

				$string = $aSet['answer'];
				if (strlen($string) > 1000) {
				    $limit_text = substr($string, 0, 1000);
				    $endPoint = strrpos($limit_text, ' ');
				    $string = $endPoint? substr($limit_text, 0, $endPoint):substr($limit_text, 0);
				    $string .= '... <a style="cursor: pointer; color:rgb(52, 124, 219);text-decoration: underline;"   onclick="showText(\'more\',\''.$aSet['ans_id'].'\')" >Read More</a>';
				}
				$answerId=$aSet['ans_id'];
				//Counting likes and dislikes
				$count=new CheckFields();
				$likes=$count->check("select * from `likes` where `ans_id`='$answerId'");
				$dislikes=$count->check("select * from `dislikes` where `ans_id`='$answerId'");		

			echo '
			
			<div class="user-container">
				<img class="profile-pic user_img"  data-toggle="dropdown"  src="data:image/png;base64,'.base64_encode($aSet["userImage"]).'" alt="">
				<p class="user-college" style="color:#5A79A5;font-weight:bold;"></p>
				<p class="user-name"><strong>'.$aSet["aUserName"].'</strong></p>
				<p class="user-date" style="color:#5A79A5;font-weight:bold;">on '.$mysqldate.'</p>
			</div>
			<div class="user-post my-4"> 
			
			<p class="show-read-more"  id="textShow">'.nl2br($string).'</p>
			
		        <div class="'.$displayImage .'">
			<img src="data:image/png;base64,'.base64_encode($aSet['ansImg']).'"  class="squareImage my-2" alt="">
			</div>
			        
				<button type="button" class="btn  btn-outline-danger" id="like_btn" onclick="like_update(\'like\',\'like_'.$aSet["ans_id"].'\',\''.$aSet["ans_id"].'\',\''.$questionId.'\',\''.$userName.'\' )"> like (<span id="like_'.$aSet['ans_id'].'">'.$likes.'</span>) </button>
				<button type="button" class="btn  btn-outline-danger" onclick="dislike_update(\'dislike\',\'dislike_'.$aSet["ans_id"].'\',\''.$aSet["ans_id"].'\',\''.$questionId.'\',\''.$userName.'\' )">dislike (<span id="dislike_'.$aSet['ans_id'].'">'.$dislikes.'</span>) </button>
				<button class="btn btn-primary" id="Comment" onclick="showComment(\'retriveComment\'.\''.$aSet['ans_id'].'\')">Comment</button>
			</div> 
			<div class="container d-none rounded comment" id="commentDiv">
				<div class="" style="display: flex;">
				<textarea type="text" name="question" style="margin-top: 0px; margin-bottom: 0px; height: 40px !important;border-radius: 30px!important;" class="form-control"
					 placeholder="Write your comment here. Limit 120 Characters"
					aria-label="Username" id="commentText" aria-describedby="addon-wrapping"></textarea>
				<button class="btn btn-primary" style="margin-left: 5px !important;"  onclick="comment(\'comment\',\''.$aSet["ans_id"].'\',\''.$userName.'\')">comment</button>
			        </div>
			</div>
		
			<div>
			<div class="container commentdiv " style="margin:0;" >
			<div class="user-container">
				<img class="profile-pic lol user_img"  data-toggle="dropdown"  src="data:image/png;base64,'.base64_encode($aSet["userImage"]).'" alt="">
				<p class="user-college" style="color:#5A79A5;font-weight:bold;"><a href="like">like</a> (12) <a href="">dislike</a> (1) <a href="">reply</a></p>
				<p class="user-name"><strong>'.$aSet["aUserName"].'</strong></p>
				<p class="user-date" style="color:#5A79A5;font-weight:bold;">12 jan 2019 @ 12:20</p>
				
			</div>
			<pre class="my-3 pre">so rambunctious that his mother q.</pre>
		      	</div>		
		       <hr>';

?>
			<script>
				//Function for like
				function like_update(type, like_id, ans_id, ques_id, userName) {
					var str = like_id.substring(4);
					var dislike_id="dislike".concat(str);
					console.log(dislike_id);
					$.ajax({
						url: 'ajax/likes.php',
						type: 'post',
						data: 'lol=like,&like_id=' + like_id + '&ans_id=' + ans_id + '&ques_id=' + ques_id +
							'&userName=' + userName + '&type=' + type,
						success: function (result) {
							console.log(result[0]);
							console.log(result[1]);
							console.log(result[2]);
							$('#'+like_id).html(result[0]);
							$('#'+dislike_id).html(result[1]);

							if(typeof result[2] === 'undefined') {
								$('#like_btn').addClass('btn-danger');
								$('#like_btn').addClass('btn-danger');
								console.log("hrry");
									}
							// else{
							// 	$('#'+like_id).removeClass('btn-danger');
							// }		
							// if ($( '#'+dislike_id).hasClass('btn-danger')){
							// 	$('#'+dislike_id).removeClass('btn-danger')
							// }
						}
					})
					
				}
				//Function for dislike
				function dislike_update(type, like_id, ans_id, ques_id, userName) {
					var str = like_id.substring(7);
					var dislike_id="like".concat(str);
					console.log(dislike_id);
					console.log("Set ho gya mai dusri barr bhi");
					$.ajax({
						url: 'ajax/likes.php',
						type: 'post',
						data: 'lol=like,&like_id=' + like_id + '&ans_id=' + ans_id + '&ques_id=' + ques_id +
							'&userName=' + userName + '&type=' + type,
						success: function (result) {
							$('#'+like_id).html(result[1]);
							$('#'+dislike_id).html(result[0]);

						}
					})
				}

				//Switching commnet
			    function showComment(type,ans_id){
			                      
					console.log("set ho gaya bhai");
					if ($("#commentDiv").hasClass("d-none")) {
						$(".comment").removeClass("d-none");
					} else {
						$(".comment").addClass("d-none");
						
					}
				
					//document.getElementById("commentText").value=null;
					$.ajax({
						url: 'ajax/comment.php',
						type: 'post',
						data: 'lol=like,&type=' + type +'&ans_id=' + ans_id + '&userName=' + userName+'&commentText='+commentText,
						success: function (result) {
							$('#commentText').val('');
							
						}
					})
			}

				function comment(type,ans_id, userName) {
					console.log("Comment set");
					var commentText = $('#commentText').val();
					console.log(commentText);
					//document.getElementById("commentText").value=null;
					$.ajax({
						url: 'ajax/comment.php',
						type: 'post',
						data: 'lol=like,&type=' + type +'&ans_id=' + ans_id + '&userName=' + userName+'&commentText='+commentText,
						success: function (result) {
							$('#commentText').val('');
							
						}
					})
					 
				}
				function showText(type, ans_id) {
					console.log("text show karega");
					//document.getElementById("commentText").value=null;
					$.ajax({
						url: 'ajax/textShow.php',
						type: 'post',
						data: 'lol=like,&ans_id=' + ans_id + '&type=' + type,
						success: function (result) {
							document.getElementById('textShow').value = '';
							$('#textShow').empty();
							 $("#textShow").append(result);
						}
					})
					 
				}
				
			</script>




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