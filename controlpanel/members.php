<?php

session_start();

$pageTitle = 'Manage Users';


if(isset($_SESSION['Username'])){
include "init.php";

 
		 

	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if ($do == 'manage') { 

		$Query = '';

		// Pending members are users who waiting to Activate 

		if (isset($_GET['page']) && $_GET['page'] == 'Pending'  ) { 

			$Query = 'AND RegStatus = 0';
		}



		$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $Query ");

		$stmt->execute();

		$rows = $stmt->fetchAll();

		?>


		<h1 class="text-center">Manage Member</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered manage-member">
					<tr>
						<td>ID</td>						
						<td>Image-User</td>						
						<td>Username</td>
						<td>Email</td>
						<td>Full Name</td>
						<td>Registred Date</td>
						<td>Control</td>

					</tr>
					
<?php
		foreach ($rows as $row ) {

			echo "<tr>";
				
				echo "<td>" . $row['UserID'] . "</td>";	
				echo "<td>";

				if (empty($row['avatar'])) {

					echo "empty";

				}else{	
					echo "<img class='mem' src='uploads/avatar/" . $row['avatar'] ."' alt = '' >";

			
				}
			echo"</td>";			
				echo "<td>" . $row['Username'] . "</td>";
				echo "<td>" . $row['Email'] . "</td>";
				echo "<td>" . $row['FullName'] . "</td>";
				echo "<td>" . $row['Date'] . "</td>";
				echo "<td>

					<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-danger'>Edit</a>

				<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-success Confirm'>Delete</a>";

			if ($row['RegStatus'] == 0) {

				echo"<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-info activate'>Activate</a>";



			}
			



			echo "</td>"	;
			echo "</tr>";

		}

		?>

				</table>
				
			</div>

	<a href='members.php?do=Add' class="btn btn-primary">Add New Members</a>
		</div>


<?php

								//Add new members


	}elseif ($do == 'Add') {?>


	<h1 class="text-center">Add New Member </h1>
	<div class="container">
		<form class="form-horizontal" action="?do=Insert" method="POST" 
		enctype="multipart/form-data">
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					<input type="text" name="username" class="form-control"
					  autocomplete="off" required="required" 
					  placeholder="Username to login" />
			</div>

			</div>

				<div class="form-group">
				<label class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10" >

					<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" 
					 placeholder="Password Must Be hard" />
			</div>

			</div>

				<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" name="email" class="form-control"
					  required="required" placeholder="Email must be Valid" />
			</div>

			</div>

				<div class="form-group">
				<label class="col-sm-2 control-label">Fullname</label>
				<div class="col-sm-10">
					<input type="text" name="full" class="form-control" 
					placeholder="Enter Your name" />
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">User Image</label>
				<div class="col-sm-10">
					<input type="file" name="avatar" class="form-control" 
					placeholder="Enter Your name"
					required="required" />
			</div>


			</div>

				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Add Member" class="btn btn-primary" />
			</div>
			</div>


		</form>	
	</div>




<?php

	}elseif($do == 'Insert'){

							//insert member page
		


			if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
				echo "<h1 class='text-center'>Insert Member</h1>";
				echo "<div class='container'>";

				//Upload Variables // Belong to Upload Image

				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp = $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];


				//allowed Extension

				$avatarAllowedExtension = array("jpg", "png", "jpeg" , "gif");


				// Get Extention

				$ext = explode('.', $avatarName ); 
				$extn = end($ext);
				$avatarExtension = strtolower($extn);	
					


					// GET the Variables From The Form


				$user  = $_POST['username'];
				$pass  = $_POST['password'];
				$email = $_POST['email'];
				$name  = $_POST['full'];

				$hashPass = sha1($_POST['password']);



						//Password Trick
			/*	$pass = '';

				if (empty($_POST['newpassword'])) {
	
						$pass = $_POST['oldpassword'];

					}else{

						$pass = sha1($_POST['newpassword']);
					}*/


// WE Can Make this Code Shortly like this 
// $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);





                           // Validate Form

	$formErrors = array ();

		if (strlen($user) < 4) {
		$formErrors[] = "UserName Cant be less than 
		<strong> 4 Character</strong></div>";
		}


		if(empty($user)){

		$formErrors[] = "UserName Cant be <strong> Empty</strong></div>";
		}	


			if(empty($name)){

		$formErrors[] = "Full name Cant be <strong> Empty</strong></div>";


		}	

			if(empty($hashPass)){

		$formErrors[] = "Password Cant be <strong>Empty</strong></div>";


		}	
			if(empty($email)){
		$formErrors[] = "Email Cant be <strong> Empty</strong></div>";

		}	

		// Validate Image

		if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {

		$formErrors[] = "This Extensoin is not<strong> Allowed</strong></div>";
		}

		if (empty($avatarName)) {
		$formErrors[] = "Image Cant be<strong> Empty</strong></div>";
		}
		if ($avatarSize > 4000000){

		$formErrors[] = "This Image cant be larger than<strong> 4 MB</strong></div>";
		}

		foreach ($formErrors as $errors ) {

			echo "<div class='alert alert-danger'>" .  $errors . '</div>';

				}		
				//Check in no error proceed to data base

				if (empty($formErrors)) { // if there is no errors


				$avatar = rand(0, 100000) . '_' . $avatarName; // it's to change the name of image to make sure there is no two image with the same name



		// It's About upload Image , src = ' path '	where you save them			

				move_uploaded_file($avatarTmp, "uploads/avatar/" . $avatar);

					//Check if username is exist in Db or not

				$check = checkItem("Username", "users", $user);
					if ($check == 1) {

				echo "<div class='container'>	";	

				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , This User is exist</div>";

				redirectHome($theMsg, 'back', 30);
				 
					}else{


			//Insert User INFO IN DB

			 $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date , avatar)

				VALUES(:zuser, :zpass, :zmail, :zname, 1, now() , :zavatar)");

			$stmt->execute(array(
				'zuser' => $user,
				'zpass' => $hashPass,
				'zmail' => $email,
				'zname' => $name,
				'zavatar' => $avatar


			));


		$theMsg = "<div class='alert alert-success'>" .
		 $stmt->rowCount() . 'Record Inserted</div>';
  
		redirectHome($theMsg, 'back',  30);
	}

		}

			}else{

				echo "<div class='container'>	";	
				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , You Cant Browse  THis Page Directly</div>";

				redirectHome($theMsg, 'back',  6);
				echo "</div>";

			}


			echo "</div>";






								// Edit PAge





	} elseif ($do == 'Edit') {

	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval
	($_GET['userid']) : 0;

 

	$stmt = $con->prepare("SELECT * FROM users WHERE  UserID = ? LIMIT 1");

		$stmt->execute(array($userid));
		$row = $stmt-> fetch();
		$count = $stmt->rowCount();

			if ($count > 0) {

?>

	<h1 class="text-center">Edit Member </h1>
	<div class="container">
		<form class="form-horizontal" action="?do=Update" method="POST">
			<input type="hidden" name="userid" value="<?php echo $userid ?>">
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					<input type="text" name="username" class="form-control"
					 value="<?php echo $row['Username']?>" autocomplete="off"
					required="required"/>
			</div>
			</div>

				<div class="form-group">
				<label class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">

						<input type="hidden" name="oldpassword"
						 value="<?php echo $row['Password']?>"/>

					<input type="password" name="newpassword" class="form-control" autocomplete="new-password"/>
			</div>
			</div>

				<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" name="email" class="form-control"
					 value="<?php echo $row['Email']?>" required="required"/>
			</div>
			</div>

				<div class="form-group">
				<label class="col-sm-2 control-label">Fullname</label>
				<div class="col-sm-10">
					<input type="text" name="full" class="form-control" value="<?php echo $row['FullName']?>" />
			</div>
			</div>

				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" name="Save" class="btn btn-primary" />
			</div>
			</div>


		</form>	
	</div>
	</div>




<?php

		}else{
			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no Such ID</div>';

			redirectHome($theMsg);

			echo "</div>";
		}



						// UpDate PAge

	}elseif ($do == 'Update') {


		echo "<h1 class='text-center'>Update Member</h1>";
		echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

// GET the Variables From The Form

				$id = $_POST['userid'];
				$user = $_POST['username'];
				$email = $_POST['email'];
				$name = $_POST['full'];

				//Password Trick
				$pass = '';

				if (empty($_POST['newpassword'])) {
	
					$pass = $_POST['oldpassword'];

				}else{

					$pass = sha1($_POST['newpassword']);
					}


// WE Can Make this Code Shortly like this 
// $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);





                           // Validate Form

	$formErrors = array ();

		if (strlen($user) < 4) {
		$formErrors[] = "<div class='alert alert-danger'>UserName Cant be less than 
		<strong> 4 Character</strong></div>";
		}


		if(empty($user)){

		$formErrors[] = "<div class='alert alert-danger'>UserName Cant be 
		<strong> Empty</strong></div>";
		}			

			if(empty($name)){

		$formErrors[] = "<div class='alert alert-danger'>Full name Cant be <strong> Empty</strong></div>";


		}			
			if(empty($email)){
		$formErrors[] = "<div class='alert alert-danger'>Email Cant be <strong> Empty</strong></div>";

		}	

		foreach ($formErrors as $errors ) {

			echo $errors ;

				}		
				//Check in no error proceed to data base

		if (empty($formErrors)) {

			$stmt2= $con->prepare("SELECT * FROM users WHERE Username = ?
				AND UserID != ?");

			$stmt2->execute(array($user, $id));

			$count=$stmt2->rowCount();

			if($count == 1){

				echo "Sorry";

			}else{

					//Update Database with this info

				$stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserID = ? ");

				$stmt->execute(array($user, $email, $name, $pass, $id));

				$theMsg = "<div class='alert alert-success'>" .
				$stmt->rowCount() . 'Record Updated</div>';
				  
				redirectHome($theMsg, 'back',  6);

					}

				}


		}else{


			$theMsg = "<div class='alert alert-danger'> 
			  Sorry , You Cant Browse  THis Page Directly</div>";
			redirectHome($theMsg,'back');
		} 

			echo "</div>";




// Delete Member Page


	}elseif($do == 'Delete'){


		echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";


		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval
		($_GET['userid']) : 0;

 
// I can use the function replced the  3 lines under this line 
	//$check = checkItem('userid', 'users', $userid)



	$stmt = $con->prepare("SELECT * FROM users WHERE  UserID = ? LIMIT 1");

				$stmt->execute(array($userid));

				$count = $stmt->rowCount();

					if ($stmt->rowCount() > 0) {


						$stmt = $con->prepare("DELETE FROM users WHERE
						 UserID = :zuser ");

						$stmt->bindParam(':zuser', $userid);

						$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" .
						 $stmt->rowCount() . 'Record Deleted</div>';
				  
						redirectHome($theMsg, 'back',  6);

					}else{

			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no ID Like This</div>';

			redirectHome($theMsg);

			echo "</div>";						}




// Activate Page



	}elseif ($do=='Activate') {



	echo "<h1 class='text-center'>Activate Member</h1>";
		echo "<div class='container'>";


	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval
	($_GET['userid']) : 0;

 
// I can use the function replced the  3 lines under this line 

	//$check = checkItem('userid', 'users', $userid)



	$stmt = $con->prepare("SELECT * FROM users WHERE  UserID = ? LIMIT 1");

		$stmt->execute(array($userid));

		$count = $stmt->rowCount();

			if ($stmt->rowCount() > 0) {


				$stmt = $con->prepare("UPDATE users SET RegStatus = 1
					WHERE UserID = ? ");

				$stmt->bindParam(':zuser', $userid);
				
				$stmt->execute(array($userid));

			$theMsg = "<div class='alert alert-success'>" .
				 $stmt->rowCount() . 'Record Activated</div>';
		  
				redirectHome($theMsg, 'back',  4);

			}else{

			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no ID Like This</div>';

			redirectHome($theMsg);

			echo "</div>";	


	}	
}
include $tpl . "footer.php";



}else{


		header('Location: index.php');
		exit();
}






?>