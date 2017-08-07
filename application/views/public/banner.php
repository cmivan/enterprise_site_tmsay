<?php
 if(!empty($banner)){?>
<div id="slider" class="clearfix">
<!--BEGIN .slides_container -->
<div class="slides_container">
<?php

$Bi = 0;
foreach($banner as $item){
	$Bi++;
	if(!empty($item->toUrl)){
?>
<div><a href="<?php
 echo $item->toUrl;?>" target="_blank"><img src="<?php
 echo $item->pic_s;?>" alt="<?php
 echo $item->title;?>" name="slider-image-<?php
 echo $Bi;?>" width="940" height="350" id="slider-image-<?php
 echo $Bi;?>" title="<?php
 echo $item->title;?>" /></a></div>
<?php
 }else{?>
<div><img src="<?php
 echo $item->pic_s;?>" alt="<?php
 echo $item->title;?>" name="slider-image-<?php
 echo $Bi;?>" width="940" height="350" id="slider-image-<?php
 echo $Bi;?>" title="<?php
 echo $item->title;?>" /></div>
<?php
 }}?>

<!--END .slides_container -->
</div>
<!--BEGIN .slides-nav -->
<div class="slides-nav"><a href="javascript:void(0);" class="prev">Previous Slide</a><a href="javascript:void(0);" class="next">Next Slide</a><!--END .slides-nav --></div>
<!--BEGIN .pagination -->
<ul class="pagination"><?php
 for($BBi=1;$BBi<=$Bi;$BBi++){?><li><a href="javascript:void(0);"></a></li><?php
 }?><!--END .pagination --></ul><!--END #home-slider -->
</div>

<?php
 }?>