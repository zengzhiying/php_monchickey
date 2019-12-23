<?php
namespace imageprocess;
/**
 * 不同种类的生成图像验证码生成类
 */
class AuthCode {

	/**
	 * 生成4位数字验证码
	 */
	public function numberCode($width, $height) {
		$img = imagecreatetruecolor($width, $height);
		$black = imagecolorallocate($img, 0x00, 0x00, 0x00);
		$green = imagecolorallocate($img, 0x00, 0xFF, 0x00);
		$white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
		imagefill($img,0,0,$white);	//绘制底色为白色
		//生成随机的验证码
		$code = '';
		for($i = 0; $i < 4; $i++) {
		    $code .= rand(0, 9);
		}
		imagestring($img, 6, 13, 10, $code, $black);
		//加入噪点干扰
		for($i=0;$i<50;$i++) {
		  imagesetpixel($img, rand(0, $width) , rand(0, $width) , $black); 
		  imagesetpixel($img, rand(0, $width) , rand(0, $width) , $green);
		}
		//输出验证码
		header("content-type: image/png");
		imagepng($img);
		imagedestroy($img);
	}
}
?>