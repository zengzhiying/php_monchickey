<?php
/**
 * 数据验证类，一般是常用的表单输入的字符串验证方法
 */
class DataVerify {

    /**
     * 最基本的验证 数据存在性验证
     * 该验证要在处理中直接验证，用isset或者empty也可以，最基本的验证不用调用方法
     */
    public function isThere($data) {
        if(isset($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 字符串非空验证
     */
    public function isEmpty($data){
        if(isset($data) && !empty($data)){
            $return_value = true;
        }else{
            $return_value = false;
        }
        return $return_value;
    }


    /**
     * 验证电子邮箱
     */

    public function isEmail($email) {
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex+1);   //获取域名部分
            $local = substr($email, 0, $atIndex);   //获取用户名部分
            //获取用户名和域名长度
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                // 用户名长度不符合
                $isValid = false;
            }else if ($domainLen < 1 || $domainLen > 255){
            // 域名长度不符合
                $isValid = false;
            }else if ($local[0] == '.' || $local[$localLen-1] == '.') {
            // 用户名前后不能为.
                $isValid = false;
            }else if (preg_match('/\\.\\./', $local)) {
            // 用户名中间部分连续有两个.
                $isValid = false;
            }else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // 匹配域名部分是否符合要求
                $isValid = false;
            }else if (preg_match('/\\.\\./', $domain)) {
            // 域名局部不能出现两个..
                $isValid = false;
            }else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
            // 验证匹配非法特殊字符 
            // 检查局部反斜杠
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
                    $isValid = false;
                }
            }if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
            // 向域名主机发送DNS通信检查，检测解析是否做MX和A记录
                $isValid = false;
            }
        }
        return $isValid;
    }

    /**
     * 匹配手机号的方法
     */
    public function isPhoneNumber($data) {
        $pattern='/^((13[0-9])|147|(15[0-35-9])|170|180|182|(18[5-9]))[0-9]{8}$/i';
        if(!preg_match($pattern, $data)) {
            return false;
        }else {
            return true;
        }
    }


    /**
     * 检查URL，包括http://
     */
    public function isUrl($url){
        if(!filter_var($url,FILTER_VALIDATE_URL)){
            return false;
        }else{
            return true;
        }
    }


    /**
     * 验证正整数，仅仅是正整数，0,01这样的都不通过
     */
    public function isPosInt($num){
        if(preg_match('/^[1-9][0-9]{0,}$/', $num)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 非负整数验证 验证正整数和0，001这样的也可以
     */
    public function isPosIntAndZero($num){
        if(preg_match('/^\d{1,}$/', $num)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 整数验证 包括正整数，负整数，0
     */

    public function isInt($data){
        $pattern='/^-?\d+$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }




    /**
     * 非负浮点数 包括正浮点数和0
     * \d和[0-9]等效，[]应用更广
     */

    public function isPosPoint($data){
        $pattern='/^(([1-9]\d{0,}(\.\d+)?)|0|([0]\.\d{1,}))$/';
        if(!preg_match($pattern, $data)){
            return false;
        }else{
            return true;
        }
    }


    /**
     * 由26个英文字母组成的字符串 包括大小写
     */

    public function isLetters($data){
        $pattern='/^[A-Za-z]+$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 由数字和26个英文字母组成的字符串 包括大小写
     */

    public function isDigLet($data){
        $pattern='/^[A-Za-z0-9]+$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 由数字和26个英文字母和下划线组成的字符串 包括大小写
     */

    public function isString($data){
        $pattern='/^\w+$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 验证用户名5-16位，不能以数字开头，只能包含数字、字母、下划线
     */

    public function isUserName($data){
        $pattern='/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 验证用户密码6-18位，为了安全，暂时没加%,<,>,',"这五个字符
     */

    public function isPassWord($data){
        $pattern='/^[a-zA-Z0-9_\~\`\!\@\#\$\^\&\*\(\)\-\+\=\{\}\\\.\[\]\;\:\,\/\?]{6,18}$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 匹配腾讯QQ号
     */

    public function isQQ($data){
        $pattern='/^[1-9][0-9]{4,11}$/';
        if(preg_match($pattern, $data)) {
            return true;
        }else {
            return false;
        }
    }


    /**
     * 检查日期格式，比如：2015-08-07
     */
    public function isDate($date){
        $pattern='/^\d{4}-\d{1,2}-\d{1,2}$/';
        if(preg_match($pattern, $date)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 匹配国内电话号码 如010-28928129 0531-2282728
     */

    public function isTelNumber($data){
        $pattern='/^((\d{3}-\d{8})|(\d{4}-\d{7,8}))$/';
        if(preg_match($pattern, $data)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 验证国内邮政编码
     */

    public function isZipCode($data){
        $pattern='/^[1-9]\d{5}$/';
        if(preg_match($pattern, $data)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证IP地址
     */

    public function isIp($data){
        $pattern='/^((([1-9])|((0[1-9])|([1-9][0-9]))|((00[1-9])|(0[1-9][0-9])|((1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))))\.)((([0-9]{1,2})|(([0-1][0-9]{2})|(2[0-4][0-9])|(25[0-5])))\.){2}(([1-9])|((0[1-9])|([1-9][0-9]))|(00[1-9])|(0[1-9][0-9])|((1[0-9]{2})|(2[0-4][0-9])|(25[0-5])))$/';
        if(preg_match($pattern, $data)) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * 验证身份证号 15位或者18位最后可能为X
     */

    public function isIdNumber($data){
        $pattern='/^(([0-9]{15})|([0-9]{18})|([0-9]{17}X))$/';
        if(preg_match($pattern, $data)) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * 匹配多个纯汉字，把+换成{3}即为匹配3个汉字，用来验证姓名等
     */

    public function isChinese($data){
        $pattern='/^[\x{4E00}-\x{9FBF}]+$/u';
        if(preg_match($pattern, $data)) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * 匹配是否是16进制的颜色值
     */
    public function isHexColor($data) {
        if(preg_match('/^#[0-9a-f]{6}$/i', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证一个字符串是否为json类型
     * @param $content 要验证的字符串
     * @return 是返回true 不是返回false
     */
    public function isJSON($content) {
        return !is_null(json_decode($content));
    }
}
?>