<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
/*
*****************************************************************************************************
* 2010-12-06 17:07
* 水印函数开
* 函数名 watermar
* $groundimage     背景图片，即需要加水印的图片，支持gif,jpg,png,bmp格式；
* $markimage       图片水印，即作为水印的图片，只支持GIF,JPG,PNG格式*
* $markwidthaterPos 水印位置，有10种状态，默认为0，0为随机位置；
*  1为顶端居左，2为顶端居中，3为顶端居右；
*  4为中部居左，5为中部居中，6为中部居右；
*  7为底端居左，8为底端居中，9为底端居右；

* $marktext  文字水印，即把文字作为为水印，支持中文,默认为C:\WINDOWS\Fonts/simhei.ttf(黑体)；
* $fontsize  文字大小，值为1、2、3......23、24、25，默认为15；
* $fontcolor 文字颜色，值为十六进制颜色值，默认为#FF0000(红色)；
* $marktype  水印类型，0为图片，1为文字，默认为0(图片)；
*****************************************************************************************************
*/
 
class Watermark {
	
    public function __construct() {}
	
	public function Mark($groundimage='' , $markimage='' , $markwhere='0', $marktext='CM', $fontfamily='黑体', $fontsize='15', $fontcolor="#000", $marktype=0)
	{
		//配置水印图片文件
		if(!file_exists($markimage))
		{
			$markimage = 'C:\AppServ\www\gzpft\public\images\mark_logo.png';
		}
		else if(!file_exists($markimage))
		{
			$marktype = '1';
		}
		
		//读取水印文件
		if(($marktype == 0) && file_exists($markimage))
		{
			$markimage_info   = @getimagesize($markimage);
			$markimage_width  = $markimage_info[0]; //取得水印图片的宽
			$markimage_height = $markimage_info[1]; //取得水印图片的高
			switch($markimage_info[2]) //取得水印图片的格式 
			{
				case 1:
				$from_markimage = @imagecreatefromgif($markimage);
				break;
			   case 2:
				$from_markimage = @imagecreatefromjpeg($markimage);
				break;
			   case 3:
				$from_markimage = @imagecreatefrompng($markimage);
				break;
			   case 4:
				$from_markimage = @imagecreatefromwbmp($markimage);
				break;
			   default:
				break;
			}
		}
 
	   //读取背景图片
	   if(!empty($groundimage) && file_exists($groundimage))
	   {
		   $groundimage_info   = getimagesize($groundimage);
		   $groundimage_width  = $groundimage_info[0];
		   $groundimage_height = $groundimage_info[1];
		   switch($groundimage_info[2])
		   {
			   case 1:
				$from_groundimage = @imagecreatefromgif($groundimage);
				break;
			   case 2:
				$from_groundimage = @imagecreatefromjpeg($groundimage);
				break;
			   case 3:
				$from_groundimage = @imagecreatefrompng($groundimage);
				break;
			   case 4:
				$from_groundimage = @imagecreatefromwbmp($groundimage);
				break;
			   default:
				break;
		   }
	   }

	   //水印位置
	   if($marktype == 0)
	   {
		   $markwidth  = $markimage_width;
		   $markheight = $markimage_height;
	   }
	   else
	   {
		   $temp = imagettfbbox($fontsize, 0, $fontfamily, $marktext); //取得使用 TrueType 字体的文本的范围
		   $markwidth  = $temp[2] - $temp[6];
		   $markheight = $temp[3] - $temp[7];
		   unset($temp);//释放内存
	   }
	   
	   //设定图像的混色模式
	   @imagealphablending($from_groundimage, true);
 
	   if($marktype == 0) //图片水印
	   {
		   switch($markwhere)
		   {
			   case 0://随机
				$pos_x = rand(0,($groundimage_width - $markwidth - 10));
				$pos_y = rand(0,($groundimage_height - $markheight - 10));
				break;
			   case 1://1为顶端居左
				$pos_x = 10;
				$pos_y = 10;
				break;
			   case 2://2为顶端居中
				$pos_x = ceil(($groundimage_width - $markwidth) / 2);
				$pos_y = 10;
				break;
			   case 3://3为顶端居右
				$pos_x = ceil($groundimage_width - $markwidth - 10);
				$pos_y = 10;
				break;
			   case 4://4为中部居左
				$pos_x = 10;
				$pos_y = ceil(($groundimage_height - $markheight) / 2);
				break;
			   case 5://5为中部居中
				$pos_x = ceil(($groundimage_width - $markwidth) / 2);
				$pos_y = ceil(($groundimage_height - $markheight) / 2);
				break;
			   case 6://6为中部居右
				$pos_x = ceil($groundimage_width - $markwidth - 10);
				$pos_y = ceil(($groundimage_height - $markheight) / 2);
				break;
			   case 7://7为底端居左
				$pos_x = 10;
				$pos_y = ceil($groundimage_height - $markheight);
				break;
			   case 8://8为底端居中
				$pos_x = ceil(($groundimage_width - $markwidth) / 2);
				$pos_y = ceil($groundimage_height - $markheight - 10);
				break;
			   case 9://9为底端居右
				$pos_x = ceil($groundimage_width - $markwidth - 10);
				$pos_y = ceil($groundimage_height - $markheight - 10);
				break;
			   default://默认随机
				$pos_x = rand(0,($groundimage_width - $markwidth - 10));
				$pos_y = rand(0,($groundimage_height - $markheight - 10));
				break; 
		   }
		   //imagecopymerge($from_groundimage, $from_markimage, $pos_x, $pos_y, 0, 0, $markimage_width, $markimage_height,40);
		   @imagecopy($from_groundimage, $from_markimage, $pos_x, $pos_y, 0, 0, $markimage_width, $markimage_height);
		   //拷贝水印到目标文件
	   }
	   else //文字水印
	   {
		   switch($markwhere)
		   {
			   case 0://随机
				$pos_x = mt_rand(10,($groundimage_width - $markwidth - 10));
				$pos_y = mt_rand(10,($groundimage_height - $markheight - 10));
				break;
			   case 1://1为顶端居左
				$pos_x = 10;
				$pos_y = $markheight + 5;
				break;
			   case 2://2为顶端居中
				$pos_x = ($groundimage_width / 2) - ($markwidth / 2);
				$pos_y = $markheight + 5;
				break;
			   case 3://3为顶端居右
				$pos_x = $groundimage_width - $markwidth - 10;
				$pos_y = $markheight + 5;
				break;
			   case 4://4为中部居左
				$pos_x = 10;
				$pos_y = ($groundimage_height / 2) - ($markheight / 2);
				break;
			   case 5://5为中部居中
				$pos_x = ($groundimage_width / 2) - ($markwidth / 2);
				$pos_y = ($groundimage_height / 2) - ($markheight / 2);
				break;
			   case 6://6为中部居右
				$pos_x = $groundimage_width - $markwidth - 10;
				$pos_y = ($groundimage_height / 2) - ($markheight / 2);
				break;
			   case 7://7为底端居左
				$pos_x = 10;
				$pos_y = $groundimage_height - $markheight + 5;
				break;
			   case 8://8为底端居中
				$pos_x = ($groundimage_width / 2) - ($markwidth / 2);
				$pos_y = $groundimage_height - $markheight + 5;
				break;
			   case 9://9为底端居右
				$pos_x = $groundimage_width - $markwidth - 10;
				$pos_y = $groundimage_height - $markheight + 5;
				break;
			   default://默认随机
				$pos_x = mt_rand(10,($groundimage_width - $markwidth - 10));
				$pos_y = mt_rand(10,($groundimage_height - $markheight - 10));
				break; 
		   }
		   
		   //获取水印文字颜色
		   if(!empty($fontcolor) && (strlen($fontcolor) == 7))
		   {
			   $R = hexdec(substr($fontcolor, 1, 2));
			   $G = hexdec(substr($fontcolor, 3, 2));
			   $B = hexdec(substr($fontcolor, 5));
		   }
		   else if(!empty($fontcolor) && (strlen($fontcolor) == 3))
		   {
			   $R = hexdec(substr($fontcolor, 1, 1));
			   $G = hexdec(substr($fontcolor, 2, 2));
			   $B = hexdec(substr($fontcolor, 3, 3));
		   }
		   else
		   {
			   $R = '00';
			   $G = '00';
			   $B = '00';
		   }
		   
		   //转换编码防止中文乱码
		   $marktext = mb_convert_encoding($marktext, 'UTF-8', 'GB2312');
		   //把生成的文字区域写入到图片文件里
		   imagettftext($from_groundimage, $fontsize, 0 , $pos_x, $pos_y, imagecolorallocate($from_groundimage,$R,$G,$B), $fontfamily, $marktext); 
	   }
	   
	   //取得背景图片的格式
	   switch($groundimage_info[2])
	   {
		   case 1:
		     //header('Content-type: image/gif');
		     @imagegif($from_groundimage, $groundimage); //第三个参数为生成带水印的图像质量 100 为最高
		     break;
		   case 2:
			 //header('Content-type: image/jpeg');
			 @imagejpeg($from_groundimage, $groundimage, 100);
			 break;
		   case 3:
			 //header('Content-type: image/png');
			 @imagepng($from_groundimage, $groundimage);
			 break;
		   case 4:
		     //header('Content-type: image/vnd.wap.wbmp');
			 @imagewbmp($from_groundimage, $groundimage);
			 break;
		   default:
		     break;
	   }
	  
	   //释放内存
	   if(isset($markimage_info))   unset($markimage_info);
	   if(isset($groundimage_info)) unset($groundimage_info);
	  
	   //释放与image关联的内存
	   if(isset($from_markimage))   imagedestroy($from_markimage);
	   if(isset($from_groundimage)) imagedestroy($from_groundimage);
	}

/*
    参数说明：
    $im 图片对象，应用函数之前，你需要用imagecreatefromjpeg()读取图片对象，如果PHP环境支持PNG，GIF，也可使用imagecreatefromgif()，imagecreatefrompng()；
    $maxwidth 定义生成图片的最大宽度（单位：像素）
    $maxheight 生成图片的最大高度（单位：像素）
    $name 生成的图片名
    $filetype 最终生成的图片类型（.jpg/.png/.gif）
*/
	public function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
	{
		//读取需要缩放的图片实际宽高
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		
		//通过计算实际图片宽高与需要生成图片的宽高的压缩比例最终得出进行图片缩放是根据宽度还是高度进行缩放，当前程序是根据宽度进行图片缩放。
		if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
		{
			if($maxwidth && $pic_width>$maxwidth)
			{
				$widthratio = $maxwidth/$pic_width;
				$resizewidth_tag = true;
			}
			if($maxheight && $pic_height>$maxheight)
			{
				$heightratio = $maxheight/$pic_height;
				$resizeheight_tag = true;
			}
			if($resizewidth_tag && $resizeheight_tag)
			{
				if($widthratio<$heightratio)//若要依据高度进行图片缩放，可改成$widthratio>$heightratio
                   $ratio = $widthratio;
                else
                   $ratio = $heightratio;
			}
			
			//如果实际图片的长度或者宽度小于规定生成图片的长度或者宽度，则要么根据长度进行图片缩放，要么根据宽度进行图片缩放
			if($resizewidth_tag && !$resizeheight_tag)
				$ratio = $widthratio;
			if($resizeheight_tag && !$resizewidth_tag)
				$ratio = $heightratio;
				
			//计算最终缩放生成的图片长宽
			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;
			
			//据计算出的最终生成图片的长宽改变图片大小，有两种改变图片大小的方法：ImageCopyResized()
			//函数在所有GD版本中有效，但其缩放图像的算法比较粗糙。ImageCopyResamples()，
			//其像素插值算法得到的图像边缘比较平滑，但该函数的速度比ImageCopyResized()慢
			if(function_exists("imagecopyresampled"))
			{
				$newim = imagecreatetruecolor($newwidth,$newheight);
				imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
			}
			else
			{
				$newim = imagecreate($newwidth,$newheight);
				imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
			}
			
			//最终生成经过处理后的图片，如果你需要生成GIF或PNG，你需要将imagejpeg()函数改成imagegif()或imagepng()
			$name = $name.$filetype;
			imagejpeg($newim,$name);
			imagedestroy($newim);
		}
		else
		{
			//如果实际图片的长宽小于规定生成的图片长宽，则保持图片原样，同理
			//如果你需要生成GIF或PNG，你需要将imagejpeg()函数改成imagegif()或imagepng()。
			$name = $name.$filetype;
			imagejpeg($im,$name);
		}
	}


}


?>