<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>听木说(tmsay.com)</title>
<style type="text/css">
<!--
body {
	font: 12px Verdana, Arial, Helvetica, sans-serif;
	background: #fff;
	margin: 0;
	padding: 0;
	color: #000;
}

/* ~~ 元素/标签选择器 ~~ */
ul, ol, dl { /* 由于浏览器之间的差异，最佳做法是在列表中将填充和边距都设置为零。为了保持一致，您可以在此处指定需要的数值，也可以在列表所包含的列表项（LI、DT 和 DD）中指定需要的数值。请注意，除非编写一个更为具体的选择器，否则您在此处进行的设置将会层叠到 .nav 列表。 */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* 删除上边距可以解决边距会超出其包含的 div 的问题。剩余的下边距可以使 div 与后面的任何元素保持一定距离。 */
	padding-right: 15px;
	padding-left: 15px; /* 向 div 内的元素侧边（而不是 div 自身）添加填充可避免使用任何方框模型数学。此外，也可将具有侧边填充的嵌套 div 用作替代方法。 */
}
img {
	display:block;
	}
a img { /* 此选择器将删除某些浏览器中显示在图像周围的默认蓝色边框（当该图像包含在链接中时） */
	border: none;
}

/* ~~ 站点链接的样式必须保持此顺序，包括用于创建悬停效果的选择器组在内。 ~~ */
a:link {
	color: #42413C;
	text-decoration:none; /* 除非将链接设置成极为独特的外观样式，否则最好提供下划线，以便可从视觉上快速识别 */
}
a:visited {
	color: #6E6C64;
	text-decoration: none;
}
a:hover, a:active, a:focus { /* 此组选择器将为键盘导航者提供与鼠标使用者相同的悬停体验。 */
	text-decoration: underline;
}

/* ~~ 此固定宽度容器包含所有其它 div ~~ */
.container {
	width: 880px;
	margin: 0 auto; /* 侧边的自动值与宽度结合使用，可以将布局居中对齐 */
	overflow: hidden; /* 此声明可使 .container 了解其内部浮动列的结束位置以及包含列的位置 */
}

/* ~~ 以下是此布局的列。 ~~ 

1) 填充只会放置于 div 的顶部和/或底部。此 div 中的元素侧边会有填充。这样，您可以避免使用任何“方框模型数学”。请注意，如果向 div 自身添加任何侧边填充或边框，这些侧边填充或边框将与您定义的宽度相加，得出 *总计* 宽度。您也可以选择删除 div 中的元素的填充，并在该元素中另外放置一个没有任何宽度但具有设计所需填充的 div。

2) 由于这些列均为浮动列，因此未对其指定边距。如果必须添加边距，请避免在浮动方向一侧放置边距（例如：div 中的右边距设置为向右浮动）。在很多情况下，都可以改用填充。对于必须打破此规则的 div，应向该 div 的规则中添加“display:inline”声明，以控制某些版本的 Internet Explorer 会使边距翻倍的错误。

3) 由于可以在一个文档中多次使用类（并且一个元素可以应用多个类），因此已向这些列分配类名，而不是 ID。例如，必要时可堆叠两个侧栏 div。您可以根据个人偏好将这些名称轻松地改为 ID，前提是仅对每个文档使用一次。

4) 如果您更喜欢在右侧（而不是左侧）进行导航，只需使这些列向相反方向浮动（全部向右，而非全部向左），它们将按相反顺序显示。您无需在 HTML 源文件中移动 div。

*/
.header {
	float: left;
	width: 880px;
	padding-bottom: 25px;
	margin-top:30px;
}
.header #logo {
	width:300px;
	height:130px;
	margin-left:290px;
	background-image:url(images/ico.jpg);
	background-position:-30px -32px;
	background-repeat:no-repeat;
	}
.header #logo a{
	float:left;
	overflow:hidden;
	width:300px;
	height:130px;
	text-indent:-2000px;
	}
	
.header #share {
	float:right;
	overflow:hidden;
	width:150px;
	height:28px;
	}
.header #share a{
	float:left;
	overflow:hidden;
	text-indent:-2000px;
	width:28px;
	height:28px;
	margin-right:2px;
	background-image:url(images/ico.jpg);
	}
.header #share a#qq{background-position:-2px 0;}
.header #share a#weibo{background-position:-29px 0;}
.header #share a#weixin{background-position:-54px 0;}
.header #share a#taobao{background-position:-80px 0;}

#top{
	width:100%;
	background-color:#FFF;
	}
#main_body{
	background-image:url(images/bg.jpg);
	background-position:top center;
	}

	
	
	
#footer{
	width:100%;
	height:150px;
	background-color:#FFF;
	}
.main_width{
	width:880px;
	margin:auto;
	display: block;
	}
.content {
	display:none;
	width: 880px;
	float: left;
}

/* ~~ 此分组的选择器为 .content 区域中的列表提供了空间 ~~ */
.content ul, .content ol { 
	padding: 0 15px 15px 40px; /* 此填充反映上述标题和段落规则中的右填充。填充放置于下方可用于间隔列表中其它元素，置于左侧可用于创建缩进。您可以根据需要进行调整。 */
}

