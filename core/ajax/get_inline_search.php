<?php
//isbn, title, category, publisher, thumbnail
//query = isbn, title, category, publisher
// data:image/jpeg;base64,
include("../modules/reader_class.php");
$reader = new Reader();
$result = array();
if(isset($_GET)){
	$q = $_GET['q'];
	if(is_numeric($q)){
		//search by ISBN
		$result['ISBN'] = $reader->get_search_by_ISBN($q);
	}
	else{
		$result['title'] = $reader->get_search_by_title($q);
		$result['category'] = $reader->get_search_by_category($q);
		$result['publisher'] = $reader->get_search_by_publisher($q);
	}
	echo json_encode($result, JSON_UNESCAPED_SLASHES);
}else{
	die("Invalid request");
}
?>