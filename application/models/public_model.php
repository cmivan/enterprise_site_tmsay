<?php
class Public_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//返回文章列表
	function lists($tablc_db='')
	{
	    if(!empty($tablc_db)){
			$this->db->select('id,title,content,order_id');
			$this->db->from($tablc_db);
			$this->db->order_by('order_id','desc');
			$this->db->order_by('id','desc');
			$rs = $this->db->get();
			if(!empty($rs)){
				return $rs->result();
			}
		}
	}
	
	//返回文章内容详情
	function view($tablc_db='',$id='')
	{
	    if(!empty($tablc_db)){
			$this->db->select('*');
			$this->db->from($tablc_db);
			if(is_num($id)){
			   $this->db->where('id',$id);
			}
			$this->db->order_by('order_id','desc');
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			return $this->db->get()->row();
		}
	}
	
	//获取二级分类
	function getNav2($data=''){
	    $back = NULL;
	    if(is_array($data)){
		   foreach($data as $key=>$val){
			  $this->tablc_db = $key;
		      $back[$key] = $this->lists($key);
		   }
		}
		return $back;
	}
	
	//删除文章内容
	function del($tablc_db='',$id='')
	{
	    if(!empty($tablc_db)){
			$this->db->where('id', $id);
			return $this->db->delete($tablc_db); 
		}
	}
	
	

}
?>