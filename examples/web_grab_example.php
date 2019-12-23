<?php
namespace examples;
require_once "../autoload.php";
use networkcommunication\WebGrab;


header('Content-Type:text/html; charset=utf-8');
// require_once 'class/Grab.class.php';
$obj = new WebGrab();

//$url = 'http://www.htys.cc/login.php?';
// $url2 = 'http://www.htys.cc/profile.php?action=modify';
// $cookie = dirname(__FILE__).'./cookie.htys.txt';
// $data = array(
//     'forward' => '',
//     'jumpurl' => 'index.php',
//     'step' => '2',
//     'pwuser' => 'zzyhtys',
//     'pwpwd' => 'yal58739haitian',
//     'hideid' => '0',
//     'cktime' => '31536000',
//     'submit' => ''
//     );
// if($obj->login_post($url,$cookie,$data)) {
//     echo '登录成功！';
// } else {
//     echo "登录失败！";
// }
// if($content = $obj->get_content($url2,$cookie)) {
//     echo iconv("gbk", "utf-8", $content);
// }

$url = 'http://dwz.cn/zzy_jianli';
if($result = $obj->sortUrlReduction($url)) {
    echo $result;
} else {
    echo "网址还原失败";
}

?>