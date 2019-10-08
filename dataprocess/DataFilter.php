<?php
/**
 * 数据过滤类 对用户输入的字符串和文本内容进行过滤脱壳，从而预防攻击
 */
class DataFilter {

    /**
     * 一般的数据过滤，不影响一般显示
     * 参数$set=0简单过滤 $set=1循环清除嵌套过滤
     */
    public function inputFilter($data,$set=0) {
        if(strlen($data)!=0){
            //长度非零检查
            $str_array = $this->count_str($data);       //获取特殊字符个数


            if((isset($str_array['x'])&&$str_array['x']>='16')||(isset($str_array['X'])&&$str_array['X']>='16')||(isset($str_array['\\'])&&$str_array['\\']>='16')){

                $data=preg_replace("![\\][xX]([A-Fa-f0-9]{1,3})!","",$data);    //正则表达式过滤16进制
            }

            $data=nl2br($data);


            if($set=='1'){
                while (stristr($data, '<script>')) {
                    $data=str_ireplace('<script>', '', $data);
                }
                while (stristr($data, '<script type="text/javascript">')) {
                    $data=str_ireplace('<script type="text/javascript">', '', $data);
                }

                while (stristr($data, '<script type=\'text/javascript\'>')) {
                    $data=str_ireplace('<script type=\'text/javascript\'>', '', $data); //当单引号内包含单引号时，\转义就是字符本身而不是实体
                }

                while (stristr($data, '</script>')) {
                    $data=str_ireplace('</script>', '', $data);
                }

                while (stristr($data, 'javascript')) {
                    $data=str_ireplace('javascript', '', $data);
                }

                while (stristr($data, 'jscript')) {
                    $data=str_ireplace('jscript', '', $data);
                }

                while (stristr($data, 'vbcript')) {
                    $data=str_ireplace('vbcript', '', $data);
                }

                while (stristr($data, 'script')) {
                    $data=str_ireplace('script', '', $data);
                }

                while (stristr($data, 'alert')) {
                    $data=str_ireplace('alert', '', $data);
                }

                while (stristr($data, '&#')) {
                    $data=str_ireplace('&#', '', $data);
                }

                while (stristr($data, 'onclick')) {
                    $data=str_ireplace('onclick', '', $data);
                }

                while (stristr($data, 'onerror')) {
                    $data=str_ireplace('onerror', '', $data);
                }
                while (stristr($data, 'meta')) {
                    $data=str_ireplace('meta', '', $data);
                }

                while (stristr($data, 'http-equiv')) {
                    $data=str_ireplace('http-equiv', '', $data);
                }

                while (stristr($data, 'refresh')) {
                    $data=str_ireplace('refresh', '', $data);
                }

                while (stristr($data, 'onmouseover')) {
                    $data=str_ireplace('onmouseover', '', $data);
                }
                while (stristr($data, '<video')) {
                    $data=str_ireplace('<video', '', $data);
                }
                while (stristr($data, '<iframe')) {
                    $data=str_ireplace('<iframe', '', $data);
                }
                while (stristr($data, '<embed')) {
                    $data=str_ireplace('<embed', '', $data);
                }
                while (stristr($data, '<input')) {
                    $data=str_ireplace('<input', '', $data);
                }
                while (stristr($data, '=submit')) {
                    $data=str_ireplace('=submit', '', $data);
                }
                while (stristr($data, '="submit"')) {
                    $data=str_ireplace('="submit"', '', $data);
                }

                while (stristr($data, '<isindex')) {
                    $data=str_ireplace('<isindex', '', $data);
                }
                while (stristr($data, '<button')) {
                    $data=str_ireplace('<button', '', $data);
                }
                while (stristr($data, '<form')) {
                    $data=str_ireplace('<form', '', $data);
                }
                while (stristr($data, 'action=')) {
                    $data=str_ireplace('action=', '', $data);
                }
                while (stristr($data, '<object')) {
                    $data=str_ireplace('<object', '', $data);
                }
                while (stristr($data, 'data=')) {
                    $data=str_ireplace('data=', '', $data);
                }

                while (stristr($data, 'data:text')) {
                    $data=str_ireplace('data:text', '', $data);
                }
                while (stristr($data, '<applet')) {
                    $data=str_ireplace('<applet', '', $data);
                }
            }else{
                $data=str_ireplace('<script>', '', $data);
                $data=str_ireplace('<script type="text/javascript">', '', $data);
                $data=str_ireplace('<script type=\'text/javascript\'>', '', $data); //当单引号内包含单引号时，\转义就是字符本身而不是实体
                $data=str_ireplace('</script>', '', $data);
                $data=str_ireplace('javascript:', '', $data);
                $data=str_ireplace('javascript', '', $data);
                $data=str_ireplace('jscript:', '', $data);
                $data=str_ireplace('jscript', '', $data);
                $data=str_ireplace('vbscript:', '', $data);
                $data=str_ireplace('vbscript', '', $data);
                $data=str_ireplace('script', '', $data);
                $data=str_ireplace('alert', '', $data);
                $data=str_ireplace('&#', '', $data);
                $data=str_ireplace('onclick', '', $data);
                $data=str_ireplace('onerror', '', $data);
                $data=str_ireplace('<meta', '', $data);
                $data=str_ireplace('http-equiv', '', $data);
                $data=str_ireplace('refresh', '', $data);
                $data=str_ireplace('onmouseover', '', $data);
                $data=str_ireplace('<video', '', $data);
                $data=str_ireplace('<iframe', '', $data);
                $data=str_ireplace('<embed', '', $data);
                $data=str_ireplace('<input', '', $data);
                $data=str_ireplace('=submit', '', $data);
                $data=str_ireplace('="submit"', '', $data);
                $data=str_ireplace('<isindex', '', $data);
                $data=str_ireplace('<button', '', $data);
                $data=str_ireplace('<form', '', $data);
                $data=str_ireplace('action=', '', $data);
                $data=str_ireplace('<object', '', $data);
                $data=str_ireplace('data=', '', $data);
                $data=str_ireplace('data:text', '', $data);
                $data=str_ireplace('<applet', '', $data);
            }

            $data = str_replace('\\n', '', $data);

            return $data;
        }else{
            return $data;
        }
    }


