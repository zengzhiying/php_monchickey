<?php
header("Content-Type:text/html; charset=utf-8");
$url = 'http://127.0.0.1/test/upload.php';
require_once "../fileprocess/FileUpload.php";
$upload = new FileUpload();
echo $upload -> postFile($url, 'upfile', 'image.jpg');
?>