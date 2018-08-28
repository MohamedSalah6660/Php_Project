<?php

session_start();

$pageTitle = '';

if (isset($_SESSION['Username'])) {

include 'init.php';


	$do='';        // Just variable we will use it alot 

	if (isset($_GET['do'])) {

		$do =$_GET['do'];       // if there is word make do equal it

	}else{ $do ='manage';}	// there isnot make this default


									// Manage Page 
	if ($do == 'manage'){

		$sort = 'ASC';

		$sort_array = array('ASC' , 'DESC');

		if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

			$sort = $_GET['sort'];
		}
		
		$stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

		$stmt2->execute();

		$cats = $stmt2->fetchAll();

?>


	<h1 class="text-center">Manage Categories</h1>
	<div class="container categories">
		<div class="panel panel-default">
			<div class="panel-heading">
				Manage Categories

				<div class="ordering pull-right">
					Ordering :
					<a href="?sort=ASC">ASC</a>
					<a href="?sort=DESC">DESC</a>

				</div>
			</div>
			<div class="panel-body">
				
				<?php
				// Make Edit And Delete Button

				foreach($cats as $cat){
					echo "<div class='cat'>";

					echo "<div class='hidden-buttons'>";

					echo "<a href='category.php?do=Edit&catid="  . $cat['ID']  .  "' class='btn  btn-primary'>Edit</a>";

					echo "<a href='category.php?do=Delete&catid=" . $cat['ID'] . "' class=' btn  btn-danger confirm'>Delete</a>";


					echo "</div>";
					echo "</div>";


					echo "<h2>" . $cat['Name'] . "</h2>";
					echo "<p>";


					echo"<div class='full-view'>";

						if($cat['Description'] == "" ){
						 echo  ' <p class="desc">This is Empty</p>';

						}else{echo "<h4 class='desc'>" . $cat['Description'] . "<h4>";}

						if($cat['Visibility'] == 1)
						   {echo '<span class="visibility">Hidden</span>';}

							 if($cat['Allow_Comment'] == 1)
						   {echo '<span class="commenting">Comment Disabled</span>';}

							 if($cat['Allow_Ads'] == 1)
						   {echo '<span class="advertises">Ads Disabled</span>';}

					echo "</div>";
					echo "</div>";



							// Sub Category


// use AllFun from Function File

		$childCats = AllFun("*", "categories", "WHERE parent = {$cat['ID']}", " ", "ID", "ASC");

			foreach ($childCats as $c) {
				
// To make Edit And Delete  For Sub Category

			echo"<li class=' child-link'>

			<a href='category.php?do=Edit
			&catid=" . $c['ID'] . "'>" .$c['Name'] . "</a>

			<a href='category.php?do=Delete
			&catid=" . $c['ID'] . "' class='  confirm'>Delete</a>

			 </li>";
			}


		echo "<hr>";
 

		} 

?>
			</div>
		</div>
	</div>

			<a class="btn btn-primary addcategory "
			 href="category.php?do=Add">Add New Category</a>





<?php

				// Add Catefory Page


	}elseif ($do == 'Add') {?>


<!-- IT's Form and we use action to send Request -->

		<h1 class="text-center">Add New Category </h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">

					<input type="text" name="name" class="form-control"
					  autocomplete="off" required="required" 
					  placeholder="Name of Category" />
			</div>
			</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10" >

					<input type="text" name="description" class=" form-control"  placeholder="Descripe the Category" />
			</div>
			</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Ordering</label>
				<div class="col-sm-10">

					<input type="text" name="ordering" class="form-control"
					placeholder="Number of Order" />
			</div>
			</div>


				<div class="form-group">

				<label class="col-sm-2 control-label">Parent ???</label>
				<div class="col-sm-10">
					<select name="parent">
						<option value="0">None</option>
	
<?php

// Select Fro DB and Put them in OPTION

		$allCats = AllFun("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
			
			foreach ($allCats as $cat) {

			echo "<option value='" .$cat['ID'] . " '>".$cat['Name']."</option>";

			}
						

?>

					</select>



			</div>
			</div>



				<div class="form-group">
				<label class="col-sm-2 control-label">Visible</label>
				<div class="col-sm-10">


					<!-- IN Visibility & Commenting & ADS We Make Two options -->
					<div>

						<input id="vis-yes" type="radio" name="visibility" value="0" checked /> 
						<label for="vis-yes">Yes</label>

					</div>
					<div>

						<input id="vis-no" type="radio" name="visibility" value="1" /> 
						<label for="vis-no">No</label>

					</div>
					</div>
					</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Allow Commenting</label>
				<div class="col-sm-10">

					<div>

						<input id="com-yes" type="radio" name="commenting" value="0" checked /> 
						<label for="com-yes">Yes</label>

					</div>
					<div>

						<input id="com-no" type="radio" name="commenting" value="1" /> 
						<label for="com-no">No</label>

					</div>
					</div>
					</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Allow Ads</label>
				<div class="col-sm-10">

					<div>

						<input id="ads-yes" type="radio" name="ads" value="0" checked /> 
						<label for="ads-yes">Yes</label>

					</div>
					<div>

						<input id="ads-no" type="radio" name="ads" value="1" /> 
						<label for="ads-no">No</label>

					</div>
					</div>
					</div>



				<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Add Category" class="btn btn-primary" />
			</div>
			</div>

		</form>	
	</div>




<?php
					// Insert Category Page

	}elseif ($do == 'Insert') {

		// Recieve Request

		if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
			echo "<h1 class='text-center'>Add Category</h1>";
			echo "<div class='container'>";

				// GET the Variables From The Form

			$name 		= $_POST['name'];
			$desc  		= $_POST['description'];
			$order 		= $_POST['ordering'];
			$parent 	= $_POST['parent'];
			$visible    = $_POST['visibility'];		
			$comment    = $_POST['commenting'];
			$ads 		= $_POST['ads'];

				//Check if Category is exist in Db or not

			$check = checkItem("Name", "categories", $name);

				if ($check == 1) { echo "<div class='container'>";	

			$theMsg = "<div class='alert alert-danger'> 
			  Sorry , This Category is exist</div>";

			redirectHome($theMsg, 'back',  3);
				 
				}else{

				//Insert User INFO IN DB

			 		$stmt = $con->prepare("INSERT INTO categories
			 		(Name, Description, Ordering, parent , Visibility, Allow_Comment, Allow_Ads)

					VALUES(:zname, :zdesc, :zorder, :zparent , :zvisible, :zcomment, :zads) ");

// zname :  this word (z) like variable , we can use any word else

						$stmt->execute(array(

						'zname'		 => $name,
						'zdesc' 	 => $desc,
						'zorder'	 => $order,
						'zparent'    => $parent,
						'zvisible'	 => $visible,
	      				'zcomment'   => $comment,
						'zads' 		 => $ads
							));

						$theMsg = "<div class='alert alert-success'>" .
						 $stmt->rowCount() .  'Record Inserted</div>';
				  
						redirectHome($theMsg, 'back',  6);} 
					
					// user redirect Function



		}else{

			echo "<div class='container'>	";	
			$theMsg = "<div class='alert alert-danger'> 
			  Sorry , You Cant Browse  THis Page Directly</div>";

			redirectHome($theMsg, 'back',  6);
			echo "</div>";
		}
			echo "</div>";





									// EDit PAge

	}elseif ($do == 'Edit') {

	// Summary IF
		
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval
		($_GET['catid']) : 0;

 

		$stmt = $con->prepare("SELECT * FROM categories WHERE  ID = ? ");

			$stmt->execute(array($catid));

			$cat = $stmt-> fetch();

			$count = $stmt->rowCount();

			if ($count > 0) { ?>

				<h1 class="text-center">Edit New Category </h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="catid" value="<?php echo $catid ?>">

						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control"
								   required="required" 
								  placeholder="Name of Category" value="<?php echo $cat['Name']?>"/>
									</div>
									</div>

							<div class="form-group">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10" >
								<input type="text" name="description" class=" form-control"  placeholder="Descripe the Category" value="<?php echo $cat['Description']?>" />
						</div>
						</div>

							<div class="form-group">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10">
								<input type="text" name="ordering" class="form-control"
								placeholder="Number of Order" value="<?php echo $cat['Ordering']?>" />
						</div>
						</div>


				<div class="form-group">
				<label class="col-sm-2 control-label">Parent ???</label>
				<div class="col-sm-10">
					<select name="parent">
						<option value="0">None</option>
	
						<?php
						// IT'S About Sub Category


		$allCats = AllFun("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
			
			foreach ($allCats as $c) {

			echo "<option value='" .$c['ID'] . " '";

			if ($cat['parent'] == $c['ID']) {
				echo "selected";

			}


			echo ">".$c['Name']."</option>";

						}

						?>

					</select>



			</div>
			</div>




			<div class="form-group">
			<label class="col-sm-2 control-label">Visible</label>
			<div class="col-sm-10">

				<div>
					<input id="vis-yes" type="radio" name="visibility" value="0"
					<?php if ($cat['Visibility'] == 0 ) {
						echo 'checked';} ?> /> 
					<label for="vis-yes">Yes</label>
				</div>
				<div>
					<input id="vis-no" type="radio" name="visibility" value="1" 
				<?php if ($cat['Visibility'] == 1 ) {
						echo 'checked';} ?> 
					/> 
					<label for="vis-no">No</label>
				</div>
				</div>
				</div>



			<div class="form-group">
			<label class="col-sm-2 control-label">Allow Commenting</label>
			<div class="col-sm-10">

				<div>
					<input id="vis-yes" type="radio" name="commenting" value="0"
					<?php if ($cat['Allow_Comment'] == 0 ) {
						echo 'checked';} ?> /> 
					<label for="vis-yes">Yes</label>
				</div>
				<div>
					<input id="vis-no" type="radio" name="commenting" value="1" 
				<?php if ($cat['Allow_Comment'] == 1 ) {
						echo 'checked';} ?> 
					/> 
					<label for="vis-no">No</label>
				</div>
				</div>
				</div>



			<div class="form-group">
			<label class="col-sm-2 control-label">Allow Ads</label>
			<div class="col-sm-10">

				<div>
					<input id="vis-yes" type="radio" name="ads" value="0"
					<?php if ($cat['Allow_Ads'] == 0 ) {
						echo 'checked';} ?> /> 
					<label for="vis-yes">Yes</label>
				</div>
				<div>
					<input id="vis-no" type="radio" name="ads" value="1" 
				<?php if ($cat['Allow_Ads'] == 1 ) {
						echo 'checked';} ?> 
					/> 
					<label for="vis-no">No</label>
				</div>
				</div>

				</div>



			<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" value="Update Category" class="btn btn-primary" />
		</div>
		</div>

	</form>	
</div>


<?php

		}else{
			echo "<div class='container'>";	


			$theMsg ='<div class="alert alert-danger">There is no Such ID</div>';

			redirectHome($theMsg);
			echo "<div class='container'>";	

			echo "</div>";
		}


// Update Page 



	}elseif ($do == 'Update') {

		echo "<h1 class='text-center'>Update Category</h1>";
		echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

// GET the Variables From The Form

				$id = $_POST['catid'];
				$name = $_POST['name'];
				$desc = $_POST['description'];
				$order = $_POST['ordering'];
				$parent = $_POST['parent'];
				$visible = $_POST['visibility'];
				$comment = $_POST['commenting'];
				$ads = $_POST['ads'];


				


				$stmt = $con->prepare("UPDATE categories SET Name = ? , Description = ? , Ordering = ? , parent = ?, Visibility = ?, Allow_Comment = ? , Allow_Ads = ?
				 WHERE ID = ? ");

				$stmt->execute(array($name, $desc, $order, $parent , $visible, $comment, $ads ,$id));

				$theMsg = "<div class='alert alert-success'>" .
				$stmt->rowCount() . 'Record Updated</div>';
				  
				redirectHome($theMsg, 'back',  6);
				


			}else{


				$theMsg = "<div class='alert alert-danger'> 
				  Sorry , You Cant Browse  THis Page Directly</div>";
				redirectHome($theMsg,'back');
			} 
			echo "</div>";

									// Delete PAge


	}elseif($do == 'Delete'){
		echo "<h1 class='text-center'>Delete Category</h1>";
		echo "<div class='container'>";

		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval
		($_GET['catid']) : 0;

	 
		$check = checkItem('ID', 'categories', $catid); 
	/* This Line instead of Select  */





		if ($check > 0) {


			$stmt = $con->prepare("DELETE FROM categories WHERE
			 ID = :zid ");

			$stmt->bindParam(":zid", $catid);

			$stmt->execute();

			$theMsg = "<div class='alert alert-success'>" .
			 $stmt->rowCount() . 'Record Deleted</div>';
	  
			redirectHome($theMsg, 'back',  6);

			}else{

			echo "<div class='container'>";

			$theMsg ='<div class="alert alert-danger">
			There is no ID Like This</div>';
			
			redirectHome($theMsg);
			}				
			echo "</div>";			


}


}else{ 


		header('Location: index.php');
		exit();
}






?>