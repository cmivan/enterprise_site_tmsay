<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends HT_Controller {
	
	public $table = 'products';
	public $title = '产品';

	function __construct()
	{
		parent::__construct();
		//判断是否已经配置信息
		
		$this->data['dbtable'] = $this->table;
		$this->data['dbtitle'] = $this->title;
		
		$this->load->model('Products_Model');
		$this->load->helper('forms');

		$this->data['typeB'] = $this->Products_Model->types_box();
		$this->data['styleB'] = $this->Products_Model->style_box();
		
		//获取库存单位
		$this->load->helper('cookie');
	}
	
	function index()
	{
		return $this->manage();
	}
	


/* ********** 管理 *********** */
	function manage()
	{
		$this->load->library('Paging');
		$this->load->helper('gzpft_val');

		//操作
		$id = $this->input->get_or_post('id');
		$cmd = $this->input->get_or_post('cmd');
		switch($cmd)
		{
			//删除信息
			case 'del':
				  if( is_num($id) )
				  {
					  $this->db->where('id',$id);
					  $this->db->delete( $this->table );
				  }
				  elseif( is_array($id) )
				  {
					  $this->db->where_in('id',$id);
					  $this->db->delete( $this->table );	
				  }
			break;
			//移动信息
			case 'move':
				  if( is_array($id) )
				  {
					  $type_id = $this->input->post('type_id');
					  $T = $this->Products_Model->get_type_arr( $type_id );
					  $this->db->where_in('id',$id);
					  $this->db->update( $this->table , $T );
				  }
			break;
			//显示信息
			case 'show':
			//隐藏信息
			case 'hide':
				  if($cmd=='show'){
					  $this->Products_Model->check_change($id,'ok',1);
				  }else{
					  $this->Products_Model->check_change($id,'ok',0);
				  }
			break;
			
			//切换check状态
			case 'ok':
			case 'hot':
			case 'new':
			      $val = $this->input->getnum('val',0);
				  $this->Products_Model->check_change($id,$cmd,$val);
			break;
		}

		//获取分类
		$typeB_id = $this->input->getnum('typeb_id');
		$typeS_id = $this->input->getnum('types_id');
		$styles_id = $this->input->getnum('styles_id');
		if( $typeB_id )
		{
			$this->data['typeS'] = $this->Products_Model->types_box( $typeB_id );
		}
		
		//生成查询
		$tb_p = $this->table;
		$tb_i = 'products_inventory_type';
		
		$this->db->select("$tb_p.*,$tb_i.title as i_title");
		$this->db->from( $tb_p );
		$this->db->join($tb_i, "$tb_p.i_type = $tb_i.id",'left');
		
		//搜索关键词
		$keyword = $this->input->get_or_post('keyword',TRUE);
		if($keyword!='')
		{
			$keylike_on[] = array( "$tb_p.pro_no"=> $keyword );
			$keylike_on[] = array( "$tb_p.title"=> $keyword );
			$keylike_on[] = array( "$tb_p.note"=> $keyword );
			$this->db->like_on($keylike_on);
		}
		//分类检索
		if( $typeB_id ){
			$this->db->where("$tb_p.typeB_id",$typeB_id);
			if( $typeS_id ){
				$this->db->where("$tb_p.typeS_id",$typeS_id);
			}
		}
		if( $styles_id ){
			$this->db->where("$tb_p.styles_id",$styles_id);
		}

		$this->db->order_by("$tb_p.id",'desc');
		$this->db->group_by("$tb_p.id");
		
		$listsql = $this->db->getSQL();
		//print_r($listsql);
		//读取列表
		//print_r($listsql);
		//exit;
		$this->data["list"] = $this->paging->show( $listsql , 20 );

		$this->data['typeB_id'] = $typeB_id;
		$this->data['typeS_id'] = $typeS_id;
		$this->data['styles_id'] = $styles_id;
		$this->data['keyword'] = $keyword;
		$this->load->view_system('template/'.$this->table.'/manage',$this->data);
	}
	
/* ********** 管理页面快捷修改产品参数 *********** */
    function changeobj()
	{
		$this->load->helper('gzpft_val');
		$key     = $this->input->postnum('key');
		$name    = $this->input->post('name');
		$nameMD5 = $this->input->post('nameMD5');
		$val     = $this->input->post('val');
		//*******************************
		$name    = noSql(noHtml( $name ));
		$nameMD5 = noSql(noHtml( $nameMD5 ));
		$val     = noSql(noHtml( $val ));
		$_nameMD5 = getInuptName( $name );
		
		if($nameMD5==$_nameMD5&&$key!=false){
			$data= array( $name => $val );
			$this->db->where('id',$key);
			$this->db->update( $this->table ,$data);
			json_form_yes($val);
		}else{
			json_form_no('参数被篡改!');
		}
	}
	


/* ********** 添加/编辑 *********** */
	function edit()
	{
		$this->load->library('kindeditor');
		
		$id = $this->input->getnum('id');
		$i_type_id = $this->input->cookie('i_type_id');

		$this->data['rs'] = array(
			  'id' => $id,
			  'title' => '',
			  'pro_no' => '',
			  'material' => '',
			  'size_z' => '',
			  'size_w' => '',
			  'size_h' => '',
			  'price' => '',
			  'price_vip' => '',
			  'i_type' => '',
			  'note' => '',
			  'content' => '',
			  'pic_b' => '',
			  'pic_s' => '',
			  'note' => '',
			  'typeB_id' => 0,
			  'typeS_id' => 0,
			  'styles_id' => 0,
			  'add_time' => dateTime(),
			  'add_ip' => ip(),
			  'hits' => '',
			  'order_id' => 0,
			  'new' => 0,
			  'ok' => 1,
			  'hot' => 0
			  );
		
		if( $id )
		{
			$this->db->select('*');
			$this->db->from( $this->table );
			$this->db->where('id',$id);
			$rs = $this->db->get()->row();
			if( !empty($rs) )
			{
				$this->data['rs'] = array(
					  'id' => $rs->id,
					  'title' => $rs->title,
					  'pro_no' => $rs->pro_no,
					  'material' => $rs->material,
					  'size_z' => $rs->size_z,
					  'size_w' => $rs->size_w,
					  'size_h' => $rs->size_h,
					  'price' => $rs->price,
					  'price_vip' => $rs->price_vip,
					  'i_type' => $rs->i_type,
					  'note' => $rs->note,
					  'content' => $rs->content,
					  'pic_b' => $rs->pic_b,
					  'pic_s' => $rs->pic_s,
					  'note' => $rs->note,
					  'typeB_id' => $rs->typeB_id,
					  'typeS_id' => $rs->typeS_id,
					  'styles_id' => $rs->styles_id,
					  'add_time' => $rs->add_time,
					  'add_ip' => $rs->add_ip,
					  'hits' => $rs->hits,
					  'order_id' => $rs->order_id,
					  'new' => $rs->new,
					  'ok' => $rs->ok,
					  'hot' => $rs->hot
					  );
			}
		}
		
		//获取上次记录的库存单位
		if( is_num($i_type_id) && empty($this->data['rs']['i_type']) ){
			$this->data['rs']['i_type'] = $i_type_id;
		}
		
		//库存单位
		$this->data['i_type'] = $this->Products_Model->get_inventory_type();
		
		$this->data['formTO']->url = site_system( $this->table . '/edit_save',1);
		$this->data['formTO']->backurl = site_system($this->table,1);
		$this->load->view_system('template/'.$this->table.'/edit',$this->data);
	}
	
	//保存产品添加/编辑
	function edit_save()
	{
		$id = $this->input->postnum('id');
		
		$title = $this->input->post('title');
		$pro_no = $this->input->post('pro_no');
		$material = $this->input->post('material');
		$size_z = $this->input->post('size_z');
		$size_w = $this->input->post('size_w');
		$size_h = $this->input->post('size_h');
		$price = $this->input->postnum('price',0);
		$price_vip = $this->input->postnum('price_vip',0);
		$i_type = $this->input->postnum('i_type');
		$note = $this->input->post('note');
		$content = $this->input->post('content');
		$pic_b = $this->input->post('pic_b');
		$pic_s = $this->input->post('pic_s');
		$note = $this->input->post('note');
		$type_id = $this->input->post('type_id');
		$T = $this->Products_Model->get_type_arr( $type_id );
		$typeB_id = $T['typeB_id'];
		$typeS_id = $T['typeS_id'];
		$styles_id = $this->input->postnum('styles_id',0);
		
		if($price==0||$price_vip==0){
			json_form_no('注意：价格和库存都必须是非0数字哦！');
		}
		
		//记录上次添加编辑时的库存单位
		if($i_type){
			$cookie = array(
				'name'   => 'i_type_id',
				'value'  => $i_type,
				'expire' => '86500'
				);
			$this->input->set_cookie( $cookie );
		}

		$add_time = $this->input->post('add_time');
		$add_ip = $this->input->post('add_ip');
		$hits = $this->input->postnum('hits',0);
		$order_id = $this->input->postnum('order_id',0);
		$new = $this->input->postnum('new',0);
		$ok = $this->input->postnum('ok',0);
		$hot = $this->input->postnum('hot',0);
		
		$data = array(
			  'title' => $title,
			  'pro_no' => $pro_no,
			  'material' => $material,
			  'size_z' => $size_z,
			  'size_w' => $size_w,
			  'size_h' => $size_h,
			  'price' => $price,
			  'price_vip' => $price_vip,
			  'i_type' => $i_type,
			  'note' => $note,
			  'content' => $content,
			  'pic_b' => $pic_b,
			  'pic_s' => $pic_s,
			  'typeB_id' => $typeB_id,
			  'typeS_id' => $typeS_id,
			  'styles_id' => $styles_id,
			  'add_time' => $add_time,
			  'add_ip' => $add_ip,
			  'hits' => $hits,
			  'order_id' => $order_id,
			  'new' => $new,
			  'ok' => $ok,
			  'hot' => $hot
			  );
		
		if( $id )
		{
			$this->db->where('id',$id);
			$this->db->update( $this->table ,$data);
			json_form_yes('更新成功！');
		}
		else
		{
			$this->db->insert( $this->table ,$data);
			json_form_yes('录入成功！');
		}
	}
	
	

/* ********** 分类管理页面 *********** */
	
	
	//分类页面
	function type()
	{
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
			$this->Products_Model->del_type($del_id);
			//重新获取分类
			$this->data['typeB'] = $this->Products_Model->types_box();
		}

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$type_id = $this->input->postnum('type_id');
			
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($type_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Products_Model->get_type( $type_id );
			if(!empty($row))
			{
				//执行重新排序
				$this->load->helper('publicedit');
				$keys = array(
					  'table'=> $this->table . '_type',
					  'key'  => 'type_id',
					  'okey' => 'type_order_id',
					  'id'   => $row->type_id,
					  'oid'  => $row->type_order_id,
					  'type' => $cmd
					  );
				List_Re_Order($keys);
			}	
		}
		
		//表单配置
		$this->data['formTO']->url = site_system( $this->table . '/type',1);
		$this->data['formTO']->backurl = '';

		//输出界面效果
		$this->load->view_system('template/'.$this->table.'/type_manage',$this->data);
	}
	
	function type_edit()
	{
		$this->load->library('kindeditor');
		
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['type_id'] = $id;
		$this->data['type_title'] = '';
		$this->data['type_title_2'] = '';
		$this->data['type_note'] = '';
		$this->data['type_pic'] = '';
		$this->data['type_ids'] = 0;
		$this->data['type_order_id'] = 0;
		
		$this->data['action_name'] = "添加";
		if( $id )
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Products_Model->get_type($id);
			if(!empty($rs))
			{
				$this->data['type_title'] = $rs->type_title;
				$this->data['type_title_2'] = $rs->type_title_2;
				$this->data['type_note'] = $rs->type_note;
				$this->data['type_pic'] = $rs->type_pic;
				$this->data['type_ids'] = $rs->type_ids;
				$this->data['type_order_id'] = $rs->type_order_id;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = site_system( $this->table . '/type_save',1);
		$this->data['formTO']->backurl = site_system( $this->table . '/type',1);
		
		$this->load->view_system('template/'.$this->table.'/type_edit',$this->data);
	}
	
	
	//保存分类
	function type_save()
	{
		//接收提交来的数据
		$type_id = $this->input->postnum('type_id');
		$type_title = $this->input->post('type_title');
		$type_title_2 = $this->input->post('type_title_2');
		$type_note = $this->input->post('type_note');
		$type_pic = $this->input->post('type_pic');
		$type_ids = $this->input->postnum('type_ids',0);
		$type_order_id = $this->input->postnum('type_order_id',0);

		//验证数据
		if($type_title=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($type_order_id===false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		
		//写入数据
		$data['type_title'] = $type_title;
		$data['type_title_2'] = $type_title_2;
		$data['type_note'] = $type_note;
		$data['type_pic'] = $type_pic;
		$data['type_ids'] = $type_ids;
		$data['type_order_id'] = $type_order_id;
		
		if($type_id==false)
		{
			//添加
			$this->db->insert($this->table . '_type',$data);
			//重洗分类排序
			$this->re_order_type();
			json_form_yes('添加成功!');
		}
		else
		{
			//修改
			$this->db->where('type_id',$type_id);
			$this->db->update($this->table . '_type',$data);
			//重洗分类排序
			$this->re_order_type();
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_type()
	{
		$re_row = $this->Products_Model->get_types();
		if(!empty($re_row))
		{
			$re_num = $this->Products_Model->get_types_num();
			foreach($re_row as $re_rs)
			{
				$data['type_order_id'] = $re_num;
				$this->db->where('type_id',$re_rs->type_id);
				$this->db->update( $this->table . '_type',$data);
				$re_num--;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
/* ********** 风格管理页面 *********** */
	
	
	//风格页面
	function style()
	{
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
			$this->Products_Model->del_style($del_id);
			//重新获取风格
			$this->data['typeB'] = $this->Products_Model->style_box();
		}

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$type_id = $this->input->postnum('type_id');
			
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($type_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Products_Model->get_style( $type_id );
			if(!empty($row))
			{
				//执行重新排序
				$this->load->helper('publicedit');
				$keys = array(
					  'table'=> $this->table . '_style',
					  'where'=> 'type_ids=0',
					  'key'  => 'type_id',
					  'okey' => 'type_order_id',
					  'id'   => $row->type_id,
					  'oid'  => $row->type_order_id,
					  'type' => $cmd
					  );
				List_Re_Order($keys);
			}	
		}
		
		//表单配置
		$this->data['formTO']->url = site_system( $this->table . '/style',1);
		$this->data['formTO']->backurl = '';

		//输出界面效果
		$this->load->view_system('template/'.$this->table.'/style_manage',$this->data);
	}
	
	function style_edit()
	{
		$this->load->library('kindeditor');
		
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['type_id'] = $id;
		$this->data['type_title'] = '';
		$this->data['type_note'] = '';
		$this->data['type_pic'] = '';
		$this->data['type_ids'] = 0;
		$this->data['type_order_id'] = 0;
		
		$this->data['action_name'] = "添加";
		if( $id )
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Products_Model->get_style($id);
			if(!empty($rs))
			{
				$this->data['type_title'] = $rs->type_title;
				$this->data['type_note'] = $rs->type_note;
				$this->data['type_pic'] = $rs->type_pic;
				$this->data['type_ids'] = $rs->type_ids;
				$this->data['type_order_id'] = $rs->type_order_id;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = site_system( $this->table . '/style_save',1);
		$this->data['formTO']->backurl = site_system( $this->table . '/style',1);
		
		$this->load->view_system('template/'.$this->table.'/style_edit',$this->data);
	}
	
	
	//保存风格
	function style_save()
	{
		//接收提交来的数据
		$type_id = $this->input->postnum('type_id');
		$type_title = $this->input->post('type_title');
		$type_note = $this->input->post('type_note');
		$type_pic = $this->input->post('type_pic');
		$type_ids = $this->input->postnum('type_ids',0);
		$type_order_id = $this->input->postnum('type_order_id',0);

		//验证数据
		if($type_title=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($type_order_id===false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		
		//写入数据
		$data['type_title'] = $type_title;
		$data['type_note'] = $type_note;
		$data['type_pic'] = $type_pic;
		$data['type_ids'] = $type_ids;
		$data['type_order_id'] = $type_order_id;
		
		if($type_id==false)
		{
			//添加
			$this->db->insert($this->table . '_style',$data);
			//重洗风格排序
			$this->re_order_style();
			json_form_yes('添加成功!');
		}
		else
		{
			//修改
			$this->db->where('type_id',$type_id);
			$this->db->update($this->table . '_style',$data);
			//重洗风格排序
			$this->re_order_style();
			json_form_yes('修改成功!');
		}	
	}

	//重洗风格排序
	function re_order_style()
	{
		$re_row = $this->Products_Model->get_styles();
		if(!empty($re_row))
		{
			$re_num = $this->Products_Model->get_style_num();
			foreach($re_row as $re_rs)
			{
				$data['type_order_id'] = $re_num;
				$this->db->where('type_id',$re_rs->type_id);
				$this->db->update( $this->table . '_style',$data);
				$re_num--;
			}
		}
	}
	



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */