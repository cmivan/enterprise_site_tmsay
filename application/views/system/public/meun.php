<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php
 echo $cm_pro['name'];?> v<?php
 echo $cm_pro['version'];?> By:<?php
 echo $cm_pro['author'];?></title>
<link href="<?php echo $style['css_url'];?>system_theme/style/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?php echo $style['css_url'];?>system_theme/style/jquery.1.4.js"></script>
<script language="javascript" src="<?php echo $style['css_url'];?>system_theme/style/jquery.edit.style.js"></script>
<script language="javascript">
$(function(){
	$(".menu").find("dl").find("dt").find("a").click(function(){
		$(this).parent().parent().parent().find("dd").css({"display":"none"});
		$(this).parent().parent().find("dd").css({"display":"block"});
	});
	$(".menu").find("dl").eq(0).find("dd").css({"display":"block"});
});
</script>
<style type="text/css">
*{margin:0px;}
body{
	background-color:#9E9C92;
	background-image:url(<?php echo $style['css_url'];?>system_theme/left_top_bg.gif);
	background-position:left top;background-repeat:repeat-y;overflow-x:hidden;
}
</style>
<base target="main">
</head>


<body>
<div class="menu">
<!-- Item Strat -->
<dl>
<dt><a href="javascript:void(0);">网站信息</a></dt>
<dd style="display: none; "><ul>
<li><a target="main" href="<?php echo site_system('system_user/index');?>">管理员管理</a></li>
<li><a target="main" href="<?php echo site_system('system_user/edit');?>">添加管理员</a></li>
<?php /*?><li><a target="main" href="<?php echo site_system('cm_stat/index');?>">访问统计</a></li><?php */?>
</ul></dd></dl>

<!-- Item Strat -->   
<?php if(!empty($nav)){?>
<?php foreach($nav as $key=>$val){?>   
<dl>
<dt><a href="javascript:void(0);"><?php echo $val;?></a></dt>
<dd style="display: none; "><ul>
<li><a target="main" href="<?php echo site_system($key.'/manage');?>">管理 <?php echo $val;?></a></li>
<li><a target="main" href="<?php echo site_system($key.'/edit');?>">添加 <?php echo $val;?></a></li>
</ul></dd></dl>
<?php }?>
<?php }?>


<dl class="copyright">
<dt><a>版权信息</a></dt><dd style="display: none; "><ul>
<li>
<a href="http://www.qxad.com/" target="_blank" style=" color:#333333;line-height:20px;padding:3px; padding-left:12px; margin:0; text-indent:0; background:none; border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; width:136px;">开发：齐翔<br>联系：cm.ivan@163.com<br>官网：齐翔广告<br></a>
</li>
</ul></dd></dl>


<dl>
<dt><a href="<?php echo site_system('system_defaults/out');?>" target="_top">退出管理</a></dt></dl>
<!-- Item End -->
</div>

</body></html>