<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php
 echo $cm_pro['name'];?> v<?php
 echo $cm_pro['version'];?> By:<?php
 echo $cm_pro['author'];?></title>
</head>
<frameset rows="80,*" cols="*" frameborder="no" border="0" framespacing="0">
<frame src="<?php echo site_system('system_defaults/top');?>" name="topFrame" id="topFrame" scrolling="no" noresize="">
<frameset rows="15,*,15" cols="*" frameborder="no" border="0" framespacing="0">
<frame src="<?php echo site_system('system_defaults/body_top');?>" name="topFrame" id="topFrame" scrolling="no" noresize="">
<frameset cols="172,*" name="bodyFrame" id="bodyFrame" frameborder="no" border="0" framespacing="0">
<frame src="<?php echo site_system('system_defaults/meun');?>" name="menu" id="menu" scrolling="auto" noresize="">
<frame src="<?php echo site_system('about/manage');?>" name="main" id="main" scrolling="auto" noresize="">
</frameset>
<frame src="<?php echo site_system('system_defaults/body_footer');?>" name="topFrame" id="topFrame" scrolling="no" noresize="">
</frameset>
</frameset>
<noframes>&lt;body&gt;你的浏览器不支持框架！&lt;/body&gt;</noframes>
</html>