<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow">
<TD colspan="3" align="left">
&nbsp;分类<img src="<?php echo $style['css_url'];?>system_theme/ico/type_ico2.gif" width="12" height="12" /> | <a href="<?php echo reUrl('typeb_id=null',1);?>"><strong>&nbsp;全部&nbsp;</strong></a>
<?php

$css = ' style="font-weight:bold;color:#FF0000;"';
if( !empty($typeB) )
{
	foreach( $typeB as $B)
	{
		$s = '';
		if( $typeB_id == $B['type_id'] ){$s = $css;}else{$s = '';}
		?>|<a href="<?php echo reUrl('typeb_id='.$B['type_id'].'&types_id=null&page=null');?>" <?php echo $s?>>&nbsp;&nbsp;<?php echo $B['type_title'];?>&nbsp;&nbsp;</a><?php
    }
}
?>
</td></TR>
<?php
 if( !empty($typeS) ){?>
<TR class="forumRow"><TD colspan="3" align="left" style="padding-left:48px;">
<?php

	foreach( $typeS as $S)
	{
		if( $typeS_id == $S['type_id'] ){$s = $css;}else{$s = '';}
		?>|<a href="<?php echo reUrl('types_id='.$S['type_id'].'&page=null');?>" <?php echo $s?>>&nbsp;&nbsp;<?php echo $S['type_title'];?>&nbsp;&nbsp;</a><?php
    }
?>
</td></TR>
<?php
 }?>
</TABLE>