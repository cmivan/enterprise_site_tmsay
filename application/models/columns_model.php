<?php
class Columns_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	
	//返回文章内容详情
	function view($id=0)
	{
	    $this->db->select('*');
    	$this->db->from('columns');
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	
	//删除文章内容
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('columns'); 
	}

}
?>