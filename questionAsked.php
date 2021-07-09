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

 $data=new Pagination("SELECT * from `questions` where `userName`='$userName' order by `questions`.`post` desc",10,0);
 $questionSet=$data->get();
 $pageNumber=$data->pageNumber("SELECT * from `questions` WHERE `userName`='$userName'");
 
  if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['pagebutton'])){

  $value = htmlspecialchars($_REQUEST['pagebutton']);

 // //Setting the limit and offset to retrive required data
  $offset=$value*10;

  $data=new Pagination("SELECT * from `questions` where `userName`='$userName' order by `questions`.`post` desc",10,$offset);
  $questionSet=$data->get();
  $pageNumber=$data->pageNumber("SELECT * from `questions` WHERE `userName`='$userName'");
  }


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['question-delete'])) {
	$questionId = htmlspecialchars($_REQUEST['quesid']);
	$delete=new InsertData();
	$result=$delete->query(" DELETE FROM `questions` WHERE `ques_id`=$questionId;");
	echo "<td><a onClick=\"javascript: return confirm('Please confirm deletion');\" href='delete.php?id=".$query2['id']."'>x</a></td><tr>";
	header("Refresh:0");

}
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['question-edit'])) {
	$questionId = htmlspecialchars($_REQUEST['quesid']);
	$_SESSION['questionIdEdit']=$questionId;
	header("location:question.editor.php");

}

?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
		crossorigin="anonymous">
	<link rel="stylesheet" href="css/questions.css">
	<link rel="stylesheet" href="css/navbar.css">
	<title>Questions</title>
</head>

<body>
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
		crossorigin="anonymous"></script>


	<?php include 'partials/navbar.php'; ?>
	<div class="conatiner center">
		<div class="btn-group">
			<a href="questions.php" class="btn btn-primary " id="questions"
				aria-current="page">Questions</a>
			<a href="questionAsked.php" class="btn btn-primary active" id="questionAskedByYou">Asked By Me</a>
			<a href="questionAns.php" class="btn btn-primary" id="answerdByYou">Answerd By Me</a>
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
					<th scope="col" colspan="3">Questions</th>
					<th scope="col">Posted On</th>
					<th scope="col">Answer</th>
					<th scope="col">Delete</th>
				</tr>
			</thead>

			<?php
			if (empty($questionSet)) {
				echo('</table>');
				echo('<p class="text-center" style="color:red"><strong>No records!</strong></p>');
			     
			   }
			else{
			foreach ($questionSet as $question) {
				//echo $question["ques_Id"];	
				$phpdate = strtotime( $question['post'] );
			        $mysqldate = date( 'j  F, Y g:i a', $phpdate );		
				echo '	
			<form method="post" action="'.$_SERVER["PHP_SELF"].'">	
			<input type="text" name="quesid" style="display:none" value="' . $question["ques_Id"] . '">				
 			 <tbody>
  			  <tr>
     			 <td colspan="3">' . $question["question"] . '</td>
     			 <td>' . $mysqldate . '</td>
			 <td><button class="btn btn-warning" type="Submit" name="question-edit">Edit</button></td> 
			 <td><button class="btn btn-danger" type="Submit" name="question-delete">Delete</button></td>
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