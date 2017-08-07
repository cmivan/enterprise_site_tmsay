<?php
/*
 * 表单
 */
if(!empty($formTO))
{
  $tourl = $formTO->url;
  $backurl = $formTO->backurl;
  if(!empty($tourl)){ $tourl = site_url($tourl); }
  if(!empty($backurl)&&$backurl!=''&&$backurl!='null'){$backurl = site_url($backurl).reUrl('v=null');}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $style['js_url'];?>validform/css/css.css" />
<script language="javascript" type="text/javascript" src="<?php echo $style['js_url'];?>mod_validform.js"></script>
<script language="javascript" type="text/javascript"> $(function(){formTO('<?php echo $tourl?>','<?php echo $backurl?>');}); </script>
<?php }?>