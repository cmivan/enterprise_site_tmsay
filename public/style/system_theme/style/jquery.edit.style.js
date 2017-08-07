//定义鼠标移过样式
$(function(){
  $("tr.forumRow").hover(
		function(){$(this).find("td").css({"background-color":"#fff"});},
		function(){$(this).find("td").css({"background-color":""});}
		);
  
  $(".btu").click(function(){
	  var url = $(this).attr('url');
	  var tip = $(this).attr('tip');
	  if(tip!='' && tip!='undefined' && tip!=null){
		  if( confirm(tip) ){ window.location.href = url; }
	  }else{
		  window.location.href = url;
	  }
	  return false;
  });
  $(".btu2").dblclick(function(){
	  var url = $(this).attr('url');
	  var tip = $(this).attr('tip');
	  if(tip!='' && tip!='undefined' && tip!=null){
		  if( confirm(tip) ){ window.location.href = url; }
	  }else{
		  window.location.href = url;
	  }
	  return false;
  });

//全选或取消列表项
  $("#delsel").click(function(){
	 var thischeck = $(this).attr("checked");
	 if(thischeck!='checked'){
		 $(".delitem").attr("checked",false);
	 }else{
		 $(".delitem").attr("checked",'checked');
	 }
  });

  $("#go_batch").click(function(){
	  if( ischecked() ){
		 if(confirm("确定要执行操作?")){ return true; }else{ return false; }
	  }else{
		 return false;
	  }
  });
  
  $("#edit_back").click(function(){ history.back(1); });
  
  //绑定图片预览框
  view_img_btu('pic_b');
  view_img_btu('pic_s');
  view_img_btu('type_pic');
});


//图片预览
function view_img_btu(boxID){
	var obj = $('#'+boxID);
	var isView = obj.attr('view');
	if(isView!='false'){
		obj.mousemove(function(e){ var img = $(this).val(); view_img(img,1,parseInt(e.pageX),parseInt(e.pageY)); });
		obj.mouseout(function(){ view_img('',0,0,0); });
		}
	}
function view_img(img,T,x,y){
	if(img!='' && T==1){
		var size = $('#view_img').size();
		if( size<=0 ){
			$('body').append('<div id="view_img"><img src="" width="150"/></div>');
			$('body').css({"position":"relative"});
			$('#view_img').css({"position":"absolute"});
		}
		$('#view_img img').attr('src',img);
		$('#view_img').css({"display":"block","left": x + "px", "top": y + "px"});
	}else{
		$('#view_img').css({"display":"none"});
	}
}


/*判断是否选中项*/
function ischecked(){
	var thisis=false;
	$(".delitem").each(function(){
		if(thisis==false){
			var thischecked=$(this).attr("checked");
			if(thischecked){thisis=true;}
			}
		});
	if(thisis==false){ alert("至少要选择一项!"); return false; }
	
	var cmd = $('#cmd').val();
	if( cmd=='' ){ alert("请选择操作类型!"); return false; }
	
	return thisis;
}