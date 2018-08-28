 <?php

include 'init.php';?>


<div class="container">
	<div class="row">

<?php
if (isset($_GET['name'])) {

	$tag = $_GET['name'];
	# code...
	echo "<h1 class='text-center'>" . $tag .  "</h1>";
	$tagItems = AllFun("*", "items" , "where Tag like '%$tag' ", "AND Approve =1 " , "Item_ID");

		foreach ($tagItems as $item) {
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
}else{

	echo "You Didnt spicify Page ID";
}

?>

</div>	
</div>

<?php
include $tpl . "footer.php";
?>