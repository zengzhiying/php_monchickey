<?php
class HttpSession {

	//设置cookie cookie是不同步的，需要刷新
	public function setCookie($cookie_name,$value,$time = 0) {
		if($time == 0) {
			//默认关闭浏览器过期
			if(setcookie($cookie_name,$value)){
				//设置成功 但浏览器并不一定接受
				return true;
			}else{
				return false;
			}
		} else {
			if(setcookie($cookie_name,$value,time()+$time)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//删除cookie
	public function deleteCookie($cookie_name) {
		if(isset($_COOKIE[$cookie_name])) {
			if(setcookie($cookie_name,'',time()-1)) {
				//也可以用 setcookie($cookie_name,'')来删除
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}


	//通过http头来设置cookie
	public function setHttpCookie($cookie_name, $value) {
		if(!headers_sent()) {
			header("Set-Cookie:".$cookie_name."=".$value);
		}
	}

	//通过http头来删除cookie
	public function deleteHttpCookie($cookie_name, $value = '') {
		header("Set-Cookie:".$cookie_name."=".$value."; expires=".gmdate('D, d M Y H:i:s \G\M\T', time()-1));
	}


	//设置session session可以即时生效
	public function setSession($session_name, $value) {
		//session默认关闭浏览器失效，但服务端仍然存在
		session_start();
		$_SESSION[$session_name] = $value;
		if(isset($_SESSION[$session_name])) {
			return true;
		} else {
			return false;
		}
	}

	//销毁session
	public function deleteSession($session_name) {
		session_start();
		if(isset($_SESSION[$session_name])) {
			unset($_SESSION[$session_name]);
		}
	}


	/**
	 * cookie对象信息序列化并加密
	 * @param array $array
	 * @param string $key
	 * @param string $cookie_name
	 * @param int $time
	 * @return boolean
	 */
	public function cookieEncryption($array, $key, $cookie_name, $time) {
		//$array为要加密的一个信息数组，$key为加密秘钥只能为 16,24,32位，$cookie_name是最终加密后的cookie名，$time是失效的时间
		//序列化
		$str = serialize($array);
		//加密
		$str = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB));
		//设置cookie，直接可以输出加密后的字符串
		if(setcookie($cookie_name, $str)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * cookie信息解密并反序列化，必须是使用本类中的cookieEncryption加密的才可以
	 */
	public function cookieDecrypt($cookie_name, $key) {
		//$key必须也是16、24、32位字符串
		if(isset($_COOKIE[$cookie_name])) {
			$cookie_str = $_COOKIE[$cookie_name];
			$cookie_str = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($cookie_str), MCRYPT_MODE_ECB);
			$cookie_arr = unserialize($cookie_str);
			return $cookie_arr;
		} else {
			return false;
		}
	}
}
?>