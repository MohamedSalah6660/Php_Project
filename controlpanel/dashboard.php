 <?php

ob_start();  //OutPut Buffering Start
 
session_start();
$pageTitle = 'Dashboard';

if(isset($_SESSION['Username'])){
include "init.php";

?> 

	<div class="container home-stats text-center">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-3">

<!-- Here , We user countItems Function to Count -->

				<div class="stat stat1">Total Members
					<span><a href="members.php">
						<?php echo countItems('UserID', 'users')  ?>
						</a></span>
				 </div>

			</div>

		<div class="col-md-3">
			<div class="stat stat2">Pednding Members 
				<span><a href="members.php?do=manage&page=Pending">
					<?php echo checkItem("RegStatus", "users", 0)?>

				</a></span>
			</div>
		</div>

		<div class="col-md-3">
			<div class="stat stat3">Total Items
				<span><a href="items.php">
					<?php echo countItems('Item_ID', 'items')  ?>
					</a></span>
			 </div>
		</div>


		<div class="col-md-3">
			<div class="stat stat4">Total Comments
				<span><a href="comments.php">
					<?php echo countItems('c_id', 'comments')  ?>
					</a></span>
			 </div>
		</div>

<?php
	$countusers = 5 ;

?>		
		</div>
	</div>
	<div class="container latest">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
				<div class="panel panel-heading">

					<i class="fa fa-users "> Latest <?php echo $countusers ?> Registerd Users </i>

			</div>
			<div class="panel-body reg">
				<ul class="list-unstyled latest-users">

<?php
				// To Show Latest Number of users or items

					$numUsers = 5;

					$latestUsers = getLatest("*", "users", "UserID", $numUsers);

					$numItems = 5; 
					$latestItems = getLatest("*", "items", "Item_ID", $numItems);
						

			foreach ($latestUsers as $user) {

				 echo '<li>' ;
				 echo  $user ['Username'];

				  echo '<a href = "members.php?do=Edit
				  &userid=' . $user['UserID'] .  '">';

				 echo '<span class="btn btn-success pull-right">';

				 echo 'Edit';

				if ($user['RegStatus'] == 0) {

				echo"<a href='members.php?do=Activate&userid=" . $user['UserID'] . "' class='btn btn-info activate pull-right'>Activate</a>";
			

					}


				 echo '</span>';
				 echo '</a>';
				 echo'</li>';

			}
?>
				</ul>
			</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="panel panel-default">
			<div class="panel panel-heading">

				<i class="fa fa-tag">Latest Items </i>
			</div>
			<div class="panel-body reg">

			<ul class="list-unstyled latest-users">

<?php
		
			$numItems = 5; 
			$latestItems = getLatest("*", "items", "Item_ID", $numItems);
			

			foreach ($latestItems as $item) {

			 echo '<li>' ;
			 echo  $item ['Name'];

			  echo '<a href = "items.php?do=Edit
			  &itemid=' . $item['Item_ID'] .  '">';

			 echo '<span class="btn btn-success pull-right">';

			 echo 'Edit';

		if ($item['Approve'] == 0) {

		echo"<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info activate pull-right'>Approve</a>";
	

			}


		 echo '</span>';
		 echo '</a>';
		 echo'</li>';
				}

?>
				</ul>
			</div>
			</div>
		</div> 	


		<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-default">
			<div class="panel panel-heading">

				<i class="fa fa-users ">Latest Comments </i>
			</div>
			<div class="panel-body reg">
<?php
		
			$numComments = 5; 
			$latestComments = getLatest("*", "comments", "c_id", $numComments);

			if (!empty($latestComments)){
			foreach ($latestComments as $comment ) {
				echo "<tr>";

				echo "<div class='comment-box'>";
				echo "<br>"; // it is mamber name
				echo '<span class="member-c">' ,  $comment['comment'] . '</span>';
				echo "</div>";
	 // it is comment of member

				echo"<a href='comments.php?do=Edit&comid=" . $comment['c_id'] . "' class='btn btn-danger pull-right'>Edit</a>";

				echo"<a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "' class='btn btn-success confirm pull-right'>Delete</a>";


						if ($comment['status'] == 0) {
				// To Show Approve Button If There is Comment no Approve 
							echo"<a href='comments.php?do=Approve&comid="
							 . $comment['c_id'] . "' class='btn btn-info activate pull-right'>Approve</a>";}


						echo "</tr>";
							}


		

	}else{

	echo "NO Comments";
	
	}
	?>
			</div>
			</div>
			</div>
			</div> 	
			</div>
			</div>



<?php

include $tpl . 'footer.php';


}else{


		header('Location: index.php');
		exit();
}

ob_end_flush();
?>