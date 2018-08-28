 <?php

ob_start();

session_start();

$pageTitle = 'Show Items';

include 'init.php';


$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval
	($_GET['itemid']) : 0;

	// Complex Select

	$stmt = $con->prepare("SELECT items.* , categories.Name AS category_name, 
		users.Username FROM items INNER JOIN categories 

		ON categories.ID = items.Cat_ID

		INNER JOIN users ON users.UserID = items.Member_ID
		 WHERE  Item_ID = ?  AND Approve = 1");

			$stmt->execute(array($itemid));

			$count = $stmt->rowCount();

			if ($count > 0 ) {

			$item = $stmt->fetch();


?>

<h1 class="text-center"> <?php echo $item['Name'] ?> </h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">

		<img class="img-responsive" src='img/ed.jpg' alt= ' ' />;

		</div>	
		<div class="col-md-9">
			
			<h2><?php echo $item['Name'] ?></h2>

			<p><?php echo $item['Description'] ?></p>

			<p><?php echo $item['Add_Date'] ?></p>

			<p><?php echo "$" . $item['Price'] ?></p>

			<p> Made in : <?php echo $item['Country_Made'] ?></p>

			<p><span> Category </span> :
			 <a href="category.php?pageid=<?php echo $item['Cat_ID'] ?>">
			  <?php echo $item['category_name'] ?></a></p>

			<p>
			<span> Added By</span> : <a href="#"> <?php echo $item['Username'] ?>
			</a>
			</p>

			<p><span> Tags</span> :
<?php

				$allTags = explode(",", $item['Tag']);

				foreach ($allTags as $tag ) {
					$tag = str_replace (' ' , '',$tag);

					$tag = strtolower($tag);

					if (! empty($tag)) {
						# code...
					
					echo "<a href='tags.php?name={$tag}'>" . $tag . ' </a>  - ';
					}
				}

?>

			</p>


		</div>
	</div>

	<hr>

<?php

	 if (isset($_SESSION['user'])) { 
?>

	<div class="row">
	<div class="col-md-offset-3">
		<h3></h3>

		<form action="<?php echo $_SERVER ['PHP_SELF']  . 
		'?itemid=' .$item['Item_ID']  ?>" method = 'POST'>

		<textarea name="comment" required="required" cols="50" rows="10">
			
		</textarea>

		<input type="submit" value="Add Comment" >
		</form>




		<?php


		// MAKE comment from form above

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			
			$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING); 

			$itemid  = $item['Item_ID'];

			$userid  = $_SESSION['uid'];

			if (! empty($comment)) {
				# code...
			

			$stmt = $con->prepare("INSERT INTO comments 
			(comment, status, comment_date, item_id, user_id) 

			VALUES (:zcomment, 0 , NOW(), :zitemid , :zuserid)");

			$stmt->execute(array(

				'zcomment' => $comment,
				'zitemid' => $itemid,
				'zuserid' => $userid


			));

				if ($stmt) {

					echo '<div class="alert alert-success">Comment Added </div>';

				}


		}
}
		?>



		</div>
	</div>

<?php

 }else{

	echo "<a href='login.php'> Login </a>Before";
	} 

?>

	<hr>

<?php
				$stmt = $con->prepare
				("SELECT comments.*,  users.Username AS members FROM comments

				INNER JOIN users ON users.UserID = comments.user_id
				
				WHERE item_id = ? AND status = 1  ORDER BY c_id DESC ");
 
				$stmt->execute(array($item['Item_ID']));

				$comments = $stmt->fetchAll();	


?>
		<div class='row'>";
		
			<div class='col-md-3'>Name</div>
			<div class='col-md-3'>Comment</div>
			<div class='col-md-3'> Date</div>
			<div class='col-md-2'>User ID</div>
			<hr>

		
<?php


	foreach ($comments as $comment) {

		// Show Comments
		echo "	<div class='row'>";

		echo "<div class='col-md-3'>"  . $comment['members']  . "</div>" ;
		echo "<div class='col-md-3'>"  . $comment['comment']  . "</div>" ;
		echo "<div class='col-md-3'>"  . $comment['comment_date']  . "</div>" ;
		echo "<div class='col-md-3'>"  . $comment['user_id']  . "</div>" ;
		
			}
?>


</div>

<?php

	}else{

	echo "There is no ID like This Or Your  Item Doesnt Aprrove Until now";
	}


include $tpl . "footer.php";
ob_end_flush();
?>