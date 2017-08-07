<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->data['onId'] = '';
	}

	function index()
	{
		//Seo设置
		//$this->data['seo']['title'] = '安投茶油' . $this->data['seo']['space'] . $this->data['seo']['title'];
		//print_r(iptodata('102.17.2.123'));
		//$this->data["p_types"] = NULL;
		//输出到视窗
		$this->load->view('index',$this->data);
	}
	

	function page($id='')
	{
		$view = $this->Public_Model->view($this->navOn,$id);
		if(!empty($view)){
		   $this->data['onId'] = $view->id;
		   $this->data["view"] = $view;
		   
		  //返回网站所在位置
		  $this->data["location"] = array(
				array('首页','index','home'),
				array($this->data["nav"][$this->navOn],$this->navOn),
				array($view->title,$this->navOn.'/'.$view->id)
				); 
		}
		
		//输出到视窗
		$pageKey = $this->data['navOn'];
		$this->load->view('page',$this->data);
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */