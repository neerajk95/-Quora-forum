<?php
include '../include/db.connect.php' ;



$type=$_POST['type'];
$answerId=$_POST['ans_id'];
$userName=$_POST['userName'];
$comment=$_POST['commentText'];

switch($type){
              
	 case "comment":     $submit= new InsertData();
              $result=$submit->query("INSERT INTO `comments` (`c_Id`, `ans_Id`, `userName`, `comment`) VALUES (NULL, '$answerId', '$userName', '$comment')");
	
	case "retriveComment":
	       $getData=new Users();
	      $retriveFields=$getData->getTheData("SELECT u.userImage,c.c_id,c.comment,c.dateTime,c.userName,c.dateTime from comments c join users_info u on u.userName=c.userName where c.ans_id='$answerId' order by c.dateTime desc");
	      foreach($retriveFields as $retriveFields){
			$commentFields= $retriveFields;
	      }
	      if(!empty($commentFields)){
		      echo $commentFields;
	      }	   

}
echo $answerId.$userName.$comment;
?>