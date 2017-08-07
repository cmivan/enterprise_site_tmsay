<?php


/**
 * 生成订单编号
 *
 * @access: public
 * @author: mk.zgc
 * @param : 
 * @return: string
 * 
 */
function orderNo($id='')
{
	return date("ymdHis",time()).$id.rand(1,9).rand(1,9).rand(1,9);
}

/**
 * 订单字段加密
 *
 * @access: public
 * @author: mk.zgc
 * @param : 
 * @return: string
 * 
 */
function orderMd5($data='')
{
	$data['md5'] = orderKeyMd5($data);
	return $data;
}

/**
 * 订单字段添加后的提示信息
 *
 * @access: public
 * @author: mk.zgc
 * @param : 
 * @return: string
 * 
 */
function orderAddTip($key='')
{
	if(is_num($key)){
		json_form_yes('添加成功!');
	}else{
		json_form_no('添加失败!');
	}
}


/**
 * 订单字段加密
 *
 * @access: public
 * @author: mk.zgc
 * @param : 
 * @return: string
 * 
 */
function orderKeyMd5($data='')
{
	$back = '';
	if(!empty($data)){
		foreach($data as $key=>$val){
			$back.= $val;
		}
	}
	return pass_key($back);
}

?>