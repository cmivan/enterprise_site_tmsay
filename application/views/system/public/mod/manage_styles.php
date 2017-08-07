<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow">
<TD colspan="3" align="left">
&nbsp;风格<img src="<?php echo $style['css_url'];?>system_theme/ico/type_ico2.gif" width="12" height="12" /> | <a href="<?php echo reUrl('styles_id=null',1);?>"><strong>&nbsp;全部&nbsp;</strong></a>
<?php

$css = ' style="font-weight:bold;color:#FF0000;"';
if( !empty($styleB) )
{
	foreach( $styleB as $B)
	{
		$s = '';
		if( $styles_id == $B['type_id'] ){$s = $css;}else{$s = '';}
		?>|<a href="<?php echo reUrl('styles_id='.$B['type_id']);?>" <?php echo $s?>>&nbsp;&nbsp;<?php echo $B['type_title'];?>&nbsp;&nbsp;</a><?php
    }
}
?>
</td></TR>
</TABLE>