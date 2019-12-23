<?php
header('Content-Type:text/html; charset=utf-8');
require_once "../autoload.php";
use networkcommunication\Snoopy;
// require_once 'Snoopy.class.php';
$snoopy = new Snoopy();


/**
 * 抓取整个网页
 */
/*$url = 'http://www.haosou.com/';
$snoopy->fetch($url);
echo $snoopy->results;*/

/**
 * 抓取网页中的纯文字，去掉标签
 */
// $url = 'http://www.zengzhiying.net/';
// $snoopy->fetchtext($url);
// echo $snoopy->results;

/**
 * 向页面发送post请求
 */
// $url = "http://www.cndns.com/cn/domain/search.aspx";
// $data['domainname'] = 'lishuli';
// $data['domainsuffixs'] = '.net,.com,.net,.org,.cn,.com.cn';
// $data['batch'] = 'false';
// $snoopy->submit($url,$data);
// echo $snoopy->results;


// $url = 'http://192.168.1.107/uoko/index.php?g=uokoadmin&m=login&a=index';
// $snoopy->fetch($url);
// $get_data = $snoopy->results;
// $pattern = '/<input type=\"hidden\" name=\"__hash__\" value=\"(.*?)\" \/>/i';
// if(preg_match_all($pattern, $get_data, $matches)){
// 	$hash = $matches[1][0];
// }else{
// 	echo '匹配失败！';
// }
// $data['admin'] = 'uokoadmin';
// $data['password'] = 'uokoadmin';
// $data['rember_password'] = 'on';
// $data['__hash__'] = $hash;
// $snoopy->submit($url,$data);
// echo $snoopy->results;
$url = 'https://www.baidu.com/';
$snoopy->fetch($url);
echo $snoopy->results;

?>