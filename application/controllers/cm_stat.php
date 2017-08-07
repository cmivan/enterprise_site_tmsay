<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cm_stat extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Sitecount');
		$this->sitecount->logid = $this->logid;
	}
	
	//统计代码
	function online()
	{
		
		$this->sitecount->allinfo();
		$this->sitecount->todayip();
		
		//获取客户IP
		$ip = $this->sitecount->ClinetIp();
		//获取客户操作系统
		$system = $this->sitecount->ClinetOS();
		//获取客户浏览器
		$browser = $this->sitecount->Browser();
		
		$referer = $this->input->server('HTTP_REFERER');
		$this->sitecount->iplist($ip,$system,$browser,$referer);
		$this->sitecount->pases($referer);
		$this->sitecount->update_pv();

		echo '//by:cmivan | time:12.4.25 | for:stat' . chr(10);
		echo 'document.write("<script>var url=\''.site_url('cm_stat/stats').'\';</script>");';
		echo 'document.write("<script language=javascript src="+url+"?url="+escape(document.referrer)+"></script>");';
		exit;
	}
	
	//
	function stats()
	{
		$url = $this->input->get('url',true);
		$url = noHtml($url);
		$this->sitecount->comes( $url );
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */