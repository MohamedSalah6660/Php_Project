


<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="dashboard.php">Mohamed Site</a>
 
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav">

        <li class="active" ><a href="dashboard.php">DashBoard </a></li>

        <li class="active"><a href="members.php?do=manage">Members </a></li>
        
        <li class="active"><a href="category.php?do=manage">Categories</a></li>
        
        <li class="active"><a href="items.php?do=manage">Items</a></li> 
        
        <li class="active"><a href="comments.php?do=manage">Comments</a></li>    

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
          aria-expanded="false">Mohamed <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">

            <li><a href="../index.php">Visit Shop</a>
            </li>

            <li><a href="members.php?do=manage&&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a>
            </li>

            <li><a href="#">Settings</a>
            </li>

            <li><a href="logout.php">Log out</a>
            </li>
            
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php

include $tpl . "footer.php";


?>