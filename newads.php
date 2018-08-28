<?php

ob_start();

session_start();

$pageTitle = 'Create New Add';

include 'init.php';

if (isset($_SESSION['user'])) {


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// Filter For All in Table


		$formErrors = array ();

		$name 		=filter_var($_POST['name'], FILTER_SANITIZE_STRING);

		$desc 		=filter_var( $_POST['description'], FILTER_SANITIZE_STRING);

		$price 		=filter_var( $_POST['price'], FILTER_SANITIZE_NUMBER_INT);

		$country 	=filter_var( $_POST['country'], FILTER_SANITIZE_STRING);

		$status 	=filter_var( $_POST['status'], FILTER_SANITIZE_NUMBER_INT);

		$cat 		=filter_var( $_POST['category'], FILTER_SANITIZE_NUMBER_INT);

		$tag 		=filter_var( $_POST['tag'], FILTER_SANITIZE_STRING);


		if (strlen($name)< 4) {

			$formErrors [] = "Item Must be 4 Character or more";

		}
		if (strlen($desc)< 4) {

			$formErrors [] = "Item Must be 4 Character or more";

		}if (empty($price)) {

			$formErrors [] = "price Cant be empty";

		}if (strlen($country)< 4) {

			$formErrors [] = "Item Must be 4 Character or more";

		}if (empty($status)) {

			$formErrors [] = "status Cant be Empty";

		}

	if (empty($cat)) {

			$formErrors [] = "Cat Cant be Empty";

		}


		if (empty($formErrors)) {

			//Insert User INFO IN DB

			 $stmt = $con->prepare("INSERT INTO items(Name,  Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, Tag)

				VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus,  now(), :zcat,
				 :zmember, :ztag) ");


			$stmt->execute(array(
				'zname' => $name,
				'zdesc' => $desc,
				'zprice' => $price,
				'zcountry' => $country,
				'zstatus' => $status,	
				'zcat' => $cat,
				'zmember' => $_SESSION['uid'],
				'ztag' => $tag


			));

		$msg = "SUcceded To Add "; 		  
	  }


	}



?>



<div class="My-Ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Advertisments</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						
		<form class="form-horizontal"
		 action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" name="name" class="form-control live-name"   placeholder="Name of Item" pattern=".{4,}" 
					required="required" />
			</div>
			</div>

					
			<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
					<input type="text" name="description" 
					class="form-control"
					  placeholder="Descripe Item" />
			</div>
			</div>


			<div class="form-group">
				<label class="col-sm-2 control-label">Price</label>
				<div class="col-sm-10">
					<input type="text" name="price" class="form-control"
					  placeholder="Price of Item" />
			</div>
			</div>

	
			<div class="form-group">
				<label class="col-sm-2 control-label">Country Made</label>
				<div class="col-sm-10">
					<input type="text" name="country" class="form-control"
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
				<label class="col-sm-2 control-label">Category</label>
				<div class="col-sm-10">

					<select class="form-control" name="category">
						<option value="0">.....</option>


<?php 
// use Function
		$allCats = AllFun("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
			
			foreach ($allCats as $cat) {

			echo "<option value='" .$cat['ID'] . " '>".$cat['Name']."</option>";

						}

?>
					 </select>
			</div>
			</div>


			  <div class="form-group">
				<label class="col-sm-2 control-label">Tags</label>
				<div class="col-sm-10">
					<input type="text" name="tag" class="form-control"
					  placeholder="Seperate Tags  With ( , ) "  />
			</div>
			</div>





				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Add New Item" class="btn btn-primary" />
			</div>
			</div>

		</form>	
			</div>




			<div class="col-md-4">
			<div class="thumbnail live-preview">
			<span class="price_tag">0</span>	
			<img src='img/ed.jpg' alt= ' ' >
 			<h3>Title</h3>
			<p>Description</p>
			
				</div>
			 </div>
			</div>
		   </div>
		   <!-- Start Error Loop -->
<?php
		   	if (! empty($formErrors)) {


		   		foreach ($formErrors as $error ) {

		   			echo '<div class="alert alert-danger">' . $error . '</div>';

		   		}

		   	}

		   	if (isset($msg)) {

				echo "<div class='alert alert-success'>" . $msg . "</div>";
		   	}

		   ?>

					<!-- End Loop -->

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