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
<div class="main_width" id="pageContent"><img src="<?php echo base_url();?>public/images/pages/tms_07.jpg" width="880" height="500"></div>
</div>

<?php $this->load->view('public/footer');?>
  
</body>
</html>
