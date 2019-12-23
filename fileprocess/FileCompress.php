<?php
namespace fileprocess;
/**
 * 文件压缩解压类
 */
class FileCompress {
    
    /**
     * 传入要解压的zip包名，$path解压到的目录
     */
    public function unZip($zip_filename, $path){
        error_reporting(E_ALL);
        set_time_limit(0);
        if(!is_file($zip_filename)){
            die('文件"'.$zip_filepname.'"不存在!');
        }
        $zip = new ZipArchive();
        $rs = $zip->open($zip_filename);
        if($rs !== true){
            //die('解压失败! 错误代码:'. $rs);
            return false;
        }
        $zip->extractTo($path);
        $zip->close();
        return true;
    }
}
?>