<?php

/**
 * 创建表单样式
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 * @return: string
 * @eq    : json_form_no("要提示消息"); 
 */
function cm_form_select($formID,$itemarr,$valuekey,$titlekey,$selectedkey,$style='')
{
	if(empty($formID)||$formID==''){return '未设置select框的ID!';}
	if(empty($valuekey)||$valuekey==''){return '请给select框的value绑定值!';}
	if(empty($titlekey)||$titlekey==''){return '请给select框的title绑定值!';}
	$selectbox = '';
	$selectbox.= '<select id="'.$formID.'" name="'.$formID.'" '.$style.' >';
	foreach($itemarr as $item){
		if($item->$valuekey==$selectedkey){
			$selectbox.= '<option value="'.$item->$valuekey.'" selected style="background-color:#F60; color:#FFF">'.$item->$titlekey.'</option>';
		}else{
			$selectbox.= '<option value="'.$item->$valuekey.'">'.$item->$titlekey.'</option>';
		}	
	}
	$selectbox.= '</select>';
	return $selectbox;
}



//应用于编辑页面
function cm_form_checkbox($Title='选择',$ID='checkid',$Val='0')
{
	if( $Val == 1 )
	{
		return '<label><input type="checkbox" name="'.$ID.'" id="'.$ID.'" value="1" checked>'.$Title.'</label>';
	}
	else
	{
		return '<label><input type="checkbox" name="'.$ID.'" id="'.$ID.'" value="1">'.$Title.'</label>';
	}
}

//应用于管理页面
function cm_form_check($key='ok',$id=0,$Val='0',$T0='×',$T1='√')
{
	if( (int)$Val == 1 )
	{
		return '<a href="'.reUrl('cmd='.$key.'&val=0&id='.$id).'" class="green"><b>'.$T1.'</b></a>';
	}
	else
	{
		return '<a href="'.reUrl('cmd='.$key.'&val=1&id='.$id).'" class="red"><b>'.$T0.'</b></a>';
	}
}

//返回库存分类
function cm_form_radio($name='',$data='',$id='')
{
	$radio = '';
	if(!empty($data)&&!empty($name)){
		foreach($data as $item){
			if($id==$item->id){
				$radio.= '<label class="red i_radio"><input type="radio" name="'.$name.'" value="'.$item->id.'" checked />'.$item->title.'</label>&nbsp;&nbsp;&nbsp;';
			}else{
				$radio.= '<label><input type="radio" name="'.$name.'" value="'.$item->id.'" />'.$item->title.'</label>&nbsp;&nbsp;&nbsp;';
			}
		}
	}
	return $radio;
}


function cm_form_type_select($data='',$typeB_id=0,$typeS_id=0,$formID='type_id',$style='')
{
	$selectbox = '<select id="'.$formID.'" name="'.$formID.'" '.$style.' >';
	if(!empty($data))
	{
		foreach($data as $rsB)
		{
			if( $typeB_id == $rsB['type_id'] )
			{
				$selectbox.= '<option value="'.$rsB['type_id'].'" style="background-color:#F63;color:#fff" selected>'.$rsB['type_title'].'</option>';
			}
			else
			{
				$selectbox.= '<option value="'.$rsB['type_id'].'">'.$rsB['type_title'].'</option>';
			}
			
			if( !empty($rsB['type_ids']) )
			{
				$type_ids = $rsB['type_ids'];
				foreach($type_ids as $rsS)
				{
					if( $typeS_id == $rsS['type_id'] )
					{
						$selectbox.= '<option value="'.$rsS['type_id'].'" style="background-color:#C2740A;color:#fff" selected> ├ '.$rsS['type_title'].'</option>';
					}
					else
					{
						$selectbox.= '<option style="color:#666" value="'.$rsS['type_id'].'"> ├ '.$rsS['type_title'].'</option>';
					}
				}
			}
		}
	}
	$selectbox.= '</select>';
	return $selectbox;
}


function cm_form_type_edit_select($data='',$typeB_id=0,$typeS_id=0,$formID='type_ids',$style='')
{
	$selectbox = '<select id="'.$formID.'" name="'.$formID.'" '.$style.' >';
	if(!empty($data))
	{
		$selectbox.= '<option value="0">一级分类</option>';
		foreach($data as $rsB)
		{
			if( $typeB_id == $rsB['type_id'] )
			{
				$selectbox.= '<option value="'.$rsB['type_id'].'" selected>'.$rsB['type_title'].'</option>';
			}
			else
			{
				$selectbox.= '<option value="'.$rsB['type_id'].'">'.$rsB['type_title'].'</option>';
			}
		}
	}
	$selectbox.= '</select>';
	return $selectbox;
}
 

?>