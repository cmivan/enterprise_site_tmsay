<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="author" content="cm.ivan@163.com"/>
<link rel="shortcut icon" href="/favicon.ico" />
<script type="text/javascript">
var base_url='<?php echo base_url()?>';
var img_url ='<?php echo $style['img_url']?>';
var js_url='<?php echo $style['js_url']?>';
</script>
<?php /*?>Jq 框架<?php */?>
<script type="text/javascript" src="<?php echo $style['jq_url'];?>"></script>
<script type="text/javascript" src="<?php echo $style['js_url'];?>validform/js/validform.js"></script>
<script type="text/javascript" src="<?php echo $style['css_url'];?>system_theme/style/jquery.edit.style.js"></script>
<?php /*?>全局样式及JS<?php */?>
<link href="<?php echo $style['css_url'];?>system_theme/style/style.css" rel="stylesheet" type="text/css">
<?php $this->load->view('public/validform'); ?>

<title><?php echo $cm_pro['name'];?> v<?php echo $cm_pro['version'];?> By:<?php echo $cm_pro['author'];?></title>