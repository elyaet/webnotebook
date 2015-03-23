<?php
$data = file_get_contents("data-light.json");
header('Content-Type: application/json');
echo $data;
?>