<?php
namespace jumpredirect;
/**
 * 页面跳转与重定向
 */
class JumpRedirect {

	/**
	 * 重定向方法
	 */
	public function redirect($url, $time=0, $msg='') {
	    //多行URL地址支持
	    $url        = str_replace(array("\n", "\r"), '', $url);
	    if (empty($msg))
	        $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
	    if (!headers_sent()) {
	        // redirect
	        if (0 === $time) {
	            header('Location: ' . $url);
	        } else {
	            header("refresh:{$time};url={$url}");
	            echo($msg);
	        }
	        exit();
	    } else {
	        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
	        if ($time != 0)
	            $str .= $msg;
	        exit($str);
	    }
	}


	/**
	 * 页面的跳转
	 */
	public function jump($url, $time = 0) {
		if($time == 0) {
			echo "<script>";
			echo "location.href='".$url."';";
			echo "</script>";
		} else {
			echo "<script>";
			$str = "setTimeout('js_jump()',".($time*1000).");";
			$str.= "function js_jump() {";
			$str.= "location.href='".$url."';";
			$str.= "}";
			echo $str;
			echo "</script>";
		}
	}

	/**
	 * 301重定向，要在header头被发送之前使用，否则无效
	 */
	public function redirect301($url) {
		header('HTTP/1.1 301 Moved Permanently');
		header('Location:'.$url);
		exit();
	}
}
?>