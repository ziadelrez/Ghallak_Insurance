<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
$File = $_FILES["file"];

if (isset($_REQUEST["unique"]) && $_REQUEST["unique"] != "") {
    $unique = $_REQUEST["unique"];
} else {
    $unique = uniqid();
}

$response = array();
$target = "uploads/form_" . $_REQUEST["form_id"] . "/$unique/";

$allowed_extentions = ["png", "gif", "jpg", "JPG", "jpeg", "JPEG", "bmp", "BMP", "pdf", "PDF", "csv", "CSV",
    "doc", "docx", "xls", "xlsx", "txt", "rtf", "zip", "mp3", "wma", "mpg", 'flv', 'avi', "mp4"];


$file = $File["name"];
$tmpFile = $File["tmp_name"];
$path_info = pathinfo($file);
$file_name = $path_info["filename"];
$extension = $path_info["extension"];
$CheckExtension = in_array($extension, $allowed_extentions);
if ($CheckExtension) {
    if (!file_exists($target)) {
        $res = mkdir($target, 0777, true);
    }
    $counter = 1;
    $target_file = $target . $file_name . "." . $extension;
    while (file_exists($target_file)) {
        $target_file = $target . $file_name . "_$counter." . $extension;
        $counter++;
    }
    if (move_uploaded_file($tmpFile, $target_file)) {
        $response["unique"] = $unique;
        $response["file"] = $target_file;
        return print json_encode($response);
    }
}
echo "File type not allowed";
http_response_code(500);
?>