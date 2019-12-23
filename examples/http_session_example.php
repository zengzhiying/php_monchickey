<?php
namespace examples;
require_once "../autoload.php";
use httpsession\HttpSession;
//假设用户登录成功获得了以下用户数据
$userinfo = array(
    'uid'  => 10000,
    'name' => 'zengzhying',
    'email' => 'yingzhi_zeng@126.com',
    'sex'  => 'man',
    'age'  => '21'
);
header("content-type:text/html; charset=utf-8");
// require_once 'HttpSession.class.php';
$s = new HttpSession();
echo '<br />';
if($s->cookieEncryption($userinfo, "yingailishuli520", "userinfo", 3600)) {
	echo "cookie信息加密成功";
	echo '<br />';
	echo $_COOKIE['userinfo'];
}
echo "<br />";

//当需要使用时进行解密
if($arr = $s->cookieDecrypt('userinfo', "yingailishuli520")) {
	
} else {
	echo "解密失败";
}
echo "解密后的用户信息：<br>";
var_dump($arr);
?>