    /**
     * 防止Xss攻击，严格过滤
     */

    public function cleanXss($data){
        if(!is_array($data)){
            //非数组操作
            return self::xssFilter($data);
        }else{
            $keys=array_keys($data);    //获得数组索引
            foreach ($keys as $key) {
                $ret_data[]=self::xssFilter($data[$key]);
            }
            return $ret_data;
        }
    }

    private function xssFilter($data){
        $data=trim($data);
        $data=strip_tags($data);
        $data=htmlspecialchars($data);
        $str_array=array('"', "\\", "'", "/", "..", "../", "./", "//","%"); //危险字符过滤
        $data=str_replace($str_array, '', $data);
        $no = '/%0[0-8bcef]/';
        $data=preg_replace($no, '', $data);
        $no = '/%1[0-9a-f]/';
        $data=preg_replace($no, '', $data);
        $no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
        $data=preg_replace($no, '', $data);
        return $data;
    }

    /**
     * 防止SQL注入
     * 服务器配置 php.ini magic_quotes_gpc选项设置为On    可以避免字符型字段注入，不可以避免数值型注入
     * addslashes()只能进行字符型转义，和上面功能相同
     */

    public function charEscape($data){
        $data = mysql_real_escape_string($data);    //特殊字符转义
        return $data;
    }


    /**
     * 统计字符串中个元素个数
     */

    private function count_str($str){
        $str_array=str_split($str);
        $str_array=array_count_values($str_array);
        arsort($str_array);
        return $str_array;
    }
}
?>