<?php

session_start();

$no_navbar = '';

$pageTitle = 'Login';

include "init.php";

if(isset($_SESSION['Username'])){
	
	header('Location: dashboard.php'); 

}else{



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$username = $_POST['user'];
	$password = $_POST['pass'];
	$hashedPass = sha1($password);
	 



		$stmt = $con->prepare("SELECT UserID, Username, Password from users WHERE Username = ? And Password = ?  And GroupID = 1 LIMIT 1");

		$stmt->execute(array($username, $hashedPass));

		$row = $stmt-> fetch();

		$count = $stmt->rowCount();

		if ($count > 0) {

			$_SESSION['Username'] = $username;
			
			$_SESSION['ID'] = $row['UserID'];

			header('Location: dashboard.php');
			exit();



	}

}}


?>

<h2 class="logadmin">Admin Login</h2>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

	<input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off">
	<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
	<input class="btn btn-primary btn-block" type="submit" value="login">
	



</form>


<?php

include $tpl . "footer.php";

?>







