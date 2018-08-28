<?php 

ob_start();

session_start();

$pageTitle = 'Profile';

include 'init.php';

if (isset($_SESSION['user'])) {

	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ? ");

	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();

?>

	<h1 class="text-center"> My Profile </h1>
	<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				Name <?php echo $info['Username'] ?></br>

				Email <?php echo $info['Email'] ?></br>

				FullName <?php echo $info['FullName'] ?></br>

				Register Date <?php echo $info['Date'] ?></br>
				Favourite Category :
			</div>

			</div>
			
		</div>
	</div>




<div id="my-ads" class=" My-Ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Advertisments</div>
			<div class="panel-body">
				<div class="row">

	<?php
	if (! empty(getItems('Member_ID', $info['UserID']))) {
		# code...
	
		foreach (getItems('Member_ID', $info['UserID'] , 1) as $item) {
			echo "<div class='col-sm-6 col-md-4'>";
				echo '<div class="thumbnail">';

					// Check if Item is Approve or not
			
			if ($item['Approve'] == 0) {

				echo "Not Approved";
			}

			echo "<img src='img/ed.jpg' alt= ' ' >";
				echo "<div class='caption'>";

				echo '<h3><a href= "items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name']	. '</a></h3>';

					echo ' <p>' . $item['Description'] . '</p>';

					echo ' <p style="color:orange">' . $item['Add_Date'] . '</p>';


					echo ' <p style="color:red">$' . $item['Price'] . '</p>';
			


							echo"</div>";
						echo"</div>";
						echo"</div>";
			
					}
				}else{


					echo "Sorry , There is No Ads TO Show";
				}
				?>

					</div>	
				</div>

			</div>
			
		</div>
	</div>


	<div class="my-comments block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">Latest Comments</div>
				<div class="panel-body">
<?php
		$stmt = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");

		$stmt->execute(array($info['UserID']));

		$comments = $stmt->fetchAll();

			if (!empty($comments)) {

				foreach ($comments as $comment ) {
					
					echo '<p>' . $comment['comment'] . '</p>';

				}


			}else{

				echo "NO Comments";
			}

	?>
			</div>

		</div>
		
	</div>
</div>

<?php

}else{


	header('Location: login.php');
	exit();
}




include $tpl . "footer.php";
ob_end_flush();
?>