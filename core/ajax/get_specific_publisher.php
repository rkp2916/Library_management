<?php
include("../modules/reader_class.php");
$reader = new Reader();
$result = array();
if(isset($_GET)){
	$id = $_GET['id'];
	$result = $reader->get_specific_publisher($id);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>