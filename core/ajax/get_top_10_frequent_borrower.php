<?php
include("../modules/admin_class.php");
$admin = new Admin();
$result = array();
if(isset($_GET)){
	$lib_id = $_GET['lib_id'];
	$result = $admin->get_top_10_frequent_borrower($lib_id);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>