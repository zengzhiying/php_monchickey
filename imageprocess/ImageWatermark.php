<?php
namespace imageprocess;
/**
 * 图片加水印类
 */
class ImageWatermark {
	/**
	 * 图片添加水印
	 */
	public function addWatermark($filename, $watermark_filename) {
		$im = imagecreatefromjpeg($filename);
		$logo = imagecreatefrompng($watermark_filename);
		$size = getimagesize($watermark_filename);
		imagecopy($im, $logo, 15, 15, 0, 0, $size[0], $size[1]); 
		header("content-type: image/jpeg");
		imagejpeg($im);
		imagedestroy($im);
	}
}
?>