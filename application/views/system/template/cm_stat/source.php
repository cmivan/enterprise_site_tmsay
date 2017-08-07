<?php
 $this->load->view_system('public/header');?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:100%;">
<tbody><tr><td>

<?php
 $this->load->view_system('template/'.$dbtable.'/nav');?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="forum2">
  <TBODY>
  <tr class="forumRaw">
  <TD width=40 align="center">ID</TD>
  <TD align="left" style="padding-left:10px;">访问来源</TD>
  <TD style="padding-left:10px;">来源页面</TD>
  <TD width=60 align="center">点击数</TD>
  </TR>

<?php
 if(!empty($urls)){?>
<?php
 foreach($urls as $item){?>
  <tr class="forumRow">
    <TD align="center"><?php
 echo $item->id;?></TD>
    <TD align="left" style="padding-left:10px;">
	<?php
 echo $item->vcome;?></TD>
    <TD style="padding-left:10px;"><a href="<?php
 echo $item->vlast;?>" target="_blank"><?php
 echo $item->vlast;?></a>
    </TD>
    <TD align="center"><?php
 echo $item->num;?></TD>
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
