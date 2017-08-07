<?php
 $this->load->view_system('public/header');?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1">
<tbody><tr><td>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<form name="search" method="get">
<tbody><tr class="forumRaw"><td width="100%" align="center" class="mainTitle"><?php
 echo $dbtitle;?>列表</td>
<td align="center">
<table border="0" cellpadding="0" cellspacing="0" class="forum2">
<tbody><tr class="forumRaw2"><td><input name="keyword" value="<?php
 echo $keyword;?>" type="text" id="keyword" style="font-size: 9pt" size="25"></td>
<td align="center">
<input name="submit" type="submit" value="搜索<?php
 echo $dbtitle;?>" align="absMiddle" class="button">
</td></tr></tbody></table></td></tr></tbody>
</form>
</table>

<?php $this->load->view_system('public/mod/manage_type');?>

<?php $this->load->view_system('public/mod/manage_styles');?>

<form name="manage_box" method="post">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tbody><tr class="forumRaw">
<td colspan="2" align="center">ID</td>
<td width="80" align="center">效果图</td>
<td>&nbsp;名称\标题</td>
<td align="center">编号</td>
<td width="50" align="center">价格</td>
<td width="86" align="center">库存</td>
<td width="40" align="center">新品</td>
<td width="40" align="center">显示</td>
<td width="130" align="center">修改操作</td></tr>

<?php

if(!empty($list)){
	foreach($list as $item){
?>
<tr class="forumRow">
<td width="30" align="center"><?php
 echo $item->id;?></td>
<td width="30" align="center"><input name="id[]" type="checkbox" class="delitem" value="<?php
 echo $item->id;?>" /></td>
<td width="80" align="center">&nbsp;<a href="<?php
 echo $item->pic_s;?>" target="_blank"><img src="<?php
 echo $item->pic_s;?>"  width="30"/></a></td>
<td>&nbsp;<?php
 echo keycolor($item->title,$keyword);?></td>
<td align="center"><?php
 echo $item->pro_no;?></td>
<td align="center">
<div class="s1"><?php
 echo $item->price;?></div>
</td>

<td align="center">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="60" align="center" class="changeObj">
<div class="s1"><?php
 echo $item->price_vip;?></div>
<div class="s2"><?php
 echo getInput('price_vip', $item->id);?></div>
    </td>
    <td width="26" align="center"><?php
 echo $item->i_title;?></td>
    </tr>
  </table>
</td>
<td width="19" align="center"><?php
 echo cm_form_check('new',$item->id,$item->new);?></td>
<td width="20" align="center"><?php
 echo cm_form_check('ok',$item->id,$item->ok);?></td>
<td align="center">
  <input type="button" class="btu_del btu" value="&nbsp;" url="<?php echo reUrl('cmd=del&id='.$item->id);?>" tip="删除该项信息" />
  <input type="button" class="btu_edit btu" value="&nbsp;" url="<?php echo site_system($dbtable.'/edit').reUrl('cmd=null&id='.$item->id);?>"/>
</td></tr>
<?php }?>

<tr class="forumRaw">
<td width="30" align="center">&nbsp;</td>
<td width="30" align="center"><input type="checkbox" id="delsel" /></td>
<td colspan="5">
<table border="0" cellpadding="0" cellspacing="0">
<tr class="forumRaw2"><td>
<select name="cmd" id="cmd">
<option value="">请选择...</option>
<option value="del">删除&nbsp;&times;</option>
<option value="move">转移到&gt;&gt;</option>
<optgroup label="显示或隐藏">
<option value="show">显示&nbsp;&radic;</option>
<option value="hide">隐藏&nbsp;&times;</option>
</optgroup>
</select>

<?php
 echo cm_form_type_select( $typeB );?>

<input id="go_batch" type="submit" name="Submit" value="执行批操作" class="button" /></td>
</tr></table>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<?php }else{?>
<tr class="forumRow">
<td colspan="10" align="center"><span class="red">没有找到相应的信息</span></td>
</tr>
<?php }?>

</tbody></table>
</form>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumbottom">
<tbody><tr class="forumRaw"><td align="center">
<?php $this->paging->links(); ?>
</td></tr></tbody></table>
</td></tr></tbody></table>


<script language="javascript">
$(function(){
	//********************************
	//*** 20130626,by cm,For 修改库存等
	  ChangeObj( $('.forum2').find('.changeObj') );
	//********************************
	function ChangeObj($obj){
		var $objbox = $obj.parent().parent().parent();
		var $objrun = $objbox.attr('running');
		if($objrun!=='yes'&&$objrun!=='no'){ $objbox.attr('running','no'); }
		
		$obj.hover(
			function(){
				var $objrun = $objbox.attr('running');
				if($objrun==='no'){
					var _inputObj = $(this).find('.s2').find('input');
					var _s1val = $(this).find('.s1').html();
					_inputObj.val(_s1val);
					
					var _val = _inputObj.val();
					_inputObj.attr('val',_val);
					
					$(this).find('.s1').fadeOut(0);
					$(this).find('.s2').fadeIn(0);
				}
				},
			function(){
				var $objrun = $objbox.attr('running');
				if($objrun==='no'){
					var _inputObj = $(this).find('.s2').find('input');
					var _val = _inputObj.val();
					var val = _inputObj.attr('val');
					var key = _inputObj.attr('key');
					var _this = $(this);
					
					var name = _inputObj.attr('name');
					var nameMD5 = _inputObj.attr('nameMD5');
					
					//要更新的数据
					var _data = {'key':key,'name':name,'nameMD5':nameMD5,'val':_val};
					
						if(_val!=''&&_val!==val&&key==parseInt(key)){
							$objbox.attr('running','yes');
							$(this).find('.s2').fadeOut(0);
							//显示加载
							$(this).find('.s1').html('<img src="/public/style/system_theme/ico/loading.gif" width="10" height="10"/>').fadeIn(0);
							//提交数据
							$.ajax({
								   type:'POST',
								   url:'<?php
 echo site_system('products/changeobj');?>',
								   data:_data,
								   success:function(){
									   //显示新数据
									   $objbox.attr('running','no');
									   setTimeout(function(){ _this.find('.s1').html(_val); },500);
								   },
								   error: function(XMLHttpRequest, textStatus, errorThrown){
									   $objbox.attr('running','no');
									   setTimeout(function(){ _this.find('.s1').html(_val); },500);
								   }
							});
						}else{
							//无修改,直接显示
							$(this).find('.s2').fadeOut(0);
							$(this).find('.s1').fadeIn(0);
						}
					}
				}
		);
    }
});
</script>

</body></html>