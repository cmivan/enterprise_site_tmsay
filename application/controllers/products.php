<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('gzpft_val');
		
		//3.产品分类
		$this->load->model('Products_Model');
		$this->data["p_types"] = $this->Products_Model->get_types();
		$this->data["p_styles"] = $this->Products_Model->get_styles();

	}

	
	//产品分类导航
	function p_nav_html($data,$key)
	{
		$htm = '';
		$sel = '';
		$key_val = $this->input->getnum($key);
		foreach($data as $type){
			$htm_tmp = '';
			if( $key_val == $type->type_id ){
				$htm_tmp.= '<a href="#"><b>'.$type->type_title.'</b></a>';
				$sel = array('title'=>$type->type_title,'key'=>$key);
			}else{
				if($key=='p_type_id'){
					$htm_tmp.= '<a href="'.reUrl($key.'='.$type->type_id.'&p_types_use_id=null&page=null').'">'.$type->type_title.'</a>';
				}else{
					$htm_tmp.= '<a href="'.reUrl($key.'='.$type->type_id.'&page=null').'">'.$type->type_title.'</a>';
				}
			}
			if(!empty($htm_tmp)){
				//获取小类
				$p_types_use = $this->Products_Model->get_types($type->type_id);
				$htm_tmp = '<div class="nav-item"><p>'.$htm_tmp.'</p>';
				$htm_tmp.= $this->p_nav_2_html($p_types_use,'p_types_use_id');
				$htm_tmp.= '</div>';
			}
			$htm.= $htm_tmp;
		}
		$d['htm'] = $htm;
		$d['sel'] = $sel;
		return $d;
	}
	//产品小类
	function p_nav_2_html($data,$key)
	{
		$htm = '';
		$sel = '';
		$key_val = $this->input->getnum($key);
		foreach($data as $type){
			if( $key_val == $type->type_id ){
				$htm.= '<li><a><b>'.$type->type_title.'</b></a></li>';
				$sel = array('title'=>$type->type_title,'key'=>$key);
			}else{
				$htm.= '<li><a href="'.reUrl('p_type_id='.$type->type_ids.'&p_types_use_id='.$type->type_id.'&page=null').'">'.$type->type_title.'</a></li>';
			}
		}
		if(!empty($htm)){ $htm = '<ul>'.$htm.'</ul>'; }
		return $htm;
	}
	//“已选择” 项HTML
	function p_nav_item_html($title,$key){
		$html = '<span class="label label-success">'.$title;
		$html.= '<a class="icon-remove" href="'.reUrl($key.'=null&page=null',1).'">&nbsp;<!--[if IE 6]>×<![endif]-->&nbsp;</a>';
		$html.= '</span>';
		$html.= '&nbsp;';
		return $html;
	}
	//“已选择” 项输出
	function p_nav_item($data){
		$html = '';
		if(!empty($data)){ $html = $this->p_nav_item_html($data['title'],$data['key']); }
		return $html;
	}
	
	
	
	function index($news='')
	{
		//Seo设置
		$this->data['seo']['title'] = $this->data['nav']['products'] . $this->data['seo']['space'] . $this->data['seo']['title'];

		//关键词处理**************
		$p_nav = '';
		$keyword = noHtml($this->input->get('keyword'));
		if($keyword!=''){ $p_nav.= $this->p_nav_item_html($keyword,'keyword'); }
		
		//产品分类-风格类**************
		$p_styles_html = '';
		$p_styles_id = $this->input->getnum('p_styles_id');
		$p_styles = $this->data["p_styles"];
		$p_styles_html = $this->p_nav_html($p_styles,'p_styles_id');
		if( $p_styles_id ){ $p_nav.= $this->p_nav_item($p_styles_html['sel']); }
		
		//产品分类-大类**************
		$p_type_id = $this->input->getnum('p_type_id');
		$p_types = $this->data['p_types'];
		$p_types_html = '';
		$p_types_html = $this->p_nav_html($p_types,'p_type_id');
		if( $p_type_id ){ $p_nav.= $this->p_nav_item($p_types_html['sel']); }
		
		//产品分类-功能类**************
		$p_types_use_html = '';
		$p_types_use_id = $this->input->getnum('p_types_use_id');
		$p_types_use = $this->Products_Model->get_types($p_type_id);
		if( $p_type_id ){
			$p_types_use_html = $this->p_nav_html($p_types_use,'p_types_use_id');
			if( $p_types_use_id ){ $p_nav.= $this->p_nav_item($p_types_use_html['sel']); }
		}else{
			$p_types_use_html['htm'] = '';
		}

		//--------------
		$this->data['sBox'] = array(	 
					  'keyword' => $keyword,	
					  'p_nav' => $p_nav,
					  'p_types_html' => $p_types_html['htm'],
					  'p_types_use_html' => $p_types_use_html['htm'],
					  'p_styles_html' => $p_styles_html['htm']
					  );

		$this->data['type_id'] = '';
		$this->data['type_title'] = '';
		$this->data['type_note']  = '';
		if( $p_type_id )
		{
			//读取该分类的基本信息
			$type = $this->Products_Model->get_type($p_type_id);
			if(!empty($type))
			{
				$this->data['type_id'] = $type->type_id;
				$this->data['type_title'] = $type->type_title;
				$this->data['type_note'] = $type->type_note;
			}
			
			$this->db->where('products.typeB_id',$p_type_id);
			if($p_types_use_id)
			{
				$this->db->where('typeS_id',$p_types_use_id);
			}
		}
		
		if($p_styles_id){ $this->db->where('products.styles_id',$p_styles_id);}
		if(!empty($keyword))
		{
			$keylike_on[] = array( 'products.pro_no'=> $keyword );
			$keylike_on[] = array( 'products.title'=> $keyword );
			$keylike_on[] = array( 'products.note'=> $keyword );
			$this->db->like_on($keylike_on);
		}
		if($news=='news'){ $this->db->where('products.new',1); }

		//读取该分类下的产品
	    $this->db->select('products.*,products_inventory_type.title as i_title');
    	$this->db->from('products');
		$this->db->join('products_inventory_type','products_inventory_type.id = products.i_type','left');
		$this->db->where('products.ok',1);
		$this->db->order_by('products.id','desc');
		$listsql = $this->db->getSQL();
		
		//读取列表
		$this->load->library('Paging');
		$this->data["list"] = $this->paging->show( $listsql ,15);
		$this->data["listRows"] = $this->paging->listRows;

		if ( $this->super===1 ){
			//输出到视窗
			$this->load->view('products',$this->data);
		}else{
			$this->user_login();
		}
	}
	
	function view($id=0)
	{
		$id = get_num($id,'404');
		$this->load->model('Products_Model');
		$view = $this->Products_Model->view($id);
		if(empty($view)){
			show_404('/');
		}else{
			//Seo设置
			$this->data['seo']['title'] = $view->title . $this->data['seo']['space'] . $this->data['seo']['title'];
			$this->data['seo']['keywords'] = noHtml($view->title) . '，' . $this->data['seo']['keywords'];
			$this->data['seo']['description'] = noHtml($view->note) . '，' . $this->data['seo']['description'];
			$this->data['view'] = $view;
			
			//验证提交的密码
			if ( $this->super===1 || $view->new==1 ){
				//获取相似产品
				$this->data['viewlike'] = $this->Products_Model->viewlike($view->typeB_id,$view->id);
				//输出到视窗
				$this->load->view('products_view',$this->data);
			}else{
				$this->user_login();
			}
		}
	}



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */