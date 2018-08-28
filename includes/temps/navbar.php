<nav class="navbar navbar-inverse">


  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
 



    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style=" font-size: 15px">
              <ul class="nav navbar-nav navbar-left">

		    <?php

		$categories = getCat();
// To Display All Categories in Navbar
		foreach ($categories as $cat ) {
		echo 
		'<li>
		<a href="category.php?pageid=' . $cat['ID'] . ' ">
		'. $cat['Name'] . '
		</a>
		</li>';
		}

		?>
</ul>

  <div class="pull-right" >
  	<a href="index.php" style="color: white; font-size: 20px; position: absolute;top: 10px">Home</a>

  </div>
</div>








  </div>
</nav>
		    
	<?php



	if(isset($_SESSION['user'])){?>

	<div class="btn-group" style="margin-left: 550px" >
		<img class="img-circle pull-right" src="img/ed.jpg" width="8%" />
		<span style="font-size: 20px; color: black; padding: 5px" class="btn dropdown-toggle pull-right" data-toggle='dropdown'>
			<?php echo $_SESSION['user'] ?>  <!-- to display the name of user  -->

			<span class="caret"></span>
		</span>

			<ul class="dropdown-menu pull-right">

				<li><a href="profile.php">My Profile</a></li>
				<li><a href="newads.php">Create Ad</a></li>
				<li><a href="profile.php#my-ads">My Items</a></li>
				<li><a href="logout.php">Log OUt</a></li>

			</ul>
	</div>




		<?php



	}else{

	?>
		<a href="index.php">
			<span class="pull-right log">Go Home</span>

</a>
<?php } ?>



