 <?php
ob_start();
session_start();
$pageTitle = 'Home Page';

include 'init.php';

 if(!isset($_SESSION['user'])){
	
	header('Location: login.php'); 

}else{

?>
	<div class="container">
		<div class="row">

<?php
		// Show All Items in Home Page which Approved

	$allItems = getAllFrom('items', 'Item_ID', 'where Approve = 1');
	foreach ( $allItems as $item) {

		echo "<div class='col-sm-6 col-md-4'>";

			echo '<div class="thumbnail">';

			echo "<img src='img/ed.jpg' alt= ' ' >";

				echo "<div class='caption'>";

					echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name']	. '</a></h3>';

					echo ' <p>' . $item['Description'] . '</p>';
					
					echo ' <p style="color:orange">' . $item['Add_Date'] . '</p>';

					echo ' <p style="color:red">' . $item['Price'] . '</p>';
				
				echo"</div>";
			echo"</div>";
			echo"</div>";
	}
?>

</div>	
</div>
<?php } ?>


<?php


ob_end_flush();
?>