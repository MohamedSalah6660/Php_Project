<?php

session_start();
$pageTitle = 'Manage Comments';

if(isset($_SESSION['Username'])){

include "init.php";

	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if ($do == 'manage') { 


// Complex SELECT 

		$stmt = $con->prepare
		("SELECT comments.*, items.Name AS Item_Name, users.Username AS members FROM comments
		INNER JOIN items on items.Item_ID = comments.item_id
		INNER JOIN users on users.UserID = comments.user_id ");

		$stmt->execute();

		$rows = $stmt->fetchAll();

		?>


		<h1 class="text-center">Manage Comments</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>ID</td>						
						<td>Comment</td>
						<td>Item</td>
						<td>User Name</td>
						<td>Added Date</td>
						<td>Control</td>

					</tr>
					
<?php

		foreach ($rows as $row ) {

			echo "<tr>";
				echo "<td>" . $row['c_id'] . "</td>";				
				echo "<td>" . $row['comment'] . "</td>";
				echo "<td>" . $row['Item_Name'] . "</td>";
				echo "<td>" . $row['members'] . "</td>";
				echo "<td>" . $row['comment_date'] . "</td>";
				echo "<td>

					<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-danger'>Edit</a>

				<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-success confirm'>Delete</a>";

			if ($row['status'] == 0) {

				echo"<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info activate'>Approve</a>";
// These All Just Buutons 
			

}

			echo "</td>"	;
			echo "</tr>";

		}

		?>


	</table>
	
</div>


 


<?php

								// Edit PAge





	} elseif ($do == 'Edit') {





	$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval
	($_GET['comid']) : 0;

 

	$stmt = $con->prepare("SELECT * FROM comments WHERE  c_id = ? ");

				$stmt->execute(array($comid));
				$row = $stmt-> fetch();
				$count = $stmt->rowCount();

					if ($count > 0) {

?>

	<h1 class="text-center">Edit Comment </h1>
	<div class="container">
		<form class="form-horizontal" action="?do=Update" method="POST">
			<input type="hidden" name="comid" value="<?php echo $comid ?>">
			
			<div class="form-group">
					<label class="col-sm-2 control-label">Comment</label>
				<div class="col-sm-10">

				<textarea class="form-control" name="comment">
						<?php  echo $row['comment'] ?></textarea> 
			</div>
			</div>

			

				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" name="Save" class="btn btn-primary" />
			</div>
			</div>


		</form>
	</div>





<?php

				}else{
					echo "<div class='container'>";	


					$theMsg ='<div class="alert alert-danger">
					There is no Such ID</div>';

					redirectHome($theMsg , 'back');

					echo "</div>";
				}



						// UpDate PAge

	}elseif ($do == 'Update') {


		echo "<h1 class='text-center'>Update Comment</h1>";
		echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

// GET the Variables From The Form

				$comid = $_POST['comid'];
				$comment = $_POST['comment'];
			
	
					//Update Database with this info

				$stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ? ");

				$stmt->execute(array($comment, $comid));

				$theMsg = "<div class='alert alert-success'>" .
				$stmt->rowCount() . 'Record Updated</div>';
				  
				redirectHome($theMsg, 'back',  6);

			


				


			}else{


				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , You Cant Browse  THis Page Directly</div>";

				redirectHome($theMsg,'back');
				} 
				echo "</div>";




// Delete Member Page

	}elseif($do == 'Delete'){


		echo "<h1 class='text-center'>Delete Comment</h1>";
		echo "<div class='container'>";


		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval
		($_GET['comid']) : 0;

 
// I can use the function replced the  3 lines under this line

	//$check = checkItem('c_id', 'comments', $comid)



		$stmt = $con->prepare("SELECT * FROM comments WHERE  c_id = ? ");

			$stmt->execute(array($comid));

			$count = $stmt->rowCount();

				if ($stmt->rowCount() > 0) {


					$stmt = $con->prepare("DELETE FROM comments WHERE
					 c_id = :zid ");

					$stmt->bindParam(':zid', $comid);
					$stmt->execute();

				$theMsg = "<div class='alert alert-success'>" .
					 $stmt->rowCount() . 'Record Deleted</div>';
			  
					redirectHome($theMsg, 'back',  6);

					}else{

			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no ID Like This</div>';

			redirectHome($theMsg, 'back');

			echo "</div>";						}




// Approve  Page

// To agree the Comment

	}elseif ($do=='Approve') {

	echo "<h1 class='text-center'>Approve Member</h1>";
		echo "<div class='container'>";


	$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval
	($_GET['comid']) : 0;

 
// I can use the function replced the  3 lines under this line 

	//$check = checkItem('userid', 'users', $userid)



	$stmt = $con->prepare("SELECT * FROM comments WHERE  c_id = ?");

				$stmt->execute(array($comid));

				$count = $stmt->rowCount();

					if ($stmt->rowCount() > 0) {


						$stmt = $con->prepare("UPDATE comments SET status = 1
							WHERE c_id = ? ");

						$stmt->bindParam(':zid', $comid);

						$stmt->execute(array($comid));

					$theMsg = "<div class='alert alert-success'>" .
						 $stmt->rowCount() . 'Comment Approved</div>';
				  
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