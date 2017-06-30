<?php
include("../modules/admin_class.php");
$admin = new Admin();
if(isset($_GET)){
	$reserve_id = $_GET['reserve_id'];
	$result = $admin->book_return($reserve_id);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>