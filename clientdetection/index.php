<?php
header('Content-Type:text/html; charset=utf-8');
require_once 'class/ClientDetection.class.php';

print_r($_SERVER['HTTP_USER_AGENT']);
echo '<br />';
print_r($_SERVER['HTTP_ACCEPT']);
//print_r($_SERVER);

echo "<br /><br />";
echo "IP地址：";
print_r($_SERVER['REMOTE_ADDR']);
echo '<br />';
$obj = new ClientDetection();
echo "您的终端类型：";
if($obj->isMobile()){
	echo '手机端';
}else{
	echo '电脑端';
}
echo '<br />您的操作系统：';
if(($result=$obj->os_type())!=''){
    echo $result;
}else{
    echo '暂时无法判断！';
}

echo '<br />您的浏览器版本：';
if(($result=$obj->brower_ver())!=''){
	echo $result;
}else{
	echo '暂时无法判断！';
}
?>