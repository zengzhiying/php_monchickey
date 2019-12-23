<?php
namespace fileprocess;
class FileUpload {

    //截取文件扩展名
    public function getExt($filename){
        return strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    }

    //产生唯一名称
    public function getUniqidName($length=10){
        return substr(md5(uniqid(microtime(true),true)),0,$length);
    }

    /**
     * 上传文件调用的方法
     * $fileInfo一般根据表单名称来比如$_FILES['upfile']
     * $path 上传到的目录位置 比如./upload 或者 /web/upload
     * $allowExt 允许的上传的文件格式 类型是数组 比如 array("gif","jpeg","jpg","png","txt")
     * $maxSize 允许上传文件的大小 整数 单位为字节 比如:1024*1024*2 则允许上传2M的文件
     */
    public function uploadFile($fileInfo,$path,$allowExt,$maxSize){
        //判断错误号
        if($fileInfo['error']==UPLOAD_ERR_OK){
            //文件是否是通过HTTP POST方式上传上来的
            if(is_uploaded_file($fileInfo['tmp_name'])){
                $ext=$this->getExt($fileInfo['name']);
                $uniqid=$this->getUniqidName();
                //纯中文字符在前面php不识别，必须最前面是字母或数字才可以保存中文文字信息
                $destination=$path."/".pathinfo($fileInfo['name'],PATHINFO_FILENAME)."_".$uniqid.".".$ext;
                //判断操作系统类型
                if(!isset($_SERVER['HTTP_USER_AGENT'])) {
                    return "没有检测到系统来源";
                }
                $Agent = $_SERVER['HTTP_USER_AGENT'];
                if(eregi('win', $Agent)) {
                    //是Windows系统则转码，避免中文字符输出到Windows平台乱码
                    $destination=iconv('utf-8', 'gbk', $destination);
                }
                
                if(in_array($ext,$allowExt)){
                    if($fileInfo['size']<=$maxSize){
                        if(move_uploaded_file($fileInfo['tmp_name'], $destination)){
                            $mes="文件上传成功";
                        }else{
                            $mes="文件移动失败";
                        }
                    }else{
                        $mes="文件过大";
                    }
                }else{
                    $mes="非法文件类型";
                }
            }else{
                $mes="文件不是通过HTTP POST方式上传上来的";
            }
        }else{
            switch($fileInfo['error']){
                case 1:
                    $mes="超过了配置文件的大小";
                    break;
                case 2:
                    $mes="超过了表单允许接收数据的大小";
                    break;
                case 3:
                    $mes="文件部分被上传";
                    break;
                case 4:
                    $mes="没有文件被上传";
                    break;
            }
        }
        
        return $mes;    
    }

    /**
     * php curl post方式上传文件
     * 兼容php >= 5.5 <5.5 7.0 自动检测php支持
     * 传入参数
     * @param $url 请求的url地址
     * @param $field_name 文件的字段名称
     * @param $filename 文件名(包含路径) 可以是相对路径 也可以是绝对路径(因为当前脚本嵌入执行脚本,所以以执行脚本路径为准)
     * @return $result 返回url响应
     */
    public function postFile($url, $field_name, $filename) {
        $ch = curl_init();
        if(class_exists('\CURLFile')) {
            // >= 5.5 以及 7.0.x
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
            $file_data = array($field_name => new \CURLFile(realpath($filename)));
        } else {
            if(defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
            $file_data = array($field_name => '@'.realpath($filename));
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);    //关闭头输出
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //保存到字符串 不输出
        // 向服务器发送代理来源
        curl_setopt($ch, CURLOPT_USERAGENT,"Linux");
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
?>