<?php

require_once dirname(__FILE__).'/PBKDF2Hash.php';

/**
 * 数据统计计算类库
 */
class DataCompute {
    
    /**
     * 乘法口诀表，返回字符串直接输出即可
     */
    public function multiplication() {
        $str = '';
        for($i = 1;$i <= 9;$i++)
        {
            $str.= "<table>";
            $str.= "<tr>";
            for($j = 1;$j <= $i;$j++)
            {
                $str.= "<td width='68px'>";
                $str.= $j."×".$i."=".$i*$j;
                $str.= "</td>";
            }
            $str.= "</tr>";
            $str.= "</table>";
        }

        return $str;
    }

    /**
     * 判断一个数是否是质数
     */
    public function isPrime($number) {
        if($number==2)
        {
            return true;
        }
        elseif ($number%2==0) {
            return false;
        }
        $ret=true;
        $j=0;
        for($i=3;$i<$number;$i+=2)
        {
            if($number%$i==0)
            {
                $ret=false;
            }
        }
        return $ret;
    }

    /**
     * 判断某一年是否为闰年
     */
    public function isLeapyear($year) {
        if((($year%4==0)&&($year%100!=0))||($year%400==0)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 生成唯一ID字符串
     */
    public function uniqueId(){
        $id=md5(uniqid(rand(),true));
        return $id;
    }

    /**
     * 计算当前时间至某一时间的倒计时天数，传入到达时间的字符串，例如2018-08-30
     */
    public function countDownDay($target_date) {
        // 设置时区
        date_default_timezone_set("Asia/Shanghai");
        $nowtime = strtotime(date("Y-m-d"));
        $target_time = strtotime($target_date);
        $sub_time = ceil(($target_time - $nowtime)/86400);
        return $sub_time;
    }

    /**
     * 创建pbkdf2 hash 二次封装
     * @param $password 待hash的密码
     * @return 密码做pbkdf2 hash后的字符串
     */
    public function pbkdf2Hash($password) {
        $pbkdf2_hash = new PBKDF2Hash();
        return $pbkdf2_hash->createHash($password);
    }

    /**
     * 验证hash和密码是否匹配 二次封装
     * @param $password 要验证的密码
     * @param $correct_hash 已经hash过的字符串
     * @return 验证通过返回true 验证失败返回false
     */
    public function validatePBKDF2Hash($password, $correct_hash) {
        $pbkdf2_hash = new PBKDF2Hash();
        return $pbkdf2_hash->validatePassword($password, $correct_hash);
    }

    /**
     * 截取utf8字符串 可以中英文混合,中文截取一个字 英文截取一个字母 避免出现乱码的情况
     * @param $content 要截取的字符串
     * @param $start 开始截取的位置
     * @param $length 截取的长度
     * @return 返回截取得到的字符串
     */
    public function utf8_substr($content, $start, $length) {
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $length . '}).*#s', '$1', $content);
    }

}
?>