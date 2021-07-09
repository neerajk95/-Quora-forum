<?php

//php script to save question to datbase
if(isset($_POST['modal-question'])){
  if(isset($_SESSION['userName']) && $_SESSION['login']=true){
$userName=$_SESSION['userName'];
echo $userName;
$question=$_POST['question'];

$validate=new ModalVal($_POST);

//Checking if Quesiton is already exist or note
$checkQuestions=new CheckFields();
$checkResult=$checkQuestions->check("SELECT * FROM  `questions` where `question`='$question'");
if($checkResult>0){
     $validate->addError("questExist","Question already exist");
}


//Validating the modal class
$errors=$validate->validateForm();

//if error array is null Saving the data into database
if($errors==NULL){

$result=$validate->addingQuestionMark($question);
$questionWithMarks=$result;
echo $userName;

//Instanseiting function to insert data to datbase
$insertQuestion=new InsertData();
$result=$insertQuestion->query("INSERT INTO `questions` (`ques_Id`, `question`, `userName`, `post`) VALUES (NULL, '$questionWithMarks', '$userName', current_timestamp())");
//validating the modal question
$validate->addError("question-added","Question Added");
$errors=$validate->validateForm();
}
}
}

?>
