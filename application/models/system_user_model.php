<?php
#淘工会信息

class System_user_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	
	//返回详情
	function view($id=0)
	{
	    $this->db->select('*');
    	$this->db->from('system_user');
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	//切换是否选项的状态
	function check_change($id=0,$cmd='ok',$val=0)
	{
	    $this->db->set($cmd,$val);
    	$this->db->where('id',$id);
    	return $this->db->update('system_user');
	}

	//删除
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('system_user'); 
	}
	
}
?>