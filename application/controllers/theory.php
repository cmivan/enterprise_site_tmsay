<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->model('Columns_Model');
		$view = $this->Columns_Model->view(10);
		if( empty($view) )
		{
			show_404();
		}
		$this->data['view'] = $view;

		//Seo设置
		$this->data['seo']['title'] = $view->title . $this->data['seo']['space'] . $this->data['seo']['title'];
		$this->data['seo']['keywords'] = noHtml($view->title) . '，' . $this->data['seo']['keywords'];
		$this->data['seo']['description'] = noHtml($view->note) . '，' . $this->data['seo']['description'];
		
		//输出到视窗
		$this->load->view('page',$this->data);
	}
	
	function culture()
	{
		$action = $this->input->get('action');
		if($action=='ajax_post'){
			$this->culture_page();
		}else{
			$this->culture_page('list');
			//输出到视窗
			$this->load->view('culture',$this->data);
		}
	}
	
	function culture_page($cmd='')
	{
		//读取该分类下的产品
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('typeb_id',8);
		//$this->db->where('typeb_id',4);
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		//读取列表
		$this->load->library('Paging');
		$this->data["list"] = $this->paging->show( $listsql ,8);
		if($cmd==''){
			//输出到视窗
			$this->load->view('culture_page',$this->data);
		}else{
			return $this->data["list"];
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */