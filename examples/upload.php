<?php
header("Content-Type:text/html; charset=utf-8");
require_once "../fileprocess/FileUpload.php";
$file_upload = new FileUpload();
//print_r(count($_FILES["upfile"]));
// print_r($_FILES);
// exit();
if($_FILES["upfile"]['name'] != "") {
    echo "上传...";
    echo $file_upload->uploadFile($_FILES["upfile"], "./upload", array("jpg","png"), 1024 * 1024 * 2);
} else {
    echo "请上传文件";
}
?>