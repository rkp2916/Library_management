<?php
include("../modules/reader_class.php");
$reader = new Reader();
$result = array();

$result = $reader->get_reserve_list();

echo json_encode($result, JSON_UNESCAPED_SLASHES);
?>