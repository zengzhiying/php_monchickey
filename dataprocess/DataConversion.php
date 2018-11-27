<?php
require_once 'chinese_pinyin/ChinesePinyin.php';
/**
 * 数据转换类，json xml互转，json 关联数组互转等
 */
class DataConversion {

    /**
     * xml对象转换为数组
     * 传入值是xml的一个对象，一般是simplexml_load_file或者simplexml_load_string得到的对象
     */
    public function xmlObjToArray($xml_obj) {
        $json = json_encode((array) $xml_obj);
        return json_decode($json, true);
    }


    /**
     * xml对象转json串
     */
    public function xmlObjToJson($xml_obj) {
        return json_encode((array) $xml_obj);
    }

    /**
     * xml文件内容转数组
     */
    public function xmlFileToArray($xml_file) {
        $xml_obj = simplexml_load_file($xml_file);
        return self::xmlObjToArray($xml_obj);
    }

    /**
     * xml文件内容转json
     */
    public function xmlFileToJson($xml_file) {
        $xml_obj = simplexml_load_file($xml_file);
        return json_encode((array) $xml_obj);
    }

    /**
     * xml字符串转数组
     */
    public function xmlStrToArray($xml_str) {
        $xml_obj = simplexml_load_string($xml_str);
        return self::xmlObjToArray($xml_obj);
    }

    /**
     * xml字符串转json串
     */
    public function xmlStrToJson($xml_str) {
        $xml_obj = simplexml_load_string($xml_str);
        return self::xmlObjToJson($xml_obj);
    }

    /**
     * 汉字转拼音或者首字母
     * @param $chineses 纯汉字字符串或者汉字和字母混合串
     * @param $type 转换类型 默认是0全拼 首拼是1
     */
    public function chineseToPinyin($chineses, $type = 0) {
        $chinese_pinyin = new ChinesePinyin();
        return $chinese_pinyin->chineseToPinyin($chineses, $type);
    }

    /**
     * @param $float16bin
     *     float16格式的二进制字符串
     * @return
     *     返回对应的浮点数数组, 长度为字节数/2
     */
    function float16binTransform($float16bin)
    {
        $chars = unpack("C".strlen($float16bin), $float16bin);
        // print_r($chars);
        $float16_array = array();
        for($i = 1; $i < count($chars); $i += 2) {
            $high_char = $chars[$i];
            $low_char = $chars[$i + 1];
            $float16 = $this->byte2float16($high_char, $low_char);
            $float16_array[] = $float16;
        }
        return $float16_array;
    }

    /**
     * 两个字节转为半精度浮点数 bigend
     * @param $high_byte 高八位字节
     * @param $low_byte 低八位字节
     * @return 返回一个浮点数
     */
    function byte2float16($high_byte, $low_byte)
    {
        // 符号位
        $sym = $high_byte >> 7;
        // 指数位
        $pos = ($high_byte & 0x7c) >> 2;
        // echo "指数位: ".decbin($pos);
        // 尾数位
        $man = (($high_byte & 0x03) << 8) + $low_byte;
        // echo "尾数位: ".decbin($man);

        // 尾数浮点数
        $man_float = 1.0;
        for($i = 10; $i > 0; $i--) {
            $value = $man & (0x0001 << (10 - $i));
            if($value != 0) {
                $value = 1;
            }
            $man_float += $value * pow(2, -$i);
        }
        // echo $man_float;
        $float16 = pow(-1, $sym) * pow(2, $pos - 15) * $man_float;
        // echo $float16;
        return $float16;
    }
}


