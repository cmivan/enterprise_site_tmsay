<?php


if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Editor extends HT_Controller{

    public function __construct()
	{
        parent::__construct();
        $this->load->library('kindeditor');
		if( is_num( (int)$this->logid ) == false )
		{
			$this->kindeditor->alert("请登录!");
		}
    }
	
	//上传文件
    public function upload()
	{
        if(!empty ($_FILES))
		{
			$dir = $this->input->get('dir');
			$mark = $this->input->get('mark');
			$w = $this->input->get('w');
			$h = $this->input->get('h');
			$this->kindeditor->upload($dir,$_FILES,$this->logid,$mark,$w,$h);
        }
    }
	
	//管理文件
    public function manage()
	{
		$dir = $this->input->get('dir');
        $path = $this->input->get('path');
        $this->kindeditor->manage($dir,$path,$this->logid);
    }
 
 
}