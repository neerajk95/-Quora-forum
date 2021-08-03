<?php
include '../include/db.connect.php' ;


$userName=$_POST['userName'];

$insert=new InsertData();


	// Get file info 
	$fileName = basename($_FILES["photoFile"]["name"]);
	$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

	// Allow certain file formats 
	$allowTypes = array('jpg', 'png', 'jpeg');
	if (in_array($fileType, $allowTypes)) {
		$image = $_FILES['photoFile']['tmp_name'];
		$imgContent = addslashes(file_get_contents($image));
		
	} else {
		echo "Accept only jpg png jpeg formats only";
	}
?>