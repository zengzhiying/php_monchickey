<?php
class ImageCut {
	/**
	 * 图片裁剪方法
	 * 传入参数是旧文件名和新文件名(包括路径)以及裁剪的参数
	 */
	public function image_curt($filename, $newfile, $src_x, $src_y, $src_w, $src_h){
		//创建目标图像
		$dst_im = imagecreatetruecolor($src_w, $src_h);

		//源图像
		$src_im = imagecreatefrompng($filename);

		//拷贝源图像至目标图像
		//将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。
		imagecopy( $dst_im, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h );

		header("content-type: image/jpeg");
		//输出拷贝后图像
		imagejpeg($dst_im, $newfile);

		imagedestroy($dst_im);
		imagedestroy($src_im);
	}
}
?>