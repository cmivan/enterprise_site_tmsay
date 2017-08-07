<?php $this->load->view('public/header');?>
<style type="text/css">
<!--

/*产品页面*/	
#products {
	background-color:#FFF;
	display: block;
	}
#products #pro-nav {
	margin-left:130px;
	background-color:#FFF;
	display: block;
	}
#products #pro-nav .nav-item{
	float:left;
	width:120px;
	background-color:#eee;
	margin-right:2px;
	}
#products #pro-nav .nav-item p {
	background-color:#ccb275;
	padding:0;
	margin:0;
	line-height: 24px;
	}
#products #pro-nav .nav-item p a {
	color:#333;
	display:block;
	padding-left:15px;
	text-decoration:none;
	}
#products #pro-nav .nav-item p a:hover {
	text-decoration:underline;
	}
#products #pro-nav .nav-item ul {
	list-style:none;
	line-height: 20px;
	margin-left:15px;
	margin-bottom:10px;
	}
#products #pro-nav .nav-item ul li {
	list-style:none;
	}
#products #pro-nav .nav-item ul li a {
	color:#8d8d8d;
	text-decoration:none;
	}
#products #pro-nav .nav-item ul li a:hover {
	color:#333;
	text-decoration:underline;
	}
	
#products #pro-content {
	margin-top:20px;
	clear: right;
	}
#products #pro-content ul{
	list-style:none;
	}
#products #pro-content ul li{
	width:273px;
	float:left;
	list-style:none;
	margin-left:15px;
	margin-bottom:20px;
	overflow: hidden;
	height: 320px;
	position:relative;
	}
#products #pro-content ul li .info{
	position:absolute;
	line-height: 20px;
	top: 275px;
	padding-left: 12px;
	padding-right: 12px;
	color:#000;
	}
#products #pro-content ul li .info p{
	padding:0;
	margin:0;
	}
#products #pro-content ul li a{
	width:273px;
	height:270px;
	overflow:hidden;
	display: block;
	}
#products #pro-content ul li a img{
	width:273px;
	}


-->
</style>
<body>

<div id="top">
<div class="main_width">
<div class="container">
  <!--顶部栏目-->
  <?php $this->load->view('public/topnav');?>
  <!-- end .container --></div>
</div>
</div>

<div id="main_body">

<div class="main_width" id="products">
  <div id="pro-nav">
  <?php echo $sBox['p_types_html'];?>
    <div class="clearfloat">&nbsp;</div>
  </div>

  <?php if(!empty($list)){?>

  <div id="pro-content">
  
<div class="content-paging"><?php $this->paging->links(); ?></div>
<div class="clearfloat">&nbsp;</div>
  
      <ul>
<?php foreach($list as $item){
	$view_url = site_url('products/view/'.$item->id);
	$_zwh = orderShowSize($item->size_z,$item->size_w,$item->size_h);
	
	$view_url = 'javascript:void(0);';
	?> 
    <li><a href="<?php echo $view_url;?>" title="朴风堂<?php echo $item->title;?>"><img src="<?php echo $item->pic_s;?>" title="<?php echo $item->title;?>"/></a><div class="info"><p>NO.<?php echo $item->pro_no;?>#</p><p><?php echo $item->title;?> ￥<?php echo $item->price;?></p></div></li>
<?php }?>

      </ul>
      
      <div class="clearfloat">&nbsp;</div>
      <div class="content-paging"><?php $this->paging->links(); ?></div>
      
      <div class="clearfloat">&nbsp;</div>
  </div>
  <?php }?>
  
</div>

</div>

<?php $this->load->view('public/footer');?>
  
</body>
</html>
