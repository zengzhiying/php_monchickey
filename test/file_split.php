<?php
header("Content-Type:text/html; charset=utf-8");
// 设置允许脚本使用的最大内存 根据要分割的单个文件大小设置 至少要大于block的2倍以上
ini_set("memory_limit", "50M");
// 设置脚本通过web执行的最大时间 默认为30s 命令行执行脚本时默认为0 和其他程序一样不限制时间
ini_set("max_execution_time", "100");
$split_file = "jstorm-2.1.1.zip";
require_once '../fileprocess/FileSplitMerge.php';

$fsm = new FileSplitMerge();

// 调用方法分割文件
// if($fsm->splitFile($split_file, 3*1024*1024, "./upload/", "tmp_cache")) {
//     echo "success!";
// } else {
//     echo "field!";
// }

// 调用方法合并文件
if($fsm->mergeFile("./output_jstorm.zip", "./upload", 'tmp_cache')) {
    echo "success!";
} else {
    echo "field!";
}

