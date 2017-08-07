<?php $this->load->view_system('public/header');?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1">
<tbody><tr><td>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<tbody><tr class="forumRaw"><td align="center"><?php echo $dbtitle;?> 更新/录入</td>
</tr></tbody></table>

<form class="validform" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2">
<tbody><tr class="forumRow">
    <td align="right">名称：</td><td><input name="title" type="text" id="title" value="<?php echo $rs['title']?>" size="45">
</td></tr>

<tr class="forumRow">
  <td align="right">编号：</td>
  <td><input name="pro_no" type="text" id="pro_no" value="<?php echo $rs['pro_no']?>" size="45">
</td></tr>



    <tr class="forumRow">
        <td align="right">材质：</td>
        <td><input name="material" type="text" id="material" value="<?php echo $rs['material']?>"></td>
      </tr>
<tr class="forumRow">
  <td align="right">规格：</td>
  <td><table border="0" cellpadding="0" cellspacing="1" class="forum2">
    <tr class="forumRow">
        <td width="50" align="center">长度</td>
        <td><input name="size_z" type="text" id="size_z" value="<?php echo $rs['size_z']?>"></td>
        <td width="150" rowspan="3" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">宽度</td>
        <td><input name="size_w" type="text" id="size_w" value="<?php echo $rs['size_w']?>"></td>
        </tr>
      <tr>
        <td align="center">高度</td>
        <td><input name="size_h" type="text" id="size_h" value="<?php echo $rs['size_h']?>"></td>
        </tr>
    </table></td></tr>
    <tr class="forumRow">
        <td align="right">价格：</td>
        <td><input name="price" type="text" id="price" value="<?php echo $rs['price']?>">
          元</td>
      </tr>
    <tr class="forumRow">
        <td align="right">库存：</td>
        <td><input name="price_vip" type="text" id="price_vip" value="<?php echo $rs['price_vip']?>"> <?php echo cm_form_radio('i_type',$i_type,$rs['i_type']);?></td>
    </tr>



<tr class="forumRow"><td align="right">简述：</td><td>
  <?php /*?>编辑器<?php */?>
  <?php echo $this->kindeditor->js('note',$rs['note'],'500px','100px');?>
  
  <?php /*?><br>&nbsp;<span class="red">注：不是必要的，但是适当的描述有利于优化</span><?php */?>
</td></tr>

<tr class="forumRow">
<td align="right">分组：</td><td>
<?php echo cm_form_type_select( $typeB ,$rs['typeB_id'],$rs['typeS_id'] );?>
&nbsp;&nbsp;风格：<?php echo cm_form_type_select( $styleB ,$rs['styles_id'],0,'styles_id');?></td></tr>

<tr class="forumRow">
  <td align="right" style="">效果图(小)：</td>
  <td style="">
  <?php echo $this->kindeditor->up_img('pic_s','pic_s_btu',210,160);?>
  <input name="pic_s" id="pic_s" type="text" value="<?php echo $rs['pic_s']?>" size="45" maxlength="255"><input type="button" value="浏览图片" class="button1" id="pic_s_btu"/>
  &nbsp;&nbsp;宽：210px 高：160px </td></tr>


<tr class="forumRow" style="display:none;">
  <td align="right">效果图(大)：</td>
  <td>
<?php echo $this->kindeditor->up_img('pic_b','pic_b_btu',295,200);?>
<input name="pic_b" id="pic_b" type="text" value="<?php echo $rs['pic_b']?>" size="45" maxlength="255"><input type="button" value="浏览图片" class="button1" id="pic_b_btu"/>
&nbsp;&nbsp;宽：295px 高：200px </td>
</tr>

<tr class="forumRow">
<td align="right" style="">内容：</td><td>
<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->js_full('content',$rs['content'],'98%','350px');?>
</td></tr>

<tr class="forumRow"><td align="right">排序：</td>
<td><input type="text" name="order_id" id="order_id" value="<?php echo $rs['order_id'];?>"></td>
</tr>
<tr class="forumRow">
  <td align="right">设置：</td>
  <td height="24">
  &nbsp;<?php echo cm_form_checkbox('新品','new',$rs['new']);?>
  &nbsp;<?php echo cm_form_checkbox('显示','ok',$rs['ok']);?>
  &nbsp;<?php //echo cm_form_checkbox('热门','hot',$rs['hot']);?>
  <span class="red">(选中后，才在页面上显示)</span>
  </td></tr>

<tr class="forumRaw">
  <td width="88" align="right" valign="top">
    <input name="id" type="hidden" value="<?php echo $rs['id']?>">
    <input name="edit" type="hidden" value="ok">
    </td>
  <td><?php $this->load->view_system('public/submit_btn');?></td>
</tr>

</tbody>
</table>
</form>

</td></tr></tbody></table>
</body></html>