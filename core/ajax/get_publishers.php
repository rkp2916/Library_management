<?php
include("../modules/reader_class.php");
$reader = new Reader();
$result = array();

$result = $reader->get_publishers();

echo json_encode($result, JSON_UNESCAPED_SLASHES);
?>