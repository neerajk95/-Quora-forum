<?php
session_start();
include 'include/db.connect.php';
$userName=$_SESSION['userName'];

$data=new users();
$currentUser=$data->getTheData("SELECT * FROM `users_info` where `userName`='$userName'");

foreach($currentUser as $data){
$firstName=$data['firstName'];
$lastName=$data['lastName'];
$userNamei=$data['userName'];
$email=$data['email_id'];

if($data['CurrentJob']==NULL){
$profession="Not Given";
}
else{
	$profession=$data['CurrentJob'];
}

if($data['CurrentJob']==NULL){
	$userImage="";
	}
	else{
		$userImage=$data['userImage'];
	}



if($data['dateOfBirth']==NULL){
$dob="Not Given";
}
else{
	$dob=$data['dateOfBirth'];
}	

if($data['phno']==0){
	$phno="Not Given";
	}
	else{
		$phno=$data['phno'];
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
		id="bootstrap-css">
	<link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/profile.css">
	<script src="script/jquery.js" type="text/javascript"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<title>profile</title>
	<style>
	.profile-edit-btn {
		border: none;
		border-radius: 1.5rem;
		width: 100% !important;
		padding: 2%;
		font-weight: 600;
		color: #6c757d;
		cursor: pointer;
		margin: 20px !important;
	}
	</style>
</head>

<body>
	<?php include 'partials/navbar.php'; 

echo '
<div class="container" style="position:absolute; margin-top:112px;margin-left:429px;border-radius: 25px;">
<img src="data:image/png;base64,'.base64_encode($userImage).'"
						alt="" height="250px"  and width="250px"/>
						
					
</div>
<div class="container emp-profile">
	<form method="post">
		<div class="row">
			<div class="col-md-4">
				<div class="profile-img">
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="profile-head">
					<h5>
					'.$firstName." ".$lastName.'
					</h5>
					<h6>
						'.$profession.'
					</h6>
					<p class="proile-rating"><span></span></p>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab"
								href="#home" role="tab" aria-controls="home"
								aria-selected="true">About</a>
						</li>
						
					</ul>
				</div>
			</div>
			<div class="col-md-2">
				<div class="flex" style="display: flex;">
				<a style="margin:5px;" ><input type="button" class="profile-edit-btn" name="btnAddMore"  value="Change Password" data-toggle="modal" data-target="#exampleModal" /></a>
				<a style="margin:5px;"><input type="button" class="profile-edit-btn" name="btnAddMore" value="Change photo" data-toggle="modal" data-target="#changeImage"" /></a>
				<a href="editProfile.php" style="margin:5px;"><input type="button" class="profile-edit-btn" name="btnAddMore" value="Edit Profile" /></a>
			</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="profile-work">
					
				</div>
			</div>
			<div class="col-md-8">
				<div class="tab-content profile-tab" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel"
						aria-labelledby="home-tab">
						<div class="row">
							<div class="col-md-6">
								<label>User Name</label>
							</div>
							<div class="col-md-6">
								<p>'.$userNamei.'</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Name</label>
							</div>
							<div class="col-md-6">
								<p>'.$firstName." ".$lastName.'</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Email</label>
							</div>
							<div class="col-md-6">
								<p>'.$email.'</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Phone</label>
							</div>
							<div class="col-md-6">
								<p>'.$phno.'</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Profession</label>
							</div>
							<div class="col-md-6">
								<p>'.$profession.'</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Date of Birth</label>
							</div>
							<div class="col-md-6">
								<p>'.$dob.'</p>
							</div>
						</div>
						
					</div>
					<div class="tab-pane fade" id="profile" role="tabpanel"
						aria-labelledby="profile-tab">
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	
</div>

';?>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="password" class="form-control my-2" id="existPassword"
						aria-describedby="emailHelp" placeholder="Write Existing Password">
					<input type="password" class="form-control my-2" id="enterPassword"
						aria-describedby="emailHelp" placeholder="Write new password">
					<input type="password" class="form-control my-2" id="confirnPassword"
						aria-describedby="emailHelp" placeholder="confirm passowrd">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger"
						data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" onclick="passswordClick('<?php echo $userName;?>')">Update</button>
				</div>
			</div>
		</div>
	</div>

	<!-- change image modal -->
	<div class="modal fade" id="changeImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="changePhoto">Change Photo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="image-upload my-4 text-center">
							<label class="form-label" for="customFile">Upload Image</label>
							<input type="file" class="form-control" name="image"
								id="customFile" />

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger"
							data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" onclick="changePhoto('<?php echo $userName;?>')">Update</button>
					</div>
				</div>
			</div>
		</div>



		<!-- javascript  -->
		<script>
		function passswordClick(userName) {
			var exitPassword=$("#existPassword").val();
			var newPassword=$("#newPassword").val();
			var confirmPassword=$("#confirmPassword").val();
			$.ajax({
				url: 'ajax/loadComment.php',
				type: 'post',
				data: '&existPassword=' + exitPassword + '&newPassword=' + newPassword+'&confirmPassword=' + confirmPassword+'&userName=' + userName,
				success: function(result) {
					
				}
			})
		}
		


		function changePhoto(userName) {
			var photoFile=$("#changePhoto").val();
			$.ajax({
				url: 'ajax/loadComment.php',
				type: 'post',
				data: '&userName=' + userName + '&photoFile=' + photoFile,
				success: function(result) {
					
				}
			})
		}
		</script>


</body>

</html>