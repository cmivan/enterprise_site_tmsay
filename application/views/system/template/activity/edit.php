<?php
 $this->load->view_system('public/header');?>
<link href="<?php
 echo base_url();?>public/plugins/kindeditor/themes/default/default.css" rel="stylesheet">
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1">
<tbody><tr><td>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<tbody><tr class="forumRaw"><td align="center"><?php
 echo $dbtitle;?> 更新/录入</td>
</tr></tbody></table>

<form class="validform" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<tbody><tr class="forumRow"><td width="100" align="right">标题：</td><td><input name="title" type="text" id="title" value="<?php
 echo $rs['title']?>" size="45">
</td></tr>

<tr class="forumRow">
<td align="right" style="">活动中心图：</td>
<td style="">
<?php echo $this->kindeditor->up_img('pic_s','pic_s_btu',800,600);?>
<input readonly name="pic_s" id="pic_s" type="text" value="<?php
 echo $rs['pic_s']?>" size="45" maxlength="255"><input type="button" value="浏览图片" class="button1" id="pic_s_btu"/>
&nbsp;&nbsp;宽：800px 高：600px </td></tr>


<tr class="forumRow">
  <td align="right">链接地址：</td>
  <td>
<input name="toUrl" id="toUrl" type="text" value="<?php
 echo $rs['toUrl']?>" size="45" maxlength="255"> 
<span class="red">(可以添加新闻或者产品链接)</span></td>
</tr>

<tr class="forumRaw">
  <td width="100" align="right" valign="top">
    <input name="id" type="hidden" value="<?php
 echo $rs['id']?>">
    <input name="edit" type="hidden" value="ok">
    </td>
  <td><?php
 $this->load->view_system('public/submit_btn');?></td>
</tr>

</tbody>
</table>
</form>

<?php
 if(!empty($rs)){?>
<?php
 if(is_num($rs['id'])){?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<tbody><tr class="forumRaw">
  <td align="center">当前Banner效果预览</td>
</tr>
  <tr class="forumRow">
    <td align="center" style="padding:10px;"><a href="<?php echo $rs['toUrl'];?>" target="_blank"><img src="<?php echo $rs['pic_s'];?>" width="100%" title="<?php echo $rs['title'];?>"/></a>
    </td>
  </tr>
</tbody>
</table>
<?php
 }?>
<?php
 }?>
</td></tr></tbody></table>
</body></html>