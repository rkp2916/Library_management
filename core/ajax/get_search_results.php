<?php
//isbn, title, category, publisher, thumbnail
//query = isbn, title, category, publisher
include("../modules/admin_class.php");
$admin = new Admin();
if(isset($_POST)){
	echo json_encode($admin->get_branches());
}else{
	die("Invalid request");
}
?>