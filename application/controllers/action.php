<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	
	//登录
	function do_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if($username==''){
			json_form_no('请输入用户名!');
		}elseif($password==''){
			json_form_no('请输入登录密码!');
		}else{
			//开始验证
			$password = pass_user($password);
			$this->db->select('id,nicename,username,password,ok,hot');
			$this->db->from('users');
			$this->db->where('password', $password );
			$this->db->where('username', $username );
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				//二重审核
				if(($rs->password==$password)&&($rs->username==$username))
				{
					if( $rs->ok == 1 )
					{
						json_form_no('您的账号暂时无法登录,详情可电话咨询!');
					}
					
					$uid = $rs->id;
					
					//统计登录次数
					$this->db->set('logintime',dateTime());
					$this->db->set('loginIp',ip());
					$this->db->set('hits','hits+1',false);
					$this->db->where('id',$uid);
					$this->db->update('users');

					//登录记录存库
					$login_history = iptodata();
					$login_history['uid'] = $uid;
					$login_history['logintime'] = dateTime();
					$this->db->insert('login_history',$login_history);
					
					//登录成功,记录所需的信息
					$data['logid'] = $uid;
					$data['nicename'] = $rs->nicename;
					$data['username'] = $rs->username;
					$data['hot'] = $rs->hot;
					$this->session->set_userdata("user_power",$data);
					json_form_yes('登录成功!');
				}
			}
		}
		json_form_no('登录失败!');
	}
	
	//注册
	function do_reg()
	{
		//获取数据
		$nicename = noHtml($this->input->post("nicename"));
		$username = noHtml($this->input->post("username"));
		$password = $this->input->post("password");
		$email    = noHtml($this->input->post("email"));
		$tel      = noHtml($this->input->post("tel"));
		$mobile   = noHtml($this->input->post("mobile"));
		$sex      = noHtml($this->input->post("sex"));
		
		//检测数据是否符合要求
		if( empty($nicename) )
		{
			json_form_alt("请填写称呼!");
		}
		if( empty($username) )
		{
			json_form_alt("请填写用户名!");
		}
		if( $this->is_reg($username)==false )
		{
			json_form_alt("这个用户名已经被注册了!");
		}
		if( empty($password) )
		{
			json_form_alt("请填写密码!");
		}
		if( empty($email) )
		{
			json_form_alt("请填写邮箱!");
		}
		if( empty($mobile) )
		{
			json_form_alt("请填写手机!");
		}
		if( empty($sex) )
		{
			json_form_alt("请选择性别!");
		}

		//生成语句数组
		$data = array(
			  'nicename' => $nicename,
			  'username' => $username,
			  'password' => pass_user($password),
			  'email' => $email,
			  'tel' => $tel,
			  'mobile' => $mobile,
			  'sex' => $sex,
			  'regtime' => dateTime(),
			  'regip' => ip()
			  );
		
		//执行添加
		if( $this->db->insert('users',$data) )
		{
			json_form_yes("恭喜您!注册成功!"); 
		}
		else
		{
			json_form_no("很遗憾!注册可能失败!");
		}
	}

	
	//验证手机号是否已经被注册
	function is_reg($username='')
	{
		if( !empty($username) )
		{
			$this->db->from('users');
			$this->db->where('username',$username);
			if( $this->db->count_all_results()<=0)
			{
				return true;
			}
		}
		return false;
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */