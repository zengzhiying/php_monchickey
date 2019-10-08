<?php
/**
 * Csv操作类
 */
class CSVUtils {

    /**
     * 新建csv文件并初始化数据的方法
     * 参数1是要导入的数组数据,参数2文件名称,参数3为文件路径,可选，默认为当前路径
     * 成功返回true错误返回false
     */
    public function create($dataarray,$filename,$path = './'){
        if($fp = fopen($path.$filename, "w")){
            //写入csv文件时确保文件资源不被占用
            foreach ($dataarray as $value) {
                fputcsv($fp, $value) or die("Write failure");
            }
        }else{
            return false;
        }
        fclose($fp);
        return true;
    }


    /**
     * 向csv文件中追加数据
     */
    public function addContent($dataarray,$filename,$path = './'){
        $fp = fopen($path.$filename, "a") or die("File error");
        foreach ($dataarray as $key => $value) {
            fputcsv($fp, $value) or die("Write failure");
        }
        fclose($fp);
    }


    /**
     * 从csv文件中读取第一行数据,返回数组
     */
    function readLine($filename,$path = './') {
        $fp = fopen($path.$filename, "r") or die("File error");
        $data = fgetcsv($fp);
        fclose($fp);
        return $data;
    }


    /**
     * 从csv文件中读取所有数据，返回二维数组
     */
    function readContent($filename,$path = './') {
        $fp = fopen($path.$filename, "r") or die("File error");
        $data = array();
        while (!feof($fp)) {
            $data[] = fgetcsv($fp);
        }
        fclose($fp);
        return $data;
    }
}
?>