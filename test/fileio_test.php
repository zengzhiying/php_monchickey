<?php
header("Content-Type:text/html; charset=utf-8");
require_once '../fileprocess/FileIO.php';
require_once "../networkcommunication/WebGrab.php";
$fi = new FileIO();
$wb = new WebGrab();
// echo $fi->deleteFile("D:\\KuGou\\test2");
echo $wb->saveImageUri("http://files.jb51.net/image/ali_1000_2.jpg", "test.jpg");

