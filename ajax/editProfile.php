<?php
include '../include/db.connect.php' ;

 $userName=$_POST['userName'];
 $existPassword=md5($_POST['existPassword']);
 $password=md5($_POST['newPassword']);
 $pCheck=$_POST['newPassword'];	

 
$checkPass=new CheckFields();
$result=$checkPass->check("Select * from `users_info` where `userName`='$userName' and `password`='$existPassword'");

if($result==0){
	echo "Password is Incorrect";
}
else{		
	if (!preg_match('/^(?i)^(?=.*[a-z])(?=.*\d).{8,20}$/', $pCheck)) {
			echo 'password should contain at least 1 letter, 1 digit and min 8 characters';
		}
	else{	
	$insert=new InsertData();
	$insert->query("update `users_info` set `password`='$password' where `userName`='$userName'");
	echo "Successfully saved";
	}
}
?>

