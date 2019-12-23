<?php
namespace clientdetection;
/**
 * 检测客户端信息的类
 * 包括访问的终端类型:手机端 vs 电脑端
 * 操作系统:windows,linux,mac,Android,ios...
 * 浏览器版本号:chrome42,UC10.0...
 */
class ClientDetection {
    /**
     * 判断终端类型:手机端、电脑端
     */
    public function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'xiaomi',
                'miui',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
                );
                // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public function os_type() {
        $data=$_SERVER['HTTP_USER_AGENT'];
        if(stripos($data,'windows')!==false){
            //是Windows操作系统
            if(stripos($data, 'NT 5.1')){
                //NT 5.1是32位XP，NT 5.2是64位XP
                return '32位 Windows XP';
            }
            if(stripos($data, 'NT 5.2')){
                return '64位 Windows XP或者Windows Server';
            }
            if(strripos($data, 'NT 6.0')){
                return '可能是Windows Vista';
            }
            if(stripos($data, 'NT 6.1')){
                return 'Windows 7';
            }
            if(stripos($data, 'NT 6.2')){
                return 'Windows 8';
            }
            if(stripos($data, 'NT 6.3')){
                return 'Windows 8.1';
            }
            if(stripos($data, 'NT 10')){
                return 'Windows 10';
            }
            return 'Windows';
        }
        if($d=stripos($data, 'Android')){
            //return substr($data, $d,13);
            if(preg_match('/Android\s\d\.\d\.\d/i', $data,$pipei)){
                return $pipei[0];
            }
        }
    }

    public function brower_ver(){
        $data=$_SERVER['HTTP_USER_AGENT'];
        if(stripos($data, 'Chrome')){
            //chrome内核浏览器
            if(preg_match('/Chrome\/\d+\.\d+\.\d+\.\d{1,}\s/i', $data,$pipei)){
                return str_replace('/', ' ', $pipei[0]);
            }
        }
        if(stripos($data, 'Trident')||stripos($data,'MSIE')){
            //Trident内核浏览器，IE
            if(preg_match('/Trident\/\d+\.\d+/i', $data,$pipei1)){
                $res=$pipei1[0];
            }else{
                $res='';
            }
            if(preg_match('/MSIE\s\d+\.\d+/i', $data,$pipei1)){
                $res.=' '.$pipei1[0];
            }else{
                $res.='';
            }
            return $res;
        }
    }


    /**
     * 获取访问者客户端ip
     */
    public function getClientIp() {
        return $_SERVER['REMOTE_ADDR'];
    }
}
?>