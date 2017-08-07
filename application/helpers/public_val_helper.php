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

?>