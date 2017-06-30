<?php
include("../modules/reader_class.php");
$reader = new Reader();
if(isset($_GET)){
	$ISBN = $_GET['ISBN'];
	$result = $reader->reserve_book($ISBN);
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>