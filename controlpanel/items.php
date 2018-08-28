<?php
ob_start(); // It's Used For Alot of things like Solve Problems in header ant more ... you Can search about it on Google .

session_start();

$pageTitle = 'Manage Items';

if(isset($_SESSION['Username'])){

include "init.php";

	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if ($do == 'manage') { 
 


		$stmt = $con->prepare
		("SELECT items.* , categories.Name AS categoryName,  users.Username FROM items

			INNER JOIN categories ON categories.ID = items.Cat_ID

			INNER JOIN users ON users.UserID = items.Member_ID ");

		$stmt->execute();

		$items = $stmt->fetchAll();

		?>


		<h1 class="text-center">Manage Items</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>ID</td>						
						<td>Name</td>
						<td>Description</td>
						<td>Price</td>
						<td>Adding Date</td>
						<td>Category</td>
						<td>UserName</td>
						<td>Control</td>

					</tr>
					
<?php

			foreach ($items as $item ) {

				echo "<tr>";
					echo "<td>" . $item['Item_ID'] . "</td>";

					echo "<td>" . $item['Name'] . "</td>";

					echo "<td>" . $item['Description'] . "</td>";

					echo "<td>" . $item['Price'] . "</td>";

					echo "<td>" . $item['Add_Date'] . "</td>";

					echo "<td>" . $item['categoryName'] . "</td>";

					echo "<td>" . $item['Username'] . "</td>";

					echo "<td>


						<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-danger'>Edit</a>

					<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-success confirm'>Delete</a>";


				if ($item['Approve'] == 0) {

					echo"<a href='items.php?do=Approve&itemid=" . 
					$item['Item_ID'] . "' class='btn btn-info activate'>Approve</a>";
				
					}



					echo "</td>"	;
					echo "</tr>";

					}

?>


				</table>
			</div>

		<a href='items.php?do=Add' class="btn btn-primary">Add New Items</a>


			</div>

<?php


								// Add Page 

	}elseif ($do == 'Add') { ?>


		<h1 class="text-center">Add New Item </h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" name="name" class="form-control"
					   required="required" 
					  placeholder="Name of Item" />
			</div>
			</div>

					
			<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
					<input type="text" name="description" class="form-control"
					  placeholder="Descripe Item" />
			</div>
			</div>


			<div class="form-group">
				<label class="col-sm-2 control-label">Price</label>
				<div class="col-sm-10">
					<input type="text" name="price" class="form-control"
					   required="required" 
					  placeholder="Price of Item" />
			</div>
			</div>

	
			<div class="form-group">
				<label class="col-sm-2 control-label">Country Made</label>
				<div class="col-sm-10">
					<input type="text" name="country" class="form-control"
					   required="required" 
					  placeholder="Country of Item" />
			</div>
			</div>


			<div class="form-group">
				<label class="col-sm-2 control-label">Status</label>
				<div class="col-sm-10">
					<select class="form-control" name="status">

						<option value="0">.....</option>

						<option value="1">New</option>

						<option value="2">like New</option>

						<option value="3">Used</option>

						<option value="4">Old</option>

					 </select>
			</div>
			</div>

					<div class="form-group">
				<label class="col-sm-2 control-label">Member</label>
				<div class="col-sm-10">
					<select class="form-control" name="member">
						<option value="0">.....</option>
						<?php 

						// To Show All users in Option

							$stmt=$con->prepare("SELECT * FROM users ");

							$stmt->execute();

							$users = $stmt->fetchAll();

					foreach ($users as $user) {
						echo "<option value='" . $user['UserID']   ."'>
						" . $user['Username']  . " </option>";							}


?>
				 </select>
			</div>
			</div>


						<div class="form-group">
				<label class="col-sm-2 control-label">Category</label>
				<div class="col-sm-10">
					<select class="form-control" name="category">
						<option value="0">.....</option>
<?php 

	 // To Display Categories and under every one of them (Sub Category)

		$allCats = AllFun("*", "categories", "WHERE parent = 0","", "ID");

		foreach ($allCats as $cat) {
		echo "<option value='" . $cat['ID']   ."'>" . $cat['Name']  . "	</option>";						
		$childCats = AllFun("*", "categories", "WHERE parent = {$cat['ID']}","", "ID");

		foreach ($childCats as $child) {

			echo "<option value='" .$child['ID'] . "'>---" . $child['Name'] . "
			 </option>";

			}
		}
?>
					 </select>
			</div>
			</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Rating</label>
				<div class="col-sm-10">
					<select class="form-control" name="rating">
						<option value="0">.....</option>
						<option value="1">*</option>
						<option value="2">** </option>
						<option value="3">***</option>
						<option value="4">****</option>

					 </select>
			</div>
			</div>

	<div class="form-group">
				<label class="col-sm-2 control-label">Tags</label>
				<div class="col-sm-10">
					<input type="text" name="tag" class="form-control"
					  placeholder="Seperate Tags  With ( , ) " />
			</div>
			</div>


				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Add New Item" class="btn btn-primary" />
			</div>
			</div>

		</form>	
	</div>
<?php


										//Insert Page

	}elseif ($do == 'Insert') {


							//insert Items page
		


		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			echo "<h1 class='text-center'>Insert Item</h1>";
			echo "<div class='container'>";
				// GET the Variables From The Form

			$name  = $_POST['name'];
			$desc  = $_POST['description'];
			$price = $_POST['price'];
			$country  = $_POST['country'];
			$status  = $_POST['status'];
			$member  = $_POST['member'];
			$cat  = $_POST['category'];
			$tag  = $_POST['tag'];






 

// WE Can Make this Code Shortly like this :-

// $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);





                           // Validate Form

	$formErrors = array ();

// To make sure there is no any Error in Form
		if(empty($name)){

		$formErrors[] = "name Cant be <strong> Empty</strong></div>";
		}	


			if(empty($desc)){

		$formErrors[] = "Description Cant be <strong> Empty</strong></div>";


		}	

			if(empty($price)){

		$formErrors[] = "Price Cant be <strong>Empty</strong></div>";


		}	
			if(empty($country)){
		$formErrors[] = "Country Cant be <strong> Empty</strong></div>";

		}	

		if($status == 0 ){
		$formErrors[] = "You must Choose  The <strong> Status</strong></div>";

		}	
		if($member == 0 ){
		$formErrors[] = "You must Choose  The <strong> Member</strong></div>";

		}	
		if($cat == 0 ){
		$formErrors[] = "You must Choose  The <strong> Category</strong></div>";

		}	

		foreach ($formErrors as $errors ) {

			echo "<div class='alert alert-danger'>" .  $errors . '</div>';

				}		
				//Check in no error proceed to data base

				if (empty($formErrors)) {

			//Insert User INFO IN DB

			 $stmt = $con->prepare("INSERT INTO items(Name,  Description, Price, Country_Made, Status, Add_Date, Cat_ID,  Member_ID, Tag)

				VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus,  now(), :zcat,
				 :zmember, :ztag) ");

					$stmt->execute(array(
						'zname' => $name,
						'zdesc' => $desc,
						'zprice' => $price,
						'zcountry' => $country,
						'zstatus' => $status,	
						'zcat' => $cat,
						'zmember' => $member,
						'ztag'    => $tag

			));


		$theMsg = "<div class='alert alert-success'>" .
		 $stmt->rowCount() . 'Record Inserted</div>';
  
		redirectHome($theMsg, 'back',  6);
	}

		

			}else{

				echo "<div class='container'>	";	
				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , You Cant Browse  THis Page Directly</div>";

				redirectHome($theMsg, 6);
				echo "</div>";

			}


			echo "</div>";









								// Edit Page



	}elseif ($do == 'Edit') {



		$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval
		($_GET['itemid']) : 0;

 

		$stmt = $con->prepare("SELECT * FROM items WHERE  Item_ID = ? ");



		$stmt->execute(array($itemid));
		$item = $stmt->fetch();
		$count = $stmt->rowCount();

		if ($count > 0) {?>

		<h1 class="text-center">Edit Item </h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Update" method="POST">
			<input type="hidden" name="itemid" value="<?php echo $itemid ?>">

			<div class="form-group">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" name="name" class="form-control"
					   required="required" 
					  placeholder="Name of Item"  value="<?php echo $item['Name']?>" />
			</div>
			</div>

					
			<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
					<input type="text" name="description" class="form-control"
					  placeholder="Descripe Item" value="<?php echo $item['Description']?>" />
			</div>
			</div>


			<div class="form-group">
				<label class="col-sm-2 control-label">Price</label>
				<div class="col-sm-10">
					<input type="text" name="price" class="form-control"
					   required="required" 
					  placeholder="Price of Item" value="<?php echo $item['Price']?>" />
			</div>
			</div>

	
			<div class="form-group">
				<label class="col-sm-2 control-label">Country Made</label>
				<div class="col-sm-10">
					<input type="text" name="country" class="form-control"
					   required="required" 
					  placeholder="Country of Item" 
					  value="<?php echo $item['Country_Made']?>" />
			</div>
			</div>



			<div class="form-group">
				<label class="col-sm-2 control-label">Status</label>
				<div class="col-sm-10">
					<select class="form-control" name="status">
						<option value="1"
						<?php  if ($item['Status'] == 1 )
							{echo 'selected';}
							?>
							>New</option>

						<option value="2"<?php  if ($item['Status'] == 2 ){
							echo 'selected';}
							?>
							>like New</option>

						<option value="3"<?php  if ($item['Status'] == 3 ){
							echo 'selected';}
							?>
							>Used</option>

						<option value="4"<?php if ($item['Status'] == 4 ){
							echo 'selected';}
							?>
							>Old</option>

					 </select>
			</div>
			</div>


			<div class="form-group">
		<label class="col-sm-2 control-label">Member</label>
		<div class="col-sm-10">
			<select class="form-control" name="member">

<?php 
					$stmt=$con->prepare("SELECT * FROM users ");

					$stmt->execute();

					$users = $stmt->fetchAll();

					foreach ($users as $user) {
						echo "<option value='" . $user['UserID']   ."'";
					if ($item['Member_ID'] == $user['UserID']  ){echo 'selected';} echo ">" . $user['Username']  . " </option>";	}	
?>
					 </select>
			</div>
			</div>



						<div class="form-group">
				<label class="col-sm-2 control-label">Category</label>
				<div class="col-sm-10">
					<select class="form-control" name="category">
						<?php 
							$stmt2=$con->prepare("SELECT * FROM categories ");

							$stmt2->execute();

							$cats = $stmt2->fetchAll();

							foreach ($cats as $cat) {

								echo "<option value='" . $cat['ID']   ."'";

			if ($item['Cat_ID'] == $cat['ID']  ){echo 'selected';} echo ">

			" . $cat['Name']  . " </option>";}


						?>
					 </select>
			</div>
			</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Rating</label>
				<div class="col-sm-10">
					<select class="form-control" name="rating">
						<option value="1">*</option>
						<option value="2">** </option>
						<option value="3">***</option>
						<option value="4">****</option>

					 </select>
			</div>
			</div>


	<div class="form-group">
				<label class="col-sm-2 control-label">Tags</label>
				<div class="col-sm-10">
					<input type="text" name="tag" class="form-control"
					  placeholder="Seperate Tags  With ( , ) "
					  value="<?php echo $item['Tag']?>" />
			</div>
			</div>


				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Save Item" class="btn btn-primary" />
			</div>
			</div>

		</form>	




<?php
		$stmt = $con->prepare
		("SELECT comments.*,  users.Username AS members FROM comments
			INNER JOIN users on users.UserID = comments.user_id 
			WHERE item_id = ? ");

			$stmt->execute(array($itemid));

			$rows = $stmt->fetchAll();


			if (!empty($rows)){

?>

		<h1 class="text-center">Manage  [  <?php echo $item['Name']?>  ] Comments</h1>
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>Comment</td>
						<td>User Name</td>
						<td>Added Date</td>
						<td>Control</td>

					</tr>
					
<?php

			foreach ($rows as $row ) {

				echo "<tr>";
					echo "<td>" . $row['comment'] . "</td>";
					echo "<td>" . $row['members'] . "</td>";
					echo "<td>" . $row['comment_date'] . "</td>";
					echo "<td>
							
						<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-danger'>Edit</a>

						<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-success confirm'>Delete</a>";

						if ($row['status'] == 0) {

							echo"<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info activate'>Approve</a>";

						}
						

						echo "</td>"	;
						echo "</tr>";
					}

					?>

				</table>
				



<?php }?>


	</div>
<?php


		}else{
			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no Such ID</div>';

			redirectHome($theMsg);

			echo "</div>";
		}








					// UPDATE PAGE

	}elseif ($do == 'Update') {

		echo "<h1 class='text-center'>Update Items</h1>";
		echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

// GET the Variables From The Form

				$id = $_POST['itemid'];
				$name = $_POST['name'];
				$desc = $_POST['description'];
				$price = $_POST['price'];
				$country = $_POST['country'];
				$status = $_POST['status'];
				$cat = $_POST['category'];
				$member = $_POST['member'];
				$tag = $_POST['tag'];

				

// WE Can Make this Code Shortly like this 
// $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);





                           // Validate Form

	$formErrors = array ();

		
		if(empty($name)){

		$formErrors[] = "name Cant be <strong> Empty</strong></div>";
		}	


			if(empty($desc)){

		$formErrors[] = "Description Cant be <strong> Empty</strong></div>";


		}	

			if(empty($price)){

		$formErrors[] = "Price Cant be <strong>Empty</strong></div>";


		}	
			if(empty($country)){
		$formErrors[] = "Country Cant be <strong> Empty</strong></div>";

		}	

		if($status == 0 ){
		$formErrors[] = "You must Choose  The <strong> Status</strong></div>";

		}	
		if($member == 0 ){
		$formErrors[] = "You must Choose  The <strong> Member</strong></div>";

		}	
		if($cat == 0 ){
		$formErrors[] = "You must Choose  The <strong> Category</strong></div>";

		}	


		foreach ($formErrors as $errors ) {

			echo $errors ;

				}		
				//Check in no error proceed to data base

				if (empty($formErrors)) {
					//Update Database with this info

				$stmt = $con->prepare("UPDATE items SET Name = ? , Description = ? ,
				 Price = ? , Country_Made = ? , Status = ? , Cat_ID = ? , Member_ID = ? , Tag = ? WHERE Item_ID = ? ");

				$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tag, $id ));

				$theMsg = "<div class='alert alert-success'>" .
				$stmt->rowCount() . 'Record Updated</div>';
				  
				redirectHome($theMsg, 'back',  6);

			


				}


			}else{


				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , You Cant Browse  THis Page Directly</div>";
				redirectHome($theMsg,'back');
			} 
			echo "</div>";








	}elseif ($do == 'Delete') {

echo "<h1 class='text-center'>Delete Item</h1>";
		echo "<div class='container'>";


	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval
	($_GET['itemid']) : 0;

 
// I can use the function replced the  3 lines under this line 
	//$check = checkItem('userid', 'users', $userid)



	$stmt = $con->prepare("SELECT * FROM items WHERE  Item_ID = ? LIMIT 1");

				$stmt->execute(array($itemid));

				$count = $stmt->rowCount();

					if ($stmt->rowCount() > 0) {


						$stmt = $con->prepare("DELETE FROM items WHERE
						 Item_ID = :zid ");

						$stmt->bindParam(':zid', $itemid);

						$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" .
						 $stmt->rowCount() . 'Record Deleted</div>';
				  
						redirectHome($theMsg, 'back',  6);

						}else{

			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no ID Like This</div>';

			redirectHome($theMsg);

			echo "</div>";						}






	}elseif ($do == 'Approve') {

echo "<h1 class='text-center'>Approve Item</h1>";
		echo "<div class='container'>";


	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval
	($_GET['itemid']) : 0;

 
// I can use the function replced the  3 lines under this line 

	//$check = checkItem('userid', 'users', $userid)



	$stmt = $con->prepare("SELECT * FROM items WHERE  Item_ID = ?");

				$stmt->execute(array($itemid));

				$count = $stmt->rowCount();

					if ($stmt->rowCount() > 0) {


						$stmt = $con->prepare("UPDATE items SET Approve = 1
							WHERE Item_ID = ? ");
						
						$stmt->execute(array($itemid));

					$theMsg = "<div class='alert alert-success'>" .
						 $stmt->rowCount() . 'Record Approved</div>';
				  
						redirectHome($theMsg, 'back');

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
ob_end_flush();
?>