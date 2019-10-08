<?php
/**
 * php分割以及合并文件操作类
 * 使用是一定要设置如下参数
 * 设置允许脚本使用的最大内存 根据要分割的单个文件大小设置 至少要大于block的2倍以上
 * ini_set("memory_limit", "50M");
 * 设置脚本通过web执行的最大时间 默认为30s 命令行执行脚本时默认为0 和其他程序一样不限制时间
 * ini_set("max_execution_time", "100");
 */
class FileSplitMerge {
    
    /**
     * 分割文件的方法
     * @param $file_name 要分割的文件名
     * @param $block 分割单个块文件大小 单位为B
     * @param $cache_path 文件打碎后存放的临时目录
     * @param $chche_file_name 分割后的临时文件名前缀 比如是:vbcache则分割后是vbcache1.dat,vbcache2.dat,...
     * @return 源文件或临时目录不存在返回false, 分割完毕返回true
     */
    function splitFile($file_name, $block, $cache_path, $cache_file_name = 'vbcache') {
        if(!file_exists($file_name) || !is_dir($cache_path)) {
            // 源文件或临时目录不存在
            return false;
        }
        $num = 1;
        $fp = fopen($file_name, 'rb');
        if(substr($cache_path, strlen($cache_path) - 1, strlen($cache_path)) != '/') {
            $cache_path .= "/";
        }
        while ($dat = fread($fp, $block)) {
            $cache_file = $cache_path.$cache_file_name.$num++.'.dat';
            $cache_fp = fopen($cache_file, 'wb');
            fwrite($cache_fp, $dat);
            fclose($cache_fp);
            // echo "分割完毕 --".($num - 1)."次!<br />";
            // echo "长度:".strlen($dat)."<br />";
        }
        fclose($fp);
        return true;
    }

    /**
     * 合并文件的方法 与分割文件方法配合双向操作 默认会自动检测指定目录下对应的分片 只要保证临时文件前缀一致即可合并文件
     * @param $output_file 合并后的输出文件名
     * @param $cache_path 分割碎片存储目录
     * @param $chche_file_name 分割后的临时文件名前缀 比如是:vbcache则分割后是vbcache1.dat,vbcache2.dat,...
     * @return 源文件不存在返回false, 分割完毕返回true
     */
    function mergeFile($output_file, $cache_path, $cache_file_name = 'vbcache') {
        if(!is_dir($cache_path)) {
            // 临时目录不存在
            return false;
        }
        if(substr($cache_path, strlen($cache_path) - 1, strlen($cache_path)) != '/') {
            $cache_path .= "/";
        }
        $num = $tag = 1;
        $fp = fopen($output_file, 'wb');
        while(true) {
            $cache_file = $cache_path.$cache_file_name.$num++.'.dat';
            if(file_exists($cache_file)) {
                $cache_fp = fopen($cache_file, 'rb');
                fwrite($fp, fread($cache_fp, filesize($cache_file)));
                fclose($cache_fp);
                $tag++;
                // echo "合并".($num - 1)."次!--长度:" . filesize($cache_file) . "<br />";
            } else {
                // 合并完毕或序号中断或文件本来就不存在
                // echo "quit...<br />";
                break;
            }
        }
        fclose($fp);
        if($tag == 1) {
            // 如果一个文件也没有合并 则返回失败
            return false;
        }
        return true;
    }
}

