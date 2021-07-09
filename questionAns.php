<?php
session_start();
//if  user is not login
if (!isset($_SESSION['userName']) && $_SESSION['login'] = true) {
	$_SESSION["notLogin"] = true;
	header("location:login.php");
}

require 'include/db.connect.php';
require 'include/Validation.php';
require 'include/pagination.php';
$userName = $_SESSION['userName'];

//Getting question id 


// //Default code for pagination
 $data = new Pagination("SELECT `question` form `questions` " , 10, 0);
 $questionSet = $data->get(0);
 $pageNumber = $data->pageNumber("SELECT * FROM `questions`");

 if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['pagebutton'])) {
 	$value = htmlspecialchars($_REQUEST['pagebutton']);

	// //Setting the limit and offset to retrive required data
 	$offset = $value * 10;

 	$data = new Pagination("SELECT * from `questions` order by `questions`.`post` desc", 10, $offset);
 	$questionSet = $data->get();
 	$pageNumber = $data->pageNumber("SELECT * FROM `questions`");
 }





//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['question-click'])) {
	$questionId = htmlspecialchars($_REQUEST['quesid']);
	$_SESSION['questionId'] = $questionId;
	header("location:answer.editor.php");
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['question-click'])) {
	$questionId = htmlspecialchars($_REQUEST['quesid']);
	$_SESSION['questionId'] = $questionId;
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="css/questions.css">
	<link rel="stylesheet" href="css/navbar.css">
	<title>Questions</title>
</head>

<body>
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


	<?php include 'partials/navbar.php'; ?>
	<div class="conatiner center">
		<div class="btn-group">
			<a href="questions.php" class="btn btn-primary " id="questions" aria-current="page">Questions</a>
			<a href="questionAsked.php" class="btn btn-primary" id="questionAskedByYou">Asked By Me</a>
			<a href="questionAns.php" class="btn btn-primary active" id="answerdByYou">Answerd By Me</a>
		</div>


		<?php
		//Retriving questions and displaying it
		// foreach($questionSet as $question){
		// echo '<div class="container questionDiv" name="question" type="submit">
		// <p>'.$question["question"].' Asked by'.$question["userName"].'<p>
		// </div>';
		// }
		?>
		<table class="table table-bordered table-hover my-4">
			<thead class="table-primary">
				<tr class="table-click">
					<th scope="col">Asked By</th>
					<th scope="col" colspan="3">Questions</th>
					<th scope="col" colspan="2">Posted On</th>
					<th scope="col">Answer</th>
				</tr>
				</thead>

			<?php
			if (empty($questionSet)) {
				echo('</table>');
				echo('<p class="text-center" style="color:red"><strong>No one Asked question!</strong></p>');
			     
			   }
			else{
			foreach ($questionSet as $question) {
				if($userName==$question['userName']){
					$question['userName']="ME";
				}
				//echo $question["ques_Id"];		
				echo '	
			<form method="post" action="'.$_SERVER["PHP_SELF"].'">
			<input type="text" name="quesid" style="display:none" value="' . $question["ques_Id"] . '">				
 			 <tbody>
  			  <tr>
   			  <th scope="row" name="qUserName">' . $question["userName"] . '</th>
     			 <td colspan="3">' . $question["question"] . '</td>
     			 <td colspan="2">' . $question["post"] . '</td>
			 <td><button class="btn btn-primary" type="Submit" name="question-click">Answer</button></td> 
   			 </tr>
  			</tbody>
			</form>
			
			';
			}

		}
			?>


</table>
		<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
			<div class="btn-group me-2" role="group" aria-label="First group">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<button type="" class="btn pagebuttton btn-primary">Page no.</button>
					<?php
					//Displaying numbers of pages
					for ($i = 0; $i < $pageNumber; $i++) {
						echo '<button type="submit" name="pagebutton" id="pgBtn" value="' . $i . '" class="btn pagebuttton btn-primary">' . $i . '</button>';
					}
					?>
				</form>
			</div>
		</div>

		<script>

		</script>




</body>

</html>