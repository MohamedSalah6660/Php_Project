<!-- We make this page only to make shortcuts to Pages -->

<?php 

include "connect.php";

//Routes

$tpl = 'includes/temps/';
$lang = 'includes/langs/';
$func = 'includes/functions/';



include $func . "functions.php";

include $lang . 'eng.php';
include $tpl . "header.php";
include $tpl . "footer.php";


if (!isset($no_navbar)) {	
include $tpl .  'navbar.php';}

 // It's IF Condition to Put navbar in page or not 




 ?>