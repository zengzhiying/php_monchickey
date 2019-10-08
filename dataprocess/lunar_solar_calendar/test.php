<?php
header("Content-Type:text/html; charset=utf-8");
require_once './LunarCalendar.php';
require_once './LunarCalendar1.php';
$lc = new LunarCalendar();
$lc1 = new LunarCalendar1();
// print_r($lc->solarToLunar(2037, 11, 18));
// print_r($lc->lunarToSolar(2037, 12,15));
// echo "<br />";
print_r($lc1->lunarToSolar('2017-2-20'));
