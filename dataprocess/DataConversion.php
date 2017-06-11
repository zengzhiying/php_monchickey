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
}
?>