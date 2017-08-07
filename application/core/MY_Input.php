<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Input扩展程序*/

class MY_Input extends CI_Input
{
	//GET数字
	function getnum($key,$back=false)
	{
		return get_num($this->get($key),$back);
	}
	
	//POST数字
	function postnum($key,$back=false)
	{
		return get_num($this->post($key),$back);
	}
	
	
	//两种方式获取，多用于获取关键词
	function get_or_post($index = NULL, $xss_clean = FALSE)
	{
		$v = $this->get($index, $xss_clean);
		if($v!='')
		{
			return $v;
		}
		else
		{
			return $this->post($index, $xss_clean);
		}
	}
	
	
	 
}
/* End of file Loader.php */
/* Location: ./system/core/Loader.php */
