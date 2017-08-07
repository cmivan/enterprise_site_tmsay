<?php /*?>网站导航栏<?php */?>
<div class="leftBox">
<p><img src="<?php echo base_url();?>public/images/lnb_campingprogram.gif"/></p>
<?php if(!empty($navOn2)){?>
<ul class="leftNav">
<?php foreach($navOn2 as $item){?>
<li><a title="<?php echo $item->title;?>" href="<?php echo site_url($navOn.'/'.$item->id);?>" <?php if($onId==$item->id){?>class="on"<?php }?> ><span><?php echo $item->title;?></span></a></li>
<?php }?>	
</ul>
<?php }?>
</div>