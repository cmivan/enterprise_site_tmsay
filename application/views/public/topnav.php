<?php /*?>网站导航栏<?php */?>
<div class="header">
<div id="logo"><a href="<?php echo site_url('index');?>">白水一墨的标识</a></div>
<div class="clearfloat"></div>

    <?php if(!empty($navAll)){?>
    <ul class="nav">
	<?php foreach($navAll as $key=>$val){?><li><a href="<?php echo site_url($key);?>" <?php if($navOn==$key){?>class="on"<?php }?>><?php echo $val;?></a></li><?php }?>
    </ul>
    <?php }?>
    
    <div id="share">
    <a href="#" id="qq">分享到QQ</a>
    <a href="#" id="weibo">分享到新浪微博</a>
    <a href="#" id="weixin">分享到微信</a>
    <a href="#" id="taobao">分享到淘宝</a>
    </div>
    
    <!-- end .header --></div>