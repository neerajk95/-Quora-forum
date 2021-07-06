<?php
$login=false;

//Code for displaying logged name of the user
if(isset($_SESSION['userName']) && $_SESSION['login']=true){
   $login=true;
   $userName=$_SESSION['userName'];

    //Getting userImage from backend
    $getData=new Users();
    $usersInfo=$getData->getTheData("SELECT * FROM `users_info` where `userName`='$userName' ");
    foreach($usersInfo as $user){
        $userImage= $user['userImage'];//userImage
        $firstName= $user['firstName'];//userName
        }
     }
echo
    '<div class="head">
        <ul class="ul-list">
        <li class="none"> <a href="Quora.php"> <img src="icon/conversation.png" alt=""></a></li>
            <li class="nav-items home"><a href="Quora.php">Home </a></li>
            <li class="nav-items answer"><a href="questions.php">Questions</a></li>
            <li class="nav-items notification"><a href="">Notification</a></li>
            <form class="d-flex">
                <input class="form-control search-bar me-2" type="search" placeholder="Search" aria-label="Search">
               
            </form>
           ';
        if($login){
            echo'
          
        <li><div class="dropdown">
          <img class="profile-pic "  data-toggle="dropdown"  src="data:image/png;base64,'.base64_encode($userImage).'" alt="">
           <div class="dropdown-content">
            <a href="#">View Profile</a>
               <a href="logout.php">Logout</a>
             </div>
             </div></li>
             <li class="nav-userName" ><strong>'.$userName.'</strong></li>  
             </ul></div>';
          } 
       else{
        echo' <li class="right nav-items"><a href="login.php">Login</a></li>
         <li class="right nav-items"><a href="signup.php">signup</a></li>
        </ul>
        </div>';
        }