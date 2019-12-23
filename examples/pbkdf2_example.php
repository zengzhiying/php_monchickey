<?php
namespace examples;
require_once "../autoload.php";
use dataprocess\DataCompute;
header("Content-Type:text/html; charset=utf-8");
// require_once '../dataprocess/DataCompute.php';
$dc = new DataCompute();
// echo $dc->pbkdf2Hash('admin_hello');
if($dc->validatePBKDF2Hash("admin_hello", "sha256:1000:+UpancHaEq70QtFIcpm0Oo///isJZlbd:2x1zYMl+Bnm/BGkakZ7erLaOW+WXMx/3")) {
    echo "ok";
} else {
    echo "field";
}

