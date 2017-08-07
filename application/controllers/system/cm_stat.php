<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cm_stat extends HT_Controller {
	
	public $table = 'cm_stat';
	public $title = 'IP统计';
	
	function __construct()
	{
		parent::__construct();
		//判断是否已经配置信息
		
		$this->data['dbtable'] = $this->table;
		$this->data['dbtitle'] = $this->title;

		$this->load->helper('forms');
		
		$this->load->library('Sitecount');
	}
	
	//访问统计信息
	function index()
	{
		$this->ip();
	}
	
	
	//在线IP信息
	function ip( $all='' )
	{
		$this->db->select('*');
		$this->db->from('online_shu');
		$this->data['online_rs'] = array(
								'shuon' => '0',
								'shugo' => '0',
								'shuip' => '0',
								'shupv' => '0'
								);
		$online_rs = $this->db->get()->row();
		if(!empty($online_rs))
		{
			$this->data['online_rs'] = array(
									'shugo' => $online_rs->shugo,
									'shuip' => $online_rs->shuip,
									'shupv' => $online_rs->shupv
									);
		}
		
		//在线人数
		$this->data['online_rs']['shuon'] = $this->sitecount->online(10);
		
		//统计数据分页显示
		$this->load->library('Paging');
		if( empty($all) )
		{
			$listsql = $this->sitecount->iplist_Sql();
			$this->data['iplist'] = $this->paging->show( $listsql , 20 );
			$this->load->view_system('template/'.$this->table.'/ip',$this->data);
		}
		else
		{
			$listsql = $this->sitecount->iplist_Sql_merger();
			$this->data['iplist'] = $this->paging->show( $listsql , 10 );
			$this->load->view_system('template/'.$this->table.'/merger',$this->data);
		}
		
	}
	
	
	//总体数据
	function total()
	{
		$this->db->select('*');
		$this->db->from('online_shu');		
		$this->data['online_shu'] = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->from('online_cnt');		
		$this->data['online_cnt'] = $this->db->get()->row();

		
		$this->load->view_system('template/'.$this->table.'/total',$this->data);
	}
	
	
	//受访问页面
	function page()
	{
		//统计数据分页显示
		$this->load->library('Paging');
		$listsql = $this->sitecount->urls_Sql();
		$this->data['urls'] = $this->paging->show( $listsql , 20 );
		
		$this->load->view_system('template/'.$this->table.'/page',$this->data);
	}
	
	
	//受访问页面
	function source()
	{
		//统计数据分页显示
		$this->load->library('Paging');
		$listsql = $this->sitecount->comes_Sql();
		$this->data['urls'] = $this->paging->show( $listsql , 20 );
		
		$this->load->view_system('template/'.$this->table.'/source',$this->data);
	}





}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */