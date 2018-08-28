<!-- this page not important if we delete it 
but when we build Website we will use this page to shortcut Copy&paste processing-->


<?php
ob_start(); 

session_start();

$pageTitle = '';

if(isset($_SESSION['Username'])){

include "init.php";

	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if ($do == 'manage') { 

	}elseif ($do == 'Add') {

	}elseif ($do == 'Insert') {

	}elseif ($do == 'Edit') {

	}elseif ($do == 'Update') {

	}elseif ($do == 'Delete') {

	}elseif ($do == 'Activate') {



}


include $tpl . "footer.php";

}else{


		header('Location: index.php');
		exit();
}
ob_end_flush();
?>