/* ~~ 导航列表样式（如果选择使用预先创建的 Spry 等弹出菜单，则可以删除此样式） ~~ */
ul.nav {
	margin:0;
	padding:0;
	float:left;
	width:480px;
	padding-left:213px;
	margin-top:6px;
	list-style: none; /* 这将删除列表标记 */
}
ul.nav li {
	float:left;
	text-align:center;
	font-size:12px;
	border-left:1px solid #CCC;
}
ul.nav a, ul.nav a:visited { /* 对这些选择器进行分组可确保链接即使在访问之后也能保持其按钮外观 */
	padding: 1px 5px 1px 5px;
	display: block; /* 这将为链接赋予块属性，使其填满包含它的整个 LI。这样，整个区域都可以响应鼠标单击操作。 */
	width: 80px;  /*此宽度使整个按钮在 IE6 中可单击。如果您不需要支持 IE6，可以删除它。请用侧栏容器的宽度减去此链接的填充来计算正确的宽度。 */
	text-decoration: none;
}
ul.nav a:hover, ul.nav a:active, ul.nav a:focus { /* 这将更改鼠标和键盘导航的背景和文本颜色 */
	background: #000;
	color: #FFF;
}


/* ~~ 其它浮动/清除类 ~~ */
.fltrt {  /* 此类可用于在页面中使元素向右浮动。浮动元素必须位于其在页面上的相邻元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 此类可用于在页面中使元素向左浮动。浮动元素必须位于其在页面上的相邻元素之前。 */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* 如果从 .container 中删除了 overflow:hidden，则可以将此类放置在 <br /> 或空 div 中，作为 #container 内最后一个浮动 div 之后的最终元素 */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}


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
	}
#products #pro-nav .nav-item ul li a:hover {
	color:#333;
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
	
/*	background-color:#eee;filter:alpha(opacity=80);-moz-opacity:0.80;opacity:0.80;
	-moz-box-shadow: 0 0 10px #999;
	-webkit-box-shadow: 0 0 10px #999;
	box-shadow:0px 10px 20px #000,box-shadow:0 0 100px 50px #fff;*/
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
</style></head>

<body>

<div id="top">
<div class="main_width">
<div class="container">
  <?php include('top.php');?>
  
  <div class="content">
    <h1>&nbsp;</h1>
    <p>请注意，这些布局的 CSS 带有大量注释。如果您的大部分工作都在设计视图中进行，请快速浏览一下代码，获取有关如何使用固定布局 CSS 的提示。您可以先删除这些注释，然后启动您的站点。要了解有关这些 CSS 布局中使用的方法的更多信息，请阅读 Adobe 开发人员中心上的以下文章：<a href="http://www.adobe.com/go/adc_css_layouts">http://www.adobe.com/go/adc_css_layouts</a>。您可以先删除这些注释，然后启动您的站点。若要了解有关这些 CSS 布局中使用的方法的更多信息，请阅读 Adobe 开发人员中心上的以下文章：<a href="http://www.adobe.com/go/adc_css_layouts">http://www.adobe.com/go/adc_css_layouts</a>。</p>
    <h2>清除</h2>
    <p>由于所有列都是浮动的，因此，此布局对 .container 采用 overflow:hidden。此清除方法强制使 .container 了解列的结束位置，以便显示在 .container 中放置的任何边框或背景颜色。如果有任何大型元素突出到 .container 以外，该元素在显示时将被截断。您也不能使用负边距或具有负值的绝对定位将元素拉至 .container 以外，这些元素同样不会在 .container 之外显示。</p>
    <p>如果您需要使用这些属性，则需要采用其它清除方法。最可靠的方法是在最后一个浮动列之后（但在 .container 结束之前）添加 &lt;br class="clearfloat" /&gt; 或 &lt;div class="clearfloat"&gt;&lt;/div&gt;。这具有相同的清除效果。    <!-- end .content --></p>
  </div>

  

  <!-- end .container --></div>
</div>
</div>

<div id="main_body">
<div class="main_width" id="products">
  <div id="pro-nav">
    <div class="nav-item">
      <p><a href="#">竹根鸭系列</a></p>
      <ul>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
      </ul>
    </div>
    <div class="nav-item">
      <p><a href="#">果盘系列</a></p>
      <ul>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
      </ul>
    </div>
    <div class="nav-item">
      <p><a href="#">面具系列</a></p>
      <ul>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
      </ul>
    </div>
    <div class="nav-item">
      <p><a href="#">竹罐系列</a></p>
      <ul>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
      </ul>
    </div>
    <div class="nav-item">
      <p><a href="#">面具系列</a></p>
      <ul>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
        <li><a href="#">111111</a></li>
      </ul>
    </div>
    <div class="clearfloat">&nbsp;</div>
  </div>

  
  <div id="pro-content">
      <ul>
        <li><a href="#"><img src="images/products/彩鸭670-2.jpg"></a><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></li>
        <li><a href="#"><img src="images/products/彩鸭670-3.jpg"></a><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></li>
        <li><a href="#"><img src="images/buy.jpg" width="670" height="285"></a><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></li>
        <li><a href="#"><img src="images/products/彩鸭 670-1.jpg"></a><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></li>
        <li><a href="#"><img src="images/products/描花彩箱 670-1.jpg" height="350"><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></a></li>
        <li><a href="#"><img src="images/products/竹根鸭670.jpg"></a><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></li>
        <li><a href="#"><img src="images/tms_07.jpg" width="880" height="161"></a><div class="info"><p>NO.000555#</p><p>XXXXXXXXX ￥99</p></div></li>
      </ul>
      <div class="clearfloat">&nbsp;</div>
  </div>
  
</div>
</div>

<?php include('footer.php');?>
  
</body>
</html>
