<?php

class Products_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	//返回推荐的N条
	function get_ok($num=0)
	{
	    $this->db->select('*');
    	$this->db->from('products');
		$this->db->where('ok',1);
		$this->db->limit($num);
    	return $this->db->get()->result();
	}

	//返回推荐的N条
	function get_list($num=0,$type_id=false)
	{
	    $this->db->select('products.*,products_inventory_type.title as i_title');
    	$this->db->from('products');
		$this->db->join('products_inventory_type','products_inventory_type.id = products.i_type','left');
		$this->db->where('products.ok',1);
		if(is_num($type_id))
		{
			$this->db->where('typeB_id',$type_id);
		}
		$this->db->limit($num);
    	$this->db->order_by('order_id','desc');
    	$this->db->order_by('id','desc');
    	return $this->db->get()->result();
	}
	
	//返回分类
	function get_types($type_ids=0)
	{
		if(is_num($type_ids))
		{
	    $this->db->select('*');
    	$this->db->from('products_type');
		$this->db->where('type_ids',$type_ids);
    	$this->db->order_by('type_order_id','desc');
    	$this->db->order_by('type_id','desc');
    	return $this->db->get()->result();
		}
	}
	
	function types_box($type_ids=0)
	{
		$box = '';
		$rs = $this->get_types( $type_ids );
		if(!empty($rs))
		{
			foreach($rs as $item)
			{
				$box[] = array(
					   'type_id' => $item->type_id,
					   'type_title' => $item->type_title,
					   'type_ids' => $this->types_box( $item->type_id )
				);
			}
		}
		return $box;
	}
	

	//返回库存分类
	function get_inventory_type()
	{
	    $this->db->select('*');
    	$this->db->from('products_inventory_type');
    	return $this->db->get()->result();
	}
	//返回库存分类名称
	function get_inventory_name($id='')
	{
	    $this->db->select('*');
    	$this->db->from('products_inventory_type');
    	$this->db->where('id',$id);
		$row = $this->db->get()->row();
		if(!empty($row)){
			return $row->title;
		}else{
			return '-';
		}
	}
	
	
	//返回分类数目
	function get_types_num()
	{
		$this->db->where('type_ids',0);
    	return $this->db->count_all_results('products_type');
	}

	//返回分类
	function get_type($type_id)
	{
	    $this->db->select('*');
    	$this->db->from('products_type');
    	$this->db->where('type_id',$type_id);
    	return $this->db->get()->row();
	}
	

	//返回分类
	function get_type_by_title($title='',$ids=0)
	{
	    $this->db->select('*');
    	$this->db->from('products_type');
		$this->db->where('type_ids',$ids);
    	$this->db->where('type_title',$title);
    	return $this->db->get()->row();
	}

	//返回大小分类
	function get_type_arr($type_id=0)
	{
		$data['typeB_id'] = 0;
		$data['typeS_id'] = 0;
		$types = $this->get_type( $type_id );
		if( !empty($types) )
		{
			$typeB_id = $types->type_ids;
			if( is_num( $typeB_id ) && $typeB_id > 0 ){
				$data['typeB_id'] = $typeB_id;
				$data['typeS_id'] = $type_id;
			}else{
				$data['typeB_id'] = $type_id;
			}
		}
		return $data;
	}
	
	
	//切换是否选项的状态
	function check_change($id=0,$cmd='ok',$val=0)
	{
		if(is_num($id)){
			$this->db->set($cmd,$val);
			$this->db->where('id',$id);
			return $this->db->update('products');
		}elseif(is_array($id)){
			$this->db->set($cmd,$val);
			$this->db->where_in('id',$id);
			return $this->db->update('products');
		}
		return false;
	}
	
	
	//文章点击+1
	function hit($id=0)
	{
    	$this->db->set('hits', 'hits+1', FALSE);
    	$this->db->where('id', $id);
    	return $this->db->update('products');
	}
	
	//返回文章内容详情
	function view($id=0)
	{
	    $this->db->select('products.*,products_type.*,products_inventory_type.title as i_title');
    	$this->db->from('products');
    	$this->db->join('products_type','products.typeB_id = products_type.type_id','left');
		$this->db->join('products_inventory_type','products_inventory_type.id = products.i_type','left');
		//$this->db->where('products.ok',1);
    	$this->db->where('products.id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	//返回同分类的前后产品
	function viewlike($typeb_id='',$id='')
	{
		$id = get_num($id,false);
		$typeb_id = get_num($typeb_id,false);
		
		if(is_num($id)&&is_num($typeb_id)){
			
			$this->db->start_cache();
			  $this->db->select('id,title,typeB_id,pic_s');
			  $this->db->from('products');
			  $this->db->where('ok',1);
			  $this->db->where('typeB_id',$typeb_id);
			$this->db->stop_cache();
			
			$this->db->where('id >=',$id);
			$this->db->order_by('id','asc');
			$this->db->limit(3);
			$uSql = $this->db->getSQL();
			
			$this->db->where('id <',$id);
			$this->db->order_by('id','desc');
			$this->db->limit(2);
			$dSql = $this->db->getSQL();
			
			$this->db->flush_cache();
			
			//合并查询语句
			$uSql = str_replace('(','',$uSql);
			$uSql = str_replace(')','',$uSql);
			$dSql = str_replace('(','',$dSql);
			$dSql = str_replace(')','',$dSql);
			$ntbl = "select * from(".$uSql.") as t1 UNION (".$dSql.") order by id desc";
			//$ntbl = 'SELECT * FROM('.$ntbl.')t GROUP BY id';
			//echo $ntbl;
			
			$query = $this->db->query( $ntbl );
			return $query->result();
		}else{
			return NULL;
		}
	}
	
	
	//删除文章内容
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('products'); 
	}
	
	/*删除分类*/
	function del_type($type_id)
	{
    	$this->db->where('type_id', $type_id);
    	return $this->db->delete('products_type'); 
	}
	
	
	





	//返回样式
	function get_styles($type_ids=0)
	{
	    $this->db->select('*');
    	$this->db->from('products_style');
		$this->db->where('type_ids',$type_ids);
    	$this->db->order_by('type_order_id','desc');
    	$this->db->order_by('type_id','desc');
    	return $this->db->get()->result();
	}
	
	function style_box($type_ids=0)
	{
		$box = '';
		$rs = $this->get_styles( $type_ids );
		if(!empty($rs))
		{
			foreach($rs as $item)
			{
				$box[] = array(
					'type_id' => $item->type_id,
					'type_title' => $item->type_title,
					'type_ids' => $this->style_box( $item->type_id )
				);
			}
		}
		return $box;
	}
	
	
	//返回分类数目
	function get_style_num()
	{
		$this->db->where('type_ids',0);
    	return $this->db->count_all_results('products_style');
	}

	//返回分类
	function get_style($type_id)
	{
		
	    $this->db->select('*');
    	$this->db->from('products_style');
    	$this->db->where('type_id',$type_id);
    	return $this->db->get()->row();
	}

	//通过名称返回分类
	function get_style_by_title($title='',$ids=0)
	{
	    $this->db->select('*');
    	$this->db->from('products_style');
		$this->db->where('type_ids',$ids);
    	$this->db->where('type_title',$title);
		$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	

	//通过名称或ID返回ID，或创建分类
	function get_style_title_id($key='')
	{
	    $this->db->select('*');
    	$this->db->from('products_style');
    	$this->db->where('type_title',$key);
		$this->db->or_where('type_id',$key);
		$this->db->limit(1);
		$row = $this->db->get()->row();
		if(!empty($row))
		{
			//直接返回ID
			return $row->type_id;
		}
		else
		{
			//创建并返回ID
			$data['type_title'] = $key;
			$this->db->insert('products_style',$data);
			return $this->db->insert_id();
		}
	}
	
	
	
	/*删除分类*/
	function del_style($type_id)
	{
    	$this->db->where('type_id', $type_id);
    	return $this->db->delete('products_style'); 
	}

}
?>