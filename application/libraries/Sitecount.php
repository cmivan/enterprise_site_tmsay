<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 
class Sitecount {
	
	public $CI;
	public $logid = 0;
	
    public function __construct()
	{
		$this->CI = &get_instance();
		
		$this->logid = get_num( $this->logid ,0);
	}
	
	public function allinfo()
	{
		$this->CI->db->from('online_cnt');
		$this->CI->db->limit(1);
		$online_cnt = $this->CI->db->get()->row();
		if( empty($online_cnt) )
		{
			$this->CI->db->set('totalip','0');
			$this->CI->db->set('totalpv','0');
			$this->CI->db->set('yesdayip','0');
			$this->CI->db->set('yesdaypv','0');
			$this->CI->db->set('countday','0');
			$this->CI->db->set('day2ip','0');
			$this->CI->db->set('day2pv','0');
			$this->CI->db->insert('online_cnt');
		}

		$this->CI->db->select('startime');
		$this->CI->db->from('online_iplist');
		$this->CI->db->where('startime');
		$this->CI->db->order_by('startime','desc');
		$this->CI->db->limit(3);
		$Show = $this->CI->db->get()->row();
		if ( $Show )
		{
			if ( date("d") != substr($Show->startime,8,2) )
			{
				$sql1 = $this->get_pv();
				if( !empty($sql1) )
				{
					$yesdayip = $sql1->shuip;
					$yesdaypv = $sql1->shupv;
					
					$this->CI->db->set('shuip',0);
					$this->CI->db->set('shupv',0);
					$this->CI->db->update('online_shu');
				}
				else
				{
					$yesdayip = 0;
					$yesdaypv = 0;
					
					$this->update_pv();
				}

				$this->CI->db->from('online_cnt');
				$this->CI->db->limit(1);
				$Sql2 = $this->CI->db->get()->row();
				$day2ip = $Sql2->yesdayip; 
				$day2pv = $Sql2->yesdaypv; 
				
				$this->CI->db->set('totalip','totalip+'.$yesdayip,false);
				$this->CI->db->set('totalpv','totalpv+'.$yesdaypv,false);
				$this->CI->db->set('yesdayip','yesdayip+'.$yesdayip,false);
				$this->CI->db->set('yesdaypv','yesdaypv+'.$yesdaypv,false);
				$this->CI->db->set('countday','countday+1',false);
				$this->CI->db->set('day2ip',$day2ip,false);
				$this->CI->db->set('day2pv',$day2pv,false);
				$this->CI->db->update('online_cnt');

				$this->CI->db->delete('iplist');
				$this->CI->db->delete('urls');
				$this->CI->db->delete('comes');
			}
		}
	}

	public function iplist($ip='',$system='',$browser='',$url='')
	{
		$this->CI->db->from('online_iplist');
		$this->CI->db->where('uid', $this->logid );
		$this->CI->db->where('ip',$ip);
		$this->CI->db->order_by('startime','desc');
		$this->CI->db->limit(1);
		if ( $this->CI->db->get()->row() )
		{
			$this->CI->db->set('lasttime','now()',false);
			$this->CI->db->set('pv','pv+1',false);
			$this->CI->db->set('url',$url);
			$this->CI->db->where('uid', $this->logid );
			$this->CI->db->where('ip',$ip);
			$this->CI->db->update('online_iplist');
		}
		else
		{
			//新IP记录
			$this->CI->db->set('id','');
			$this->CI->db->set('ip',$ip);
			$this->CI->db->set('uid', $this->logid );
			$this->CI->db->set('system',$system);
			$this->CI->db->set('browser',$browser);
			$this->CI->db->set('url',$url);
			$this->CI->db->set('startime','now()',false);
			$this->CI->db->set('lasttime','now()',false);
			$this->CI->db->set('pv',1);
			$this->CI->db->insert('online_iplist');
			
			$this->CI->db->set('shuip','shuip+1',false);
			$this->CI->db->update('online_shu');
		}
	}

	public function iplist_Sql($uid='')
	{
		$this->CI->db->from('online_iplist');
		if( is_num($uid) )
		{
			$this->CI->db->where('uid',$uid);
		}
		$this->CI->db->order_by('id','desc');
		return $this->CI->db->getSQL();
	}

