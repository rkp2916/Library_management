<?php
include("../modules/admin_class.php");
$admin = new Admin();
$result = array();
if(isset($_GET)){
	$reader_id = $_GET['reader_id'];
	$result = $admin->avg_fine_paid($reader_id);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>