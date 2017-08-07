<?php
 if (!defined('BASEPATH')) exit('No direct access allowed.');

 //后台公共配置
 class QT_Controller extends CI_Controller {
	
	public $data;
	public $logid = 0;
	public $super = 0;
	public $navOn = '';
	
	function __construct(){
		parent::__construct();
		
		//评测应用程序
		//$this->output->enable_profiler(true);
		
		//初始化SEO设置
		$this->data['seo'] = $this->config->item("seo");
		//样式配置
		$this->data["style"] = $this->config->item("style");
		//站点信息
		$this->data["cm_pro"] = $this->config->item("cm_pro");
		//样式辅助
		$this->data["css_helper"] = false;
		
		
		
		//初始化导航栏所在栏目
		$this->data["navOn"] = '';
		$this->data["navOn2"] = '';
		   
		//加载语言包
		$this->lang->load('config','en');
		$this->data["site"] = $this->lang->line('site');
		//加载导航栏
		$this->data["navAll"] = $this->lang->line('nav');
		//除去主页导航
		$this->data["nav"] = $this->data["navAll"];
		unset($this->data["nav"]['index']);

		//通用模型
		$this->load->model('Public_Model');
		//定义主导航栏
		$this->data["nav2"] = $this->Public_Model->getNav2( $this->data["nav"] );
		
		//目前所在栏目
		$this->navOn = $this->uri->segment(1);
		if(!empty($this->data["navAll"][$this->navOn])){
		   $this->data["navOn"] = $this->navOn;
		   //获取二级导航
		   if(!empty($this->data["nav"][$this->navOn])){
		      $this->data["navOn2"] = $this->data["nav2"][$this->navOn];
		   }
		}
		
		//用户登录
		$this->super = 1;
    }
	
	
	
	//显示用户登录界面
	function user_login()
	{
		$this->load->view('user_login',$this->data);
	}


 }
 
 
 
 //会员后台公共配置
 class U_Controller extends QT_Controller {
	 
	function __construct(){
		parent::__construct();
		//初始化登录信息
		$this->data = $this->ini_login( $this->data );
    }

	//初始化登录信息
	function ini_login( $data = NULL )
	{
		$power = $this->session->userdata("user_power");
		$this->logid = $power['logid'];
		if( is_num( $this->logid ) )
		{
			return array_merge($data,$power);
		}
		show_error('可能是没有登录 或者是 登录后超过了15分钟没有操作!<br>可以尝试<a href="'.site_url('index').'">重新登录</a>',500, '无法访问该页面!');
		exit;
	} 
 }



 //系统后台公共配置
 class HT_Controller extends QT_Controller {
	 
	function __construct(){
		parent::__construct();
		//初始化登录信息
		$this->data = $this->ini_login( $this->data );
		//后台路径
		$this->data["admin_url"] = $this->config->item("admin_url");
		
		//获取所在位置
		$this->navOn = $this->uri->segment(2);
		if(!empty($this->data["nav"][$this->navOn])){
		   $this->data["navOn"] = $this->navOn;
		   $this->data["navOn2"] = $this->data["nav2"][$this->navOn];
		}
    }

	//初始化登录信息
	function ini_login( $data = NULL )
	{
		$power = $this->session->userdata("cm_power");
		$this->logid = $power['logid'];
		$this->super = $power['super'];
		if( is_num( $this->logid ) )
		{
			return array_merge($data,$power);
		}
		show_error('可能是没有登录 或者是 登录后超过了15分钟没有操作!<br>可以尝试<a href="'.site_system('system_login').'">重新登录</a>',500, '无法访问该页面!');
		exit;
	}
	
 }
 
 
 
 
 
 
 
 
 //系统后台管理页面
 class EDIT_Controller extends HT_Controller {
	 
	public $table = 'about';
	public $title = '页面';
	
	function __construct(){
		parent::__construct();

		//判断是否已经配置信息
		$this->load->model('Public_Model');
		$this->load->helper('forms');
		
		if(!empty($this->navOn)){
		   $this->table = $this->navOn;
		   $this->data['dbtable'] = $this->navOn;
		   $this->data['dbtitle'] = $this->data['nav'][$this->navOn];
		}
    }
	
	function index()
	{
		return $this->manage();
	}
	


/* ********** 管理 *********** */
	function manage()
	{
		$this->load->library('Paging');

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
					  $T = $this->Columns_Model->get_type_arr( $type_id );
					  $this->db->where_in('id',$id);
					  $this->db->update( $this->table , $T );
				  }
			break;
		}
		
		//生成查询
		$this->db->select('*');
		$this->db->from( $this->table );
		//搜索关键词
		$keyword = $this->input->get_or_post('keyword',TRUE);
		if($keyword!='')
		{
			$keylike_on[] = array( 'title'=> $keyword );
			$keylike_on[] = array( 'note'=> $keyword );
			$this->db->like_on($keylike_on);
		}
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		//读取列表
		$this->data["list"] = $this->paging->show( $listsql , 20 );
		$this->data['keyword'] = $keyword;
		$this->load->view_system('template/page/manage',$this->data);
	}


/* ********** 添加/编辑 *********** */
	function edit()
	{
		$this->load->library('kindeditor');
		
		$id = $this->input->getnum('id');
		
		$this->data['rs'] = array(
			  'id' => $id,
			  'title' => '',
			  'note' => '',
			  'content' => '',
			  'pic_b' => '',
			  'pic_s' => '',
			  'add_time' => dateTime(),
			  'add_ip' => ip(),
			  'hits' => '',
			  'order_id' => 0,
			  'new' => 0,
			  'ok' => 0,
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
					  'note' => $rs->note,
					  'content' => $rs->content,
					  'pic_b' => $rs->pic_b,
					  'pic_s' => $rs->pic_s,
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
		$this->data['formTO']->url = site_system($this->table.'/edit_save',1);
		$this->data['formTO']->backurl = site_system($this->table,1);
		$this->load->view_system('template/page/edit',$this->data);
	}
	
	//保存产品添加/编辑
	function edit_save()
	{
		$id = $this->input->postnum('id');
		
		$title = $this->input->post('title');
		$note = $this->input->post('note');
		$content = $this->input->post('content');
		$pic_b = $this->input->post('pic_b');
		$pic_s = $this->input->post('pic_s');
		$add_time = $this->input->post('add_time');
		$add_ip = $this->input->post('add_ip');
		$hits = $this->input->postnum('hits',0);
		$order_id = $this->input->postnum('order_id',0);
		$new = $this->input->postnum('new',0);
		$ok = $this->input->postnum('ok',0);
		$hot = $this->input->postnum('hot',0);
		
		$data = array(
			  'title' => $title,
			  'note' => $note,
			  'content' => $content,
			  'pic_b' => $pic_b,
			  'pic_s' => $pic_s,
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

	
	
 }
 
/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */