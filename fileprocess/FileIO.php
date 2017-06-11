<?php
class FileIO {


    /**
     * 读取全部文件内容
     */
    public function readFile($file_url){
        return file_get_contents($file_url);
    }

    /**
     * 一次读取一行并换行返回
     */
    public function readFilebr($file_url) {
        $fp = fopen($file_url, 'rb');
        $line_str = '';
        while(!feof($fp)) {
            $line_str .= "<br />".fgets($fp); //读取一行
        }
        fclose($fp);
        return $line_str;
    }

    /**
     * 按指定区间读取文件
     * 一个汉字要转换为3个字符
     * 换行符占两个字符
     */
    public function readFileSection($file_url,$start,$end) {
        $fp = fopen($file_url, 'rb');
        fseek($fp, $start);
        $contents = fread($fp, $end-$start);    //指针继续往下移动读取
        fclose($fp);
        return $contents;
    }

    /**
     * 文件写入，如果不存在会创建新文件
     * 写入内容之后会覆盖以前的全部内容
     * 如果写入是数组，那么写入文件时会自动连接成字符串，相当于implode('', $data)
     * 如果写入是数组的话，只能写入一维数组，不能是高维数组
     */
    public function writeFile($file_url,$data){
        return file_put_contents($file_url, $data);
    }

    /**
     * 追加写入文件内容方式，通过调整指针移动可以实现不覆盖写入
     * 根据传入数组来分行写入
     */
    public function addFileContent($file_url,$data_arr){
        $fp = fopen($file_url, 'wb');
        if(is_array($data_arr)){
            foreach ($data_arr as $data) {
                fwrite($fp, $data);
            }
        }else{
            fwrite($fp, $data_arr);
        }
        fclose($fp);
    }


    /**
     * 获得文件或目录的属性
     */
    public function getFileAttrib($file_url){
        //设置时区，为了让文件时间参数输出变化，不会更改任何基本的属性
        date_default_timezone_set('Asia/Shanghai');
        $attrib = array();  //定义属性数组
        define("HEX", 1024);
        $attrib['owner'] = fileowner($file_url);    //文件所有者
        $attrib['ctime'] = date('Y-m-d H:i:s',filectime($file_url));    //文件创建时间
        $attrib['mtime'] = date('Y-m-d H:i:s',filemtime($file_url));    //文件修改时间
        $attrib['atime'] = date('Y-m-d H:i:s',fileatime($file_url));    //最后访问时间
        $size = filesize($file_url);    //获取文件大小，默认单位为字节B

        //不好的算法
        // if($size < HEX) {
        //  $attrib['size'] = $size.'B';
        // }elseif($size >= HEX && $size < pow(HEX, 2)){
        //  $attrib['size'] = round($size/HEX,6)."KB";
        // }elseif($size >= pow(HEX,2) && $size < pow(HEX, 3)){
        //  $attrib['size'] = round($size/pow(HEX, 2),6)."MB";
        // }elseif($size >= pow(HEX, 3)){
        //  $attrib['size'] = round($size/pow(HEX, 3),6)."GB";
        // }

        //比较好的单位转换算法
        $size_arr = array('B','KB','MB','GB','TB','PB','EB');
        $i = 0;
        while ($size >= HEX) {
            $size /= HEX;
            $i++;
        }
        $attrib['size'] = round($size,6).$size_arr[$i];

        return $attrib;
    }

    /**
     * 删除文件或文件夹
     */
    public function deleteFile($file_url){
        if(file_exists($file_url)){
            //文件或目录存在
            if(is_file($file_url)){
                //是文件
                if(unlink($file_url)){
                    return true;
                }else{
                    return false;
                }
            }else{
                //是目录
                if($this->deleteDir($file_url)){
                    return true;
                }else{
                    return false;
                }
                //目录删除完毕
            }
        }else{
            //文件或目录不存在
            return false;
        }
    }

    /**
     * 删除目录，空或者非空
     * 私有方法，要确保为目录
     */
    private function deleteDir($dir_path) {
        $handle = opendir($dir_path);
        while (($item = readdir($handle)) !== false) {
            //循环返回条目
            if($item != "." && $item != ".."){
                if(is_file($dir_path.'/'.$item)){
                    unlink($dir_path.'/'.$item);
                }
                if(is_dir($dir_path.'/'.$item)){
                    //递归
                    $func = __FUNCTION__;
                    $this->$func($dir_path.'/'.$item);
                }
            }
        }
        closedir($handle);
        //删除最外层空目录
        if(rmdir($dir_path)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 遍历目录
     * 返回文件和目录的二维数组
     */

    public function ergodicDir($dir_path){
        $handle = @opendir($dir_path);
        while (($item = @readdir($handle)) !== false) {
            if($item != '.' && $item != '..'){
                if(is_file($dir_path.'/'.$item)){
                    $arr['file'][] = $item;
                }
                if(is_dir($dir_path.'/'.$item)){
                    $arr['dir'][] = $item;
                }
            }
        }
        closedir($handle);
        return $arr;
    }


    /**
     * 下载文件
     * 必须在单页面无其他任何输入进行纯净下载，否则会将所有缓冲一起写入文件
     */
    public function downloadFile($file_url){
        header('content-disposition:attachment;filename='.$file_url);
        header('content-length:'.filesize($file_url));
        readfile($file_url);
    }

    /**
     * 计算非空目录的大小
     */
    public function getDirSize($dir_path){
        static $sum = 0;    //静态变量，防止递归置零，或者全局变量也可以
        $handle = opendir($dir_path);
        while (($item = readdir($handle)) !== false) {
            if($item != '.' && $item != '..'){
                if(is_file($dir_path.'/'.$item)){
                    $sum += filesize($dir_path.'/'.$item);
                }
                if(is_dir($dir_path.'/'.$item)){
                    $this->getDirSize($dir_path.'/'.$item);
                }
            }
        }
        closedir($handle);
        //所占空间单位换算
        $size = $sum;   //避免$sum静态变量后来的消减而赋新值
        $size_arr = array('B','KB','MB','GB','TB','PB','EB');
        $i = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $i++;
        }
        return round($size,6).$size_arr[$i];
    }


    /**
     * 把一个数组存放到一个php文件中，下次调用的时候直接用require接收即可
     * 也可以存放到普通文件，利用json进行转换
     */
    public function saveArrayToFile($array, $filename) {

        //为了保证唯一性，文件如果存在，清除文件内容
        $fq = fopen($filename, "w+") or die("文件打开失败！");

        //写入处理
        $str_start = "<?php \r\nreturn ";
        $str_arr = var_export($array, true);
        $str_end = ";\r\n?>";
        $fp = fopen($filename, 'ab') or die("文件打开失败！");
        flock($fp, LOCK_EX);
        fwrite($fp, $str_start.$str_arr.$str_end);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

}
?>