<?php
header('Content-Type:text/html; charset=utf-8');
include_once 'DataCompute.php';
include_once 'DataVerify.php';
include_once './lunar_solar_calendar/LunarCalendar.php';
include_once './DataConversion.php';
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
$dc = new DataConversion();
echo $dc->chineseToPinyin("测试汉字a");
echo "<br />";
echo $dco->utf8_substr("hello这是一段测试文字", 4, 3);

