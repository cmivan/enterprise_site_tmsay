<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_login extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		//表单配置
		$this->data['formTO']->url = site_system('system_login/do_login',1);
		$this->data['formTO']->backurl = site_system('system_defaults',1);
		//输出到视窗
		$this->load->view_system('system_login',$this->data);
	}
	
	
	
	//验证登录
	function do_login()
	{
		$user = noSql($this->input->post('user'));
		$pass = $this->input->post('pass');
		$code = $this->input->post('code');
		$cm_login_code = $this->session->userdata('cm_login_code');
		if($user==''){
			json_form_no('请输入用户名!');
		}elseif($pass==''){
			json_form_no('请输入登录密码!');
		}elseif($code==''){
			json_form_no('请输入验证码!');
		}elseif(md5($code)!=$cm_login_code){
			json_form_no('输入的验证码有误!');
		}else{
			//开始验证
			$pass = pass_system($pass);

			$this->db->select('id,super,username,password');
			$this->db->from('system_user');
			$this->db->where('ok',0);
			$this->db->where('username',$user);
			$this->db->where('password',$pass);
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			
			if(!empty($rs))
			{
				//二重审核
				if(($rs->password==$pass)&&($rs->username==$user))
				{
					//登录成功,记录所需的信息
					$data['logid'] = $rs->id;
					$data['super'] = $rs->super;
					$this->session->set_userdata("cm_power",$data);
					json_form_yes('登录成功!');
				}
			}
			
			$this->session->unset_userdata('cm_login_code');
			json_form_no('登录失败!');
		}
	}
	
	
	
	//验证码
	function verifycode()
	{
		$x_size = 65;
		$y_size = 27;
		if(function_exists("imagecreate"))
		{
			$aimg = imagecreate($x_size,$y_size);
			$back = imagecolorallocate($aimg, 255, 255, 255);
			$border = imagecolorallocate($aimg, 0, 0, 0);
			imagefilledrectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $back);
			$txt = "0123456789";
			$txtlen=strlen($txt);

			$thetxt="";
			for($i=0;$i<4;$i++)
			{
				$randnum=mt_rand(0,$txtlen-1);
				$randang=mt_rand(-20,20);       //文字旋转角度
				$rndtxt=substr($txt,$randnum,1);
				$thetxt.=$rndtxt;
				$rndx = mt_rand(4,8);
				$rndy = mt_rand(2,5);
				$colornum1=($rndx*$rndx*$randnum)%255;
				$colornum2=($rndy*$rndy*$randnum)%255;
				$colornum3=($rndx*$rndy*$randnum)%255;
				$newcolor=imagecolorallocate($aimg, $colornum1, $colornum2, $colornum3);
				imageString($aimg,12,$rndx+$i*15,2+$rndy,$rndtxt,$newcolor);
			}
			unset($txt);
			$thetxt = strtolower($thetxt);
			$this->session->set_userdata("cm_login_code",md5($thetxt));
			imagerectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $border);

			$newcolor="";
			$newx="";
			$newy="";
			$pxsum=55;     //干扰像素个数
			for($i=0;$i < $pxsum;$i++)
			{
				$newcolor = imagecolorallocate($aimg, mt_rand(0,254), mt_rand(0,254), mt_rand(0,254));
				imagesetpixel($aimg,mt_rand(0,$x_size-1),mt_rand(0,$y_size-1),$newcolor);
			}
			header("Pragma:no-cache");
			header("Cache-control:no-cache");
			header("Content-type: image/png");
			imagepng($aimg);
			imagedestroy($aimg);
			exit;
		}
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */