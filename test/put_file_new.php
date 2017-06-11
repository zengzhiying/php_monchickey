<?php
header("Content-Type:text/html; charset=utf-8");
$url = 'http://127.0.0.1/test/upload.php';
$path = dirname(__FILE__);
$data = array('upfile' => new \CURLFile(realpath("image.jpg")));

$ch = curl_init();
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
curl_setopt($ch, CURLOPT_USERAGENT,"windows");
$info= curl_exec($ch);
curl_close($ch);
echo $info;
?>