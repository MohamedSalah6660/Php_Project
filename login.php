<?php

session_start();


$pageTitle = 'Login';

$no_navbar = '';

include "init.php";

if(isset($_SESSION['user'])){

	header('Location: index.php'); 
	
	}
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		if (isset($_POST['login'])) {
			# code...
		
		$user = $_POST['username'];
		$pass = $_POST['password'];
		
		$hashedPass = sha1($pass);
		 
	
	
	
	$stmt = $con->prepare("SELECT UserID,  Username, Password from users WHERE Username = ? And Password = ?  ");
	
		$stmt->execute(array($user, $hashedPass));
	
		$get = $stmt->fetch();

		$count = $stmt->rowCount();

	if ($count > 0) {

		//check if what we enter in form like what it saved in DB 
		// IT's Login Form

		$_SESSION['user'] = $user;

		$_SESSION['uid'] = $get['UserID'];


		header('Location: index.php');
		exit();
			}

   }else{
   	//Check if there is errors in form and filter it

   	$formErrors = array();

   	if (isset($_POST['username'])) {

   		$filterUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);

   		if (strlen($filterUser) < 4 ) {

   			$formErrors[] =  "Must Larger than 4 ";
   		}

   	}

 	if (isset($_POST['password']) && isset($_POST['password2'])) {

 		if(empty($_POST['password'])){

 			$formErrors[] = "Sorry , Password Cant be Empty";
 		}


 		$pass = $_POST['password'];
		$pass2 = $_POST['password2'];

			if ($pass !== $pass2) {

   			$formErrors[] =  "Password Doesnt Match ";
			}
   	}

   	if (isset($_POST['email'])) {

   		$filterEmail= filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);

   		if (filter_var($filterEmail , FILTER_VALIDATE_EMAIL) != true) {

   			$formErrors[] = "This Email Not Valid"; 

   		}

					//Check if username is exist in Db or not

			$check = checkItem("Username", "users", $_POST['username']);
				if ($check == 1) {

	   			$formErrors[] = "This User IS Exist"; 
				 
					}else{


			
			//Insert User INFO IN DB

			 $stmt = $con->prepare("INSERT INTO users( Username, Password, Email, RegStatus, Date)
			 	
				VALUES(:zuser, :zpass, :zmail, 0, now()) ");

			$stmt->execute(array(
				'zuser' => $_POST['username'],
				'zpass' => sha1($_POST['password']),
				'zmail' => $_POST['email']

			));


		$successMsg = "Congratulation , You Are User Now";
  
	}

		

			}else{

				echo "<div class='container'>	";	
				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , You Cant Browse  THis Page Directly</div>";

				echo "</div>";

			}


			echo "</div>";



}
}	




?>


 <div class="container 	login-page">
 	<h1 class="text-center"><span class="selected" data-class="login">Login</span> / <span data-class="signup">SignUp</span></h1>

 	<!-- Login Form -->

 	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

 		<input class="form-control" type="text" name="username" autocomplete="off" placeholder="User Name">
 		<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="password">

 		<input class="btn btn-primary" name="login" type="submit" value="login" >

 	</form>

 </div>


						<!-- Sign up Form -->

<div class="container login-page">
 
 	<form class="signup action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
 		<input class="form-control" type="text" name="username" autocomplete="off" placeholder="User Name">
 		<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password">
 		<input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Confirm Password">
 		<input class="form-control" type="text" name="email" autocomplete="off" placeholder="Email">
 				<div class="form-group">
				<label class="col-sm-2 control-label">User Image</label>
				<div class="col-sm-10">
					<input type="file" name="avatar" class="form-control" 
					placeholder="Enter Your name"
					required="required" />
			</div>
			</div>


 		<input class="btn btn-success" name="signup" type="submit" value="Sign Up" >

 	</form>

 	<div class="text-center">

 		<?php 

 		if(!empty($formErrors)){

 			foreach ($formErrors as $error ) {  // Dislay Errors

 			echo $error . '<br>';

 			}
 		}

 		if (isset($successMsg)) {

 			echo '<div class="msg success">' . $successMsg . '</div>';

 		}

 		 ?>

 	</div>





<?php
include $tpl . 'footer.php';
?>