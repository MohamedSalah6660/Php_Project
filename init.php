<?php 
// Like Control Panel


include "controlpanel/connect.php";

 

$sessionUser = '';

if (isset($_SESSION['user'])) {
$sessionUser= $_SESSION['user'];
}
//Routes

$tpl = 'includes/temps/';
$lang = 'includes/langs/';
$func = 'includes/functions/';



include $func . "functions.php";

include $lang . 'eng.php';
include $tpl . "header.php";
include $tpl . 'footer.php';



if (!isset($no_navbar)) {
include $tpl .  'navbar.php';}



 ?>