 <?php

include 'init.php';?>

<?php
	
	$cat_id = isset($_GET['pageid'])? $_GET['pageid'] : true;
	$stmt = $con->prepare("SELECT * FROM categories WHERE ID=$cat_id;");
	$stmt->execute();
	$cat = $stmt->fetch();


?>
<div class="container">
	<h1 class="text-center"><?php echo $cat['Name'] ?></h1>
	<div class="row"> 

<?php
if (isset($_GET['pageid'])) {
	# code...

	foreach (getItems('Cat_ID', $_GET['pageid']) as $item) {
		echo "<div class='col-sm-6 col-md-4'>";

			echo '<div class="thumbnail">';

			echo "<img src='img/ed.jpg' alt= ' ' >";

				echo "<div class='caption'>";

				// Item INFO To Display

				echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name']	. '</a></h3>';

				echo ' <p>' . $item['Description'] . '</p>';

				echo ' <p style="color:orange">' . $item['Add_Date'] . '</p>';

				echo ' <p style="color:red">' . $item['Price'] . '</p>';
			
				echo"</div>";
				echo"</div>";
				echo"</div>";
}
	}else{

	echo "You Didnt spicify Page ID";
	}
?>

</div>	
</div>

<?php
include $tpl . "footer.php";
?>