<?php
include("../modules/admin_class.php");
$admin = new Admin();
if(isset($_GET)){
	$book_id = $_GET['book_id'];
	$reader_id = $_GET['reader_id'];
	$result = $admin->book_return($book_id, $reader_id);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>