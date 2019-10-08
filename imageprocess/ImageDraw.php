<?php
/**
 * 图像绘制类 绘制线条，图形，文字等
 */
class ImageDraw {

	/**
	 * 绘制矩形对角线线条
	 */
	public function lineDraw($width, $height) {
		$img=imagecreatetruecolor($width, $height);	//创建空白图片
		$red=imagecolorallocate($img, 0xFF, 0x00, 0x00);	//创建画笔
		imageline($img,0,0,$width,$height,$red);	//绘制线条
		//imagefill($img, 0, 0, $red);	//全彩填充
		//输出图像到页面
		header("content-type: image/png");
		imagepng($img);
		//imagepng($img,'img.png');	//可以输出到文件，页面不显示
		//释放图片内存
		imagedestroy($img);
	}

	/**
	 * 绘制自定义字符串
	 */
	public function stringDraw($width, $height, $text) {
		$img = imagecreatetruecolor($width, $height);
		$red = imagecolorallocate($img, 0xFF, 0x00, 0x00);
		//开始绘制文字，不能为中文
		imagestring($img,5,0,13,$text,$red);
		header("content-type: image/png");
		imagepng($img);
		//imagejpeg($img,'img.jpg',80);	//输出图片到文件并设置压缩参数为80
		imagedestroy($img);
	}

}
?>