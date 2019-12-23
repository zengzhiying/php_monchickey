<?php
namespace dataprocess;
/**
 * 数据抽取类 从字符串中以及长文本中获取有用的数据
 */
class DataExtract {
    
    /**
     * 获取xml或html标签内容
     */
    public function get_tag($tag, $data) {
        $tag = preg_quote($tag);
        preg_match_all('/<'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/i', $data, $matches, PREG_PATTERN_ORDER);
        return $matches[1];
    }


    /**
     * 获取带有属性的xml或者html标签内容
     */
    public function get_attr_tag($attr, $value, $data, $tag=null) {
        if(is_null($tag)) {
            $tag = '\w+';
        } else {
            $tag = preg_quote($tag);
        }
        $attr = preg_quote($attr);
        $value = preg_quote($value);

        $tag_regex = "/<(".$tag.")[^>]*$attr\s*=\s*"."(['\"])$value\\2[^>]*>(.*?)<\/\\1>/";

        preg_match_all($tag_regex, $data, $matches, PREG_PATTERN_ORDER);
        return $matches[3];
    }

}
?>