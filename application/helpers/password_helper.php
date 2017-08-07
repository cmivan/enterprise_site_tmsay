<?php

/*密码加密处理函数*/

//普通用户密码加密处理
function pass_user($password)
{
	$password = md5(md5($password));
	return $password;
}

//企业用户密码加密处理
function pass_company($password)
{
	$password = md5($password.'CM.web.system@PC');
	$password = md5($password.'PC@^#*');
	$password = md5($password);
	return $password;
}

//系统用户密码加密处理
function pass_system($password)
{
	$password = md5('CM.web.system v.10@PS'.$password);
	$password = md5('#%hFH@%^@#~$m'.$password);
	$password = md5($password);
	return $password;
}

//关键内容加密,防止串改(当天有效)
function pass_key($key)
{
	$key = md5($key.date('Ymd')); //当天有效
	$key = md5('CM.web.system v.10@PK'.$key);
	$key = md5('#%%JJ0sR~$35'.$key);
	$key = md5($key);
	return $key;
}


//关键内容加密,防止串改(当月有效)
function pass_token($key)
{
	$key = md5($key.date('Ym')); //当天月有效
	$key = md5('CM.web.system v.10@token'.$key);
	$key = md5('#%2$%Vwcm'.$key);
	$key = md5($key);
	return $key;
}

?>