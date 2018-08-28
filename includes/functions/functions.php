<?php


function AllFun($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC"){

	global $con;

	$allFun = $con->prepare("SELECT $field FROM $table $where $and ORDER BY

		$orderfield $ordering");

	$allFun->execute();

	$allfun = $allFun->fetchAll();

	return $allfun;

}





// Get All Recoreds from any Table

function getAllFrom($tableName , $orderBy , $where = NULL){

	global $con;

	$getAll = $con->prepare("SELECT * FROM $tableName  ORDER BY $orderBy DESC");

	$getAll->execute();

	$all = $getAll->fetchAll();

	return $all;

}






// Get Categories Function

function getCat(){

	global $con;

	$getCat = $con->prepare("SELECT * FROM categories WHERE parent = 0  ORDER BY ID ASC ");

	$getCat->execute();

	$cats = $getCat->fetchAll();

	return $cats;

}








// Get Latest AD Items  Function

function getItems($where , $value, $approve = Null ){

	global $con;

	if ($approve == Null) {

		$sql = 'AND approve = 1';

	}else{

		$sql = Null;
	}

	$getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql
	  ORDER BY Item_ID DESC ");

	$getItems->execute(array($value));

	$items = $getItems->fetchAll();

	return $items;

}



//Check if user is Not activated ? & RegStatus


function checkUserStatus($user){

	global $con ;

$stmtx = $con->prepare("SELECT Username, RegStatus from users WHERE Username = ? And RegStatus = 0  ");

	$stmtx->execute(array($user));

	$status = $stmtx->rowCount();

	return $status;
}
















////////////////////////////////////////////////////////////////////////////////////////// Next Functions Belongs To Control Panel 

function title() {

	global $pageTitle;

	if (isset($pageTitle)) {

		echo $pageTitle;

	} else {
		echo 'Default';

	}

}

                    // Redirect Function 

function redirectHome($theMsg,  $url = null,$seconds = 5) {


if ($url === null) {

	$url = 'index.php';
	$link = 'HomePage';

}else{ // It's About make Back to Redirect

	if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='') {

	$url = $_SERVER['HTTP_REFERER'];
	$link ='Previous Page';

// Can Make summary IF 

	}else{

			$url = 'index.php';

			$link = 'HomePage';
	}

}

//"<div class='alert alert-danger'></div>"
	echo $theMsg;
	echo "<div class='alert alert-info'>You Will Redirected to  $link  After $seconds  Seconds</div>";

	header("refresh:$seconds;url=$url");

	exit();

}








/*Check item Functions */


function checkItem($select, $from, $value) {


	global $con;

	$stmt3 = $con->prepare("SELECT $select FROM $from WHERE $select = ?");


	$stmt3->execute(array($value));

	$count = $stmt3->rowCount();

	return $count;

}



/* Count Number of Items Rows */

function countItems($item, $table){
 // $item = UserID / table = users ... they are changing so we put it as a variable 

	global $con; //Never Forget This

	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
	$stmt2->execute();

	return $stmt2->fetchColumn();


}


// Get Latest Records / Items / ... etc Function

function getLatest($select, $table, $order, $limit = 5){

	global $con;

	$stmt4 = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT
	$limit ");

	$stmt4->execute();

	$rows = $stmt4->fetchAll();

	return $rows;

}





?>