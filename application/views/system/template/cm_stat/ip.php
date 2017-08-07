<?php
 $this->load->view_system('public/header');?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:100%;">
<tbody><tr><td>

<?php
 $this->load->view_system('template/'.$dbtable.'/nav');?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2 forumtop">
<TBODY>
  <tr class="forumRaw">
    <TD width="13%" align="center">当前在线</TD>
    <TD width="13%" align="center">最高在线人数</TD>
    <TD width="13%" align="center">今日IP</TD>
    <TD width="13%" align="center">今日PV</TD>
    <TD width="26%" align="center">当前时间</TD>
  </TR>
  <tr class="forumRow">
    <TD align="center"><b class="red"><?php
 echo $online_rs['shuon'];?></b>人</TD>
    <TD align="center"><b class="red"><?php
 echo $online_rs['shugo'];?></b></TD>
    <TD align="center"><b class="red"><?php
 echo $online_rs['shuip'];?></b></TD>
    <TD align="center"><b class="red"><?php
 echo $online_rs['shupv'];?></b></TD>
    <TD align="center"><?php
 echo dateTime();?></TD>
  </TR>
</TBODY>
</TABLE>
  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2">
<TBODY>
  <tr class="forumRaw">
  <TD width=4% align="center">ID</TD>
  <TD width=9% align="center">IP</TD>
  <TD width=13% align="center">活跃时间</TD>
  <TD width=13% align="center">操作系统</TD>
  <TD width=13% align="center">浏览器</TD>
  <TD width=22% align="left" style="padding-left:10px;">最后访问位置</TD>
  <TD width=4% align="center">PV</TD>
  </TR>

<?php
 if(!empty($iplist)){?>
<?php
 foreach($iplist as $item){?>
  <tr class="forumRow">
    <TD align="center"><?php
 echo $item->id;?></TD>
    <TD align="center"><?php
 echo $item->ip;?></TD>
    <TD align="center"><?php
 echo $item->lasttime;?></TD>
    <TD align="center"><?php
 echo $item->system;?></TD>
    <TD align="center"><?php
 echo $item->browser;?></TD>
    <TD align="left" style="padding-left:10px;"><?php
 echo $item->url;?></TD>
    <TD align="center"><?php
 echo $item->pv;?></TD>
  </TR>
<?php
 }}?>

</TBODY>
</TABLE>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumbottom">
<tbody><tr class="forumRaw"><td align="center">
<?php $this->paging->links(); ?>
</td></tr></tbody></table>

</td></tr></tbody></table>
</BODY></HTML>
