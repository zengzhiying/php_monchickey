<?php
namespace examples;
require_once "../autoload.php";
use dataprocess\DataCompute;
use dataprocess\DataVerify;
use dataprocess\lunar_solar_calendar\LunarCalendar;
use dataprocess\DataConversion;
header('Content-Type:text/html; charset=utf-8');
// include_once 'DataCompute.php';
// include_once 'DataVerify.php';
// include_once './lunar_solar_calendar/LunarCalendar.php';
// include_once './DataConversion.php';
$dco = new DataCompute();
// echo $dc->countDownDay("2017-04-01");
$dv = new DataVerify();
if($dv->isJSON('{"a":"ac","ck":"c","ms":6}')) {
    echo "是json";
} else {
    echo "不是json";
}
// 调用第三方类库
$lc = new LunarCalendar();
print_r($lc->solarToLunar(2017, 3, 17));
echo "<br />";
print_r($lc->lunarToSolar(2017, 2, 20));
echo "<br />";
$dc = new DataConversion();
echo $dc->chineseToPinyin("测试汉字a");
echo "<br />";
print_r($dc->chineseToPinyin("曾智颖 李淑丽"));
echo "<br />";
echo $dco->utf8_substr("hello这是一段测试文字", 4, 3);
echo "<br />";
// $s = 'LAE=';
// $s = 'mmw=';
$s = 'CzxbP+eTmmw=';
$float16_bin = base64_decode($s);
$float16_numbers = $dc->float16binTransform($float16_bin);
var_dump($float16_numbers);

