<?php $this->load->view('public/header');?>

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
<div class="main_width" id="pageContent"><?php if(!empty($view)){ echo $view->content; };?></div>
</div>

<?php $this->load->view('public/footer');?>
  
</body>
</html>