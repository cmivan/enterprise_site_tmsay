<?php $this->load->view('public/header');?>
<link href="<?php echo base_url();?>public/style/products.css" rel="stylesheet" type="text/css">
<!-- BEGIN body -->
<body class="page page-template page-template-template-portfolio-php ie layout-2cr">

	<!-- BEGIN #container -->
	<div id="container">
	
		<!-- BEGIN #header -->
		<?php $this->load->view('public/top');?>
		<!--BEGIN #content -->
		<div id="content" class="clearfix">

            <div class="page-title">艺术木境&nbsp;-&nbsp;意象随形</div>
            <div class="clear"></div>

            <!--BEGIN #recent-portfolio  .home-recent -->
            <div id="recent-portfolio" class="home-recent portfolio-recent clearfix">
            	
<!--BEGIN .sidebar -->
<div class="sidebar sidebarTop">
  <?php $this->load->view('public/left');?>
  <!--END .sidebar -->
</div>
                                
<!--BEGIN .recent-wrap -->
<div class="recent-wrap wrapTop">

<div class="content-text">

<div class="content-where">
<?php echo $site['where'];?>
：
<?php echo getnav($nav,'index', $site['sitename'] );?>
 / 
<?php echo getnav($nav,'products');?>
 / 
<a href="<?php echo site_url('products/view/'.$view->id);?>"><?php echo $view->title;?></a>
</div>

<div class="content-text-note">
    <h1><?php echo $view->title;?></h1>
    <div style="width:300px; float:left;">
        <div style="line-height:180%; padding-top:15px;">
        <div>材质：<?php echo $view->material;?></div>
        <div>尺寸：<?php echo orderShowSize($view->size_z,$view->size_w,$view->size_h);?> ( 长、宽、高 )</div>
        <?php if( $super===1 ){ /*$super===1 表示只有经销商可以看到，其他人都看不到*/ ?>
        <div>价格：<strong><?php echo $view->price;?></strong> 元</div>
        <div>库存：<strong><?php echo $view->price_vip;?></strong> <?php echo $view->i_title;?></div>
        <?php }?>
		<div>简述：<?php echo $view->note;?></div>
        </div>
    </div>
    
    <div class="pro-view-btn">
       <div class="btn-buy"><a href="javascript:void(0);" class="buy-car" id="buy-car" pid="<?php echo $view->id;?>" md5="<?php echo pass_key($view->id);?>">加入购物车</a><span id="buy-car-disabled">加入购物车</span><a href="<?php echo site_url('orders/car');?>" id="buy-order">查看订单</a></div>
       <?php if(!empty($viewlike)){?>
       <div class="clear">&nbsp;</div>
       <div class="btn-like">
       <p>系列产品缩略图：</p>
        <ul>
<?php foreach($viewlike as $vitem){?>
<li<?php if($vitem->id==$view->id){?> class="on"<?php }?>><a href="<?php echo site_url('products/view/'.$vitem->id);?>"><img src="<?php echo $vitem->pic_s;?>" width="50" /></a></li>
<?php }?>
        </ul>
       </div>
       <?php }?>
    </div>
    <div class="clear">&nbsp;</div>
</div>
<div class="content-view"><?php echo $view->content;?></div>
</div>                     

<!--END .recent-wrap -->
</div>
<!--END #recent-portfolio .home-recent -->
</div>
<!-- END #content -->
</div>
<!-- END #container -->
</div> 	
    
<!-- BEGIN #footer-container -->
<?php $this->load->view('public/footer');?>

<link href="<?php echo base_url();?>public/js/shopCar/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>public/js/shopCar/cm.shop.car.js"></script>
<script type="text/javascript">	
  var $CAR = {},$PRO = {};
  $CAR = {'md5':null,'num':null,'lists':null,'keys':null};
  $PRO = {'pid':'<?php echo $view->id;?>','md5':'<?php echo pass_key($view->id);?>'};
  //************************
  $(function(){
  var CAR = new orderCar();
  CAR.carCreate();
  CAR.carUpdate();
  });
</script>

<!--END body-->
</body>
<!--END html-->
</html>