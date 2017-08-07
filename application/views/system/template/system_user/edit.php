<?php
 $this->load->view_system('public/header');?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:550px;">
<tbody><tr><td>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<tbody><tr class="forumRaw"><td align="center"><?php
 echo $dbtitle;?> 更新/录入</td>
</tr></tbody></table>

<form class="validform" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2">
<tbody>
<tr class="forumRow">
<td align="right">帐号：</td><td><input name="username" type="text" id="username" value="<?php
 echo $rs['username']?>" size="45">
</td></tr>

<tr class="forumRow">
<td align="right">密码：</td>
<td><input name="password" type="text" id="password" value="" size="45">
</td></tr>

<tr class="forumRow">
<td align="right">确认密码：</td>
<td><input name="password2" type="text" id="password2" value="" size="45">
</td></tr>

<?php
 if( $rs['id'] != $logid && $super==1 ){?>
<tr class="forumRow">
  <td align="right">设置：</td>
  <td height="24">
  &nbsp;<?php
 echo cm_form_checkbox('高级管理','super',$rs['super']);?>&nbsp;
  &nbsp;<?php
 echo cm_form_checkbox('封锁','ok',$rs['ok']);?>&nbsp;
  ( <span class="red">打上勾后，这个用户就不能登录了</span> )
</td></tr>
<?php
 }?>

<tr class="forumRow">
<td align="right">简述：</td><td><textarea name="note" cols="60" rows="4" id="note" style="width:350px"><?php
 echo $rs['note'];?></textarea></td></tr>

<tr class="forumRaw">
  <td width="88" align="right" valign="top">
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

</td></tr></tbody></table>
</body></html>