<?php
/**
 * cURL远程页面抓取类
 */
class WebGrab {
    
    /**
      * 模拟登录
      */ 
    public function login_post($url, $cookie, $post) { 
        $curl = curl_init();//初始化curl模块 
        curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址 
        curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息 
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 
        curl_setopt($curl, CURLOPT_POST, 1);//post方式提交 
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
        //执行cURL
        if(curl_exec($curl)) {
            return true;
        } else {
            return false;
        }
        curl_close($curl);//关闭cURL资源，并且释放系统资源 
    }

    /**
     * 登录成功后获取页面数据
     */
    public function get_content($url, $cookie) { 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie 
        //执行cURL抓取页面内容
        $rs = curl_exec($ch);
        curl_close($ch); 
        return $rs; 
    }


    /**
     * 指定url的源代码返回(无cookie)
     * $arr是post参数 get参数放在url中
     */
    public function getUrl($url, $arr = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //保存到字符串
        if($arr != '') {
            //开启post发送
            curl_setopt($ch, CURLOPT_POST, 1);
            //传入post请求数组
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arr));
        }
        //开启gzip压缩
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $data = curl_exec($ch);
        curl_close($ch);
        //转码放到具体操作中
        //$data = iconv("gbk", "utf-8", $data);
        return $data;
    }

    /**
     * 短网址还原
     * 只能通过检测http头部重定向信息判断跳转之后的url
     */
    public function sortUrlReduction($url) {
        $data = get_headers($url);
        $i = 0;
        foreach ($data as $key => $value) {
            if(stripos($value,'Location:') !== false){
                $red = substr($value, 10, strlen($value)-1);
                $i++;
            }
        }
        if($i == 0){
            return false;
        }else{
            return $red;
        }
    }


    /**
     * 获取html文档中的所有图片
     * 传入参数是已经获取到的网页源代码
     */
    public function getHtmlImages($data) {
        $images = array();
        preg_match_all('/(img|src)=("|\')[^"\'>]+/i', $data, $media);
        unset($data);
        $data = preg_replace('/(img|src)("|\'|="|=\')(.*)/i', "$3", $media[0]);
        foreach ($data as $url) {
            $info = pathinfo($url);
            if(isset($info['extension'])) {
                if($info['extension'] == 'jpg' || $info['extension'] == 'jpeg' || $info['extension'] == 'gif' || $info['extension'] == 'png') {
                    array_push($images, $url);
                }
            }
        }
        return $images;
    }


    /**
     * 获取指定链接的标题
     * 利用文件操作实现
     */
    public function getUrlTitle($url) {
        define("ERROR", "error");
        if(!($fp = fopen($url, "r"))) {
            return ERROR;
        }
        $page = "";
        while (!feof($fp)) {
            $page .= fgets($fp, 4096);
        }
        $titre = preg_match_all("/<title>(.*?)<\/title>/i", $page, $regs);
        fclose($fp);
        return $regs[1][0];
    }

    /**
     * 发送post请求的另一种方式
     * 当不能使用curl扩展时可以使用该方式
     */
    public function sendPost($url, $query) {
        $post_query = http_build_query($query);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $post_query,
                'timeout' => 15 * 60
                ),
            );
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }


    /**
     * 远程下载图片并保存到本地
     * 成功 返回true 失败返回false
     */
    public function saveImageUri($url, $filename) {
        if(($content = file_get_contents($url)) != false){
            //读取成功
            if(file_put_contents($filename, $content) != false) {
                //下载成功
                return true;
            }else{
                return false;
            }
        } else{
            return false;
        }
    }

}
?>