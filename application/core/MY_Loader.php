<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*loader扩展程序*/

class MY_Loader extends CI_Loader
{
	//输出后台view
	function view_system($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view( $CI->config->item("admin_url").$view, $vars, $return);
	}
}
/* End of file Loader.php */
/* Location: ./system/core/Loader.php */
