<?php
header('Content-Type: application/json');
$filename = 'data.json';

//data.json読み込み
$handle = fopen($filename, "rb");
$maps = fread($handle, filesize($filename));
fclose($handle);
//data.jsonを格納
$maps = json_decode($maps, true);

//受け取ったデータを格納
$_POST['date'] = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
$maps[] = $_POST;
$new_map = json_encode($maps);

//data.jsonに書き込む
if (is_writable($filename)) {
    $handle = fopen($filename, "wb");
    if (!$handle) {
         echo "Cannot open file ($filename)";
         exit;
    }


    $write = fwrite($handle, $new_map);
    if (!$write) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    echo "Success, wrote ($new_map) to file ($filename)";
    fclose($handle);

} else {
    echo "The file $filename is not writable";
}
