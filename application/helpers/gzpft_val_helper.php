<?php


/**
 * 网站部分值转换
 *
 * @access: public
 * @author: mk.zgc
 * @return: string
 */
function getUserTypeName($type=0)
{
	if($type==1){
		return '经销商';
	}else{
		return '注册用户';
	}
}


function getInuptName($key='')
{
	return pass_token($key.'.cm.2013.'.date('ymdh',time()));
}

function getInput($key='',$id=0,$val='')
{
	$nameMD5 = getInuptName($key);
	return '<input type="text" name="'.$key.'" nameMD5="'.$nameMD5.'" key="'.$id.'" value="'.$val.'" val="'.$val.'"/>';
}





//后台导出客户数据报表专用
function excel($name='',$data=''){
	if(!empty($data)){
		$CI =& get_instance();
		$CI->load->library('excel');
		$titles = array('ID', '城市', '姓名', '手机', '固话', '邮箱','地址', '需求', '备注','录入时间');
		$array = array();
		foreach($data as $item){
			$array[] = array(
							 $item->id,
							 $item->city,
							 $item->nicename,
							 $item->mobile,
							 $item->tel,
							 $item->email,
							 $item->addr,
							 $item->need,
							 $item->note,
							 $item->logintime
							 );
		}
		if(empty($name)){ $name = time(); }
		
		//执行下载
		$CI->excel->filename = $name;
		$CI->excel->make_from_array($titles, $array);
	}else{
		return false;
	}
}

//显示尺寸
function orderShowSize($z='',$w='',$h=''){
	return $z.'&nbsp;*&nbsp;'.$w.'&nbsp;*&nbsp;'.$h;
}

//根据状态返回时间
function orderStatusStr($val='',$time=''){
	if($val=='u.shopping'){
		return '-';
	}else{
		return dateTime($time);
	}
}

function orderInput($id=0,$key='',$val='')
{
	$idmd5 = getInuptName($id);
	return '<input type="text" name="'.$key.'" idmd5="'.$idmd5.'" key="'.$id.'" value="'.$val.'" val="'.$val.'"/>';
}

function orderPassKey($keys='')
{
	$md5key = '';
	if(!empty($keys)){
		$keys.= '@';
		$md5key = pass_key($keys);
	}
	return $md5key;
}


function ordersStatusShow($keys='')
{
    $back = '';
	$CI = &get_instance();
	$status = $CI->Orders_Model->shopping_status($keys);
	$class = '';
    if($keys=='u.shopping'){
	   $class = '#FF0000';
	}elseif($keys=='a.unlook'){
	   $class = '#FF9900';
	}elseif($keys=='a.untreated'){
	   $class = '#0033CC';
	}elseif($keys=='a.ok.notshipment'){
	   $class = '#009966';
	}elseif($keys=='a.ok.shipment'){
	   $class = '#990033';
	}else{
	   $class = '';
	}
	$back = '<strong style="color:'.$class.'">'.$status.'</strong>';
	return $back;
}

?>