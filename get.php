<?php
header('Content-Type: application/json');
$filename = 'data.json';
$data = file_get_contents($filename);
echo $data;
