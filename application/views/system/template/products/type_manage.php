<?php
 $this->load->view_system('public/header');?>
<script language="javascript">
$(function(){
	$('.order_btu').click(function(){
		var cmd = $(this).attr('cmd');
		var type_id = $(this).attr('type_id');
		$('#cmd').val(cmd);
		$('#type_id').val(type_id);
		$(this).parents().find('.validform').submit();
		return false;
      });
  });
</script>
</head>
<body>
<br />
<form class="validform" method="post">
<input type="hidden" name="cmd" id="cmd" />
<input type="hidden" name="type_id" id="type_id" />
<input type="hidden" name="go" id="go" value="yes" />
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:500px;"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">
  <a href="<?php echo site_system($dbtable.'/type_edit')?>">
  <img src="<?php echo site_url_fix($style['css_url'].'system_theme/ico/tree_explode','gif');?>" alt="添加分类" border="0" align="absmiddle" />
    添加 <span class="red"><?php echo $dbtitle;?></span> 类别
  </a></td>
<td width="40" align="center">排序</td>
<td width="120" align="center" class="edit_box_edit_td">操作</td></tr>
<?php

if(!empty($typeB)){
	foreach($typeB as $rs){
?>
<tr class="forumRow">
<td width="25" align="center"><img src="<?php echo site_url_fix($style['css_url'].'system_theme/ico/dir','gif');?>" border="0" />
</td><td class="td_padding">&nbsp;&nbsp;<?php echo $rs['type_title'];?><span>(Id:<?php echo $rs['type_id'];?>)</span>
</td><td width="40" align="center">
<a href="javascript:void(0);" class="order_btu" cmd="up" type_id="<?php echo $rs['type_id'];?>">
<img src="<?php echo site_url_fix($style['css_url'].'system_theme/ico/up_ico','gif');?>" border="0" /></a>
<a href="javascript:void(0);" class="order_btu" cmd="down" type_id="<?php echo $rs['type_id'];?>">
<img src="<?php echo site_url_fix($style['css_url'].'system_theme/ico/down_ico','gif');?>" border="0" /></a>
</td>
<td align="center"><input type="button" class="btu_del btu" url='<?php echo reUrl('del_id='.$rs['type_id'])?>' title='<?php echo $rs['type_title'];?>' tip='确定删除该大类？' value="&nbsp;" />  <input type="button" class="btu_edit btu" url='<?php echo site_system($dbtable.'/type_edit')?><?php echo reUrl('id='.$rs['type_id'])?>' value="&nbsp;"/>
</td>
</tr>

<?php

//小分类
if( !empty($rs['type_ids']) )
{
	$type_ids = $rs['type_ids'];
	foreach($type_ids as $rsS)
	{
?>
<tr class="forumRow">
<td width="25" align="center"><img src="<?php echo site_url_fix($style['css_url'].'system_theme/ico/type_ico','gif');?>" border="0" />
</td><td class="td_padding">&nbsp;&nbsp;<?php echo $rsS['type_title'];?><span>(Id:<?php echo $rsS['type_id'];?>)</span>
</td><td width="40" align="center">&nbsp;</td>
<td align="center">
<input type="button" class="btu_del btu" url='<?php echo reUrl('del_id='.$rsS['type_id'])?>' title='<?php echo $rsS['type_title'];?>' tip='确定删除该小类？' value="&nbsp;" />
<input type="button" class="btu_edit btu" url='<?php echo site_system($dbtable.'/type_edit')?><?php echo reUrl('id='.$rsS['type_id'])?>' value="&nbsp;"/>
</td>
</tr>
<?php

	}
}
?>


<?php }}?>

</table></td></tr></table>
</form>
</body>
</html>