	public function iplist_Sql_merger($uid='')
	{
		$br = '<br/>';
		$this->CI->db->select('id');
		$this->CI->db->select('ip');
		$this->CI->db->select('group_concat(system order by system separator "'.$br.'") as system',false);
		$this->CI->db->select('group_concat(browser order by  browser separator "'.$br.'") as browser',false);
		$this->CI->db->select('group_concat(url order by url separator "'.$br.'") as url',false);
		$this->CI->db->select('group_concat(system order by system separator "'.$br.'") as system',false);
		$this->CI->db->select('startime');
		$this->CI->db->select('lasttime');
		$this->CI->db->select_sum('pv');
		$this->CI->db->select('group_concat(uid order by uid separator "'.$br.'") as uid',false);
		
		$this->CI->db->from('online_iplist');
		
		if( is_num($uid) )
		{
			$this->CI->db->where('uid',$uid);
		}
		$this->CI->db->group_by('ip');
		$this->CI->db->order_by('id','desc');
		return $this->CI->db->getSQL();
	}
	public function urls_Sql($uid='')
	{
		$this->CI->db->from('online_urls');
		if( is_num($uid) )
		{
			$this->CI->db->where('uid',$uid);
		}
		else
		{
			$this->CI->db->order_by('num','desc');
		}
		$this->CI->db->order_by('id','desc');
		return $this->CI->db->getSQL();
	}

	public function comes_Sql()
	{
		$this->CI->db->from('online_comes');
		$this->CI->db->order_by('num','desc');
		$this->CI->db->order_by('id','desc');
		return $this->CI->db->getSQL();
	}


	public function pases($url)
	{ 
		$url = ( $url=='' ) ? "直接输入访问" : $url ;
		$url = ( strlen($url)>225 ) ? substr($url,0,225) : $url;
		
		$this->CI->db->from('online_urls');
		$this->CI->db->where('uid', $this->logid );
		$this->CI->db->where('url',$url);
		$this->CI->db->limit(1);
		if ( $this->CI->db->get()->row() )
		{
			$this->CI->db->set('num','num+1',false);
			$this->CI->db->where('url',$url);
			$this->CI->db->update('online_urls');
		}
		else
		{
			$this->CI->db->set('uid', $this->logid );
			$this->CI->db->set('url',$url);
			$this->CI->db->set('num',1);
			$this->CI->db->set('thisdate','now()',false);
			$this->CI->db->insert('online_urls');
		}
	}
	
	public function online($online=10)
	{
		$this->CI->db->from('online_iplist');
		$this->CI->db->where('lasttime >','date_sub(now(),interval '.$online.' minute)',false);
		$num = $this->CI->db->count_all_results();
		return $online = ( !empty($num) ) ? $num : '0';
	}
	
	
	public function update_pv()
	{
		$pv = $this->get_pv();
		if( !empty($pv) )
		{
			$this->CI->db->set('shupv','shupv+1',false);
			$this->CI->db->update('online_shu');	
		}
		else
		{
			$this->CI->db->set('shupv','0');
			$this->CI->db->insert('online_shu');		
		}
	}
	
	public function get_pv()
	{
		$this->CI->db->from('online_shu');
		return $this->CI->db->get()->row();
	}
	

	public function todayip()
	{
		$this->CI->db->from('online_shu');
		$this->CI->db->limit(1);
		$today = $this->CI->db->get()->row();
		if( !empty($today) )
		{
			$todayip = $today->shuip;
			if($todayip>$today->shugo)
			{
				$this->CI->db->set('shugo',$todayip);
				$this->CI->db->update('online_shu');
			}	
		}
	}

	public function clinetOS()
	{
		$this->CI->load->library('user_agent');
		return $this->CI->agent->platform();
	}

	public function Browser()
	{ 
		$this->CI->load->library('user_agent');
		if ($this->CI->agent->is_browser())
		{
			$agent = $this->CI->agent->browser().' '.$this->CI->agent->version();
		}
		elseif ($this->CI->agent->is_robot())
		{
			$agent = $this->CI->agent->robot();
		}
		elseif ($this->CI->agent->is_mobile())
		{
			$agent = $this->CI->agent->mobile();
		}
		else
		{
			$agent = 'Unfied User Agent';
		}
		return $agent;
	}

	public function ClinetIp()
	{
		return $this->CI->input->ip_address();
	}

	public function comes($url)
	{
		$gotourl = ( $url == '' ) ? 'http://' . $_SERVER['HTTP_HOST'] : $url;
		if(!empty($url))
		{
			$dnsname0 = explode('//',$url); 
			$dnsname1 = explode('/',$dnsname0[1]); 
			$dnsname  = $dnsname1[0];
		}
		$dnsname = ( $url == '' ) ? '直接输入访问' : $dnsname; 
		
		$this->CI->db->from('online_comes');
		$this->CI->db->where('uid', $this->logid );
		$this->CI->db->where('vcome',$dnsname);
		$this->CI->db->limit(1);
		$rs = $this->CI->db->get()->row();
		if($rs)
		{
			$this->CI->db->set('num','num+1',false);
			$this->CI->db->set('vlast',$gotourl);
			$this->CI->db->where('vcome',$dnsname);
			$this->CI->db->update('online_comes');
		}
		else
		{
			$this->CI->db->set('uid', $this->logid );
			$this->CI->db->set('vcome',$dnsname);
			$this->CI->db->set('num',1);
			$this->CI->db->set('vlast',$gotourl);
			$this->CI->db->insert('online_comes');
		}	
	}
	

}

?>