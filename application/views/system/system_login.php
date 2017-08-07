<?php

//-=================================================-
//-====  |       伊凡php建站系统 v1.0           | ====-
//-====  |       Author : cm.ivan             | ====-
//-====  |       QQ     : 394716221           | ====-
//-====  |       Time   : 2011-04-02 11:00    | ====-
//-====  |       For    : 齐翔广告             | ====-
//-=================================================-
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="cm.ivan@163.com"/>
<link rel="shortcut icon" href="/favicon.ico" />
<script type="text/javascript">
var base_url='<?php echo base_url()?>';var img_url ='<?php echo $style['img_url']?>';var js_url='<?php echo $style['js_url']?>';
</script>

<?php
 /*?>Jq 框架<?php
 */?>
<script type="text/javascript" src="<?php echo $style['jq_url']?>"></script>
<script type="text/javascript" src="<?php echo $style['js_url']?>validform/js/validform.js"></script>
<?php $this->load->view('public/validform'); ?>

<script type="text/javascript">
var codeHTML = '<img alt="点击刷新" border="0" align="absmiddle" class="code_img" id="verifycode" src="<?php echo site_system('system_login/verifycode');?>" />';

$(function(){
	$('#user_name').focus();
	$('#code').html(codeHTML);
	$('#verifycode').live('click',function(){ $('#code').html(codeHTML); });
	});
</script>

<link href="<?php echo $style['css_url']?>system_theme/style/login_style.css" rel="stylesheet" type="text/css" />
<?php if( $css_helper ){?>
<link href="../../../public/style/system_theme/style/login_style.css" rel="stylesheet" type="text/css" />
<?php }?>

</head>
<body leftMargin=0 topMargin=0 rightMargin=0 style="overflow:hidden">

<div class="main">
<div class="title">管理登陆</div>
<div class="login">
  <form name="log_in" class="validform" method="post">
    <div class="login">
      <div class="inputbox">
        <dl>
          <dt>账号：</dt>
          <dd>
            <input type="text" name="user" id="user" size="20" onfocus="this.style.borderColor='#F93'" onblur="this.style.borderColor='#888'" />
          </dd>
        </dl>
        <dl>
          <dt>密码：</dt>
          <dd>
            <input type="password" name="pass" size="20" onfocus="this.style.borderColor='#F93'" onblur="this.style.borderColor='#888'" id="pass" />
          </dd>
        </dl>
        <dl>
          <dt>验证码：</dt>
          <dd>
            <input style="width:65px;" name="code" type="text" maxlength="5" size="20"/><a href="javascript:void(0);" id="code"></a>
          </dd>
        </dl>
      </div>
      <div class="butbox">
        <dl><dt><input name="submit" type="submit" value=" "/></dt></dl>
      </div>
    </div>
  </form>
</div>
<div class="clear"></div>
</div>


<div class="copyright">
Powered by <?php
 echo $cm_pro['author'];?>&nbsp;<span class="versions">v<?php
 echo $cm_pro['version'];?></span>
<?php
 /*?><span class="TJbox">&nbsp;|&nbsp;<script src="http://s11.cnzz.com/stat.php?id=2058869&web_id=2058869" language="JavaScript"></script></span><?php
 */?>
</div>

</body></html>