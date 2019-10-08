<?php
header("Content-Type:text/html; charset=utf-8");
require_once './ChinesePinyin.php';
$cp = new ChinesePinyin();
print_r($cp->chineseToPinyin("曾智颖 李淑丽"));
