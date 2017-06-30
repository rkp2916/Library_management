<?php
include("../modules/admin_class.php");
$admin = new Admin();
if(isset($_GET)){
	$reader_id = $_GET['reader_id'];
	$book_id = $_GET['book_id'];
	$lib_id = $_GET['lib_id'];
	$result = $admin->book_borrow($book_id, $reader_id, $lib_id);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>