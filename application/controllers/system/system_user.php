<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_user extends HT_Controller {
	
	public $table = 'system_user';
	public $title = '管理员';
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
				
		$this->data['dbtable'] = $this->table;
		$this->data['dbtitle'] = $this->title;
		
		$this->load->model('System_user_Model');
		$this->load->helper('forms');
	}
	
	function index()
	{
		return $this->manage();
	}
	
	
	//管理页面
	function manage()
	{
		//分页模型
		$this->load->library('Paging');
		
		//操作
		$id = $this->input->get_or_post('id');
		$cmd = $this->input->get_or_post('cmd');
		switch($cmd)
		{
			//删除信息
			case 'del':
			      if( $id != $this->logid && $this->super==1 )
				  {
					  if( is_num($id) )
					  {
						  $this->db->where('super !=',1);
						  $this->db->where('id',$id);
						  $this->db->delete( $this->table );
					  }
					  elseif( is_array($id) )
					  {
						  $this->db->where('super !=',1);
						  $this->db->where_in('id',$id);
						  $this->db->delete( $this->table );	
					  }  
				  }
			break;
			//切换check状态
			case 'ok':
			      $val = $this->input->get('val');
				  if( is_num($val) )
				  {
					  if( is_num($id) && $id != $this->logid )
					  {
						  $val = get_num($val,0);
						  $this->System_user_Model->check_change($id,$cmd,$val);
					  }  
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
			$keylike_on[] = array( 'username'=> $keyword );
			$keylike_on[] = array( 'note'=> $keyword );
			$this->db->like_on($keylike_on);
		}
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		//读取列表
		$this->data["list"] = $this->paging->show( $listsql , 20 );
		$this->data['keyword'] = $keyword;
		$this->load->view_system('template/'.$this->table.'/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		$this->load->library('kindeditor');
		
		$id = $this->input->getnum('id');
		
		$this->data['rs'] = array(
			  'id' => $id,
			  'username' => '',
			  'note' => '',
			  'ok' => 0,
			  'super' => 0
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
					  'username' => $rs->username,
					  'note' => $rs->note,
					  'ok' => $rs->ok,
					  'super' => $rs->super
					  );
			}
		}
		$this->data['formTO']->url = site_system( $this->table . '/edit_save',1);
		$this->data['formTO']->backurl = site_system($this->table,1);
		$this->load->view_system('template/'.$this->table.'/edit',$this->data);
	}
	
	
	
	
	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password2= $this->input->post('password2');
		$note = $this->input->post('note');
		$ok = $this->input->postnum('ok',0);
		$super = $this->input->postnum('super',0);

		//验证数据
		if($username=='')
		{
			json_form_no('请填写帐号ID!');
		}
		elseif($username!=noSql($username))
		{
			json_form_no('请填写帐号ID可能包含特殊字符!');
		}
		elseif( $password=='' && $password2!='' )
		{
			json_form_no('请填写登录密码!');
		}
		elseif( $password!='' && $password2=='' )
		{
			json_form_no('请确认登录密码!');
		}
		elseif($password!='' && $password!=$password2)
		{
			json_form_no('两次输入的密码不一致!');
		}

		//写入数据
		$data = array(
			  'username' => $username,
			  'note' => $note
			  );
		if(!empty($password))
		{
			$data['password'] = pass_system($password);
		}
		if( $id != $this->logid && $this->super == 1 )
		{
			$data['super'] = $super;
			$data['ok'] = $ok;
		}
		
		if($id==false)
		{
			//判断帐号ID是否已经存在
			$this->db->from( $this->table );
			$this->db->where('username',$username);
			$rsnum = $this->db->count_all_results();
			if( $rsnum>0 )
			{
				json_form_no('该帐号ID已被使用，请另外再想一个!');
			}
			$data['loginIp'] = ip();
			$this->db->insert( $this->table ,$data);
			json_form_yes('添加成功!');
		}
		else
		{
			//判断帐号ID是否已经存在
			$this->db->from( $this->table );
			$this->db->where('id !=',$id);
			$this->db->where('username',$username);
			$rsnum = $this->db->count_all_results();
			if($rsnum>0)
			{
				json_form_no('该帐号ID已被使用，请另外再想一个!');
			}
			$this->db->where('id',$id);
			$this->db->update( $this->table ,$data);
			json_form_yes('修改成功!');
		}
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */