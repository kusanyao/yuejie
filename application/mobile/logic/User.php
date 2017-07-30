<?php
namespace app\mobile\logic;
use think\Session;

class User
{
	/**
	 * 手机号注册
	 */
	public function register($user,$userinfo=[])
	{
		if(empty($data) || empty($data['us_phone']) || empty($data['us_username']) ){
			return false;
		}
		if(isset($data['us_password'])){
			$data['us_password'] = md5($data['us_password']);
		}
		$id = Db::name('User')->insertGetId($data);
		if($id > 0){
			if(empty($userinfo)){
				$userinfo = array(
					'ui_avatar' => 'user_avatar/default.png',
					'ui_gender' => 0,
				);
			}
			model('Userinfo')->saveUserinfo($id,$userinfo);
			return $this->loginAuth($id);
		}else{
			return false;
		}
	}

	public function login($account,$password)
	{
		if(){
			
		}
	}

	/**
	 * 获取一个可用的用户名
	 */
	public function getAllowUsername($username)
	{
		$suffix = '';
		$username = $username ? $username : 'yuejie-';
		while (1) {
			$tryUsername = $username.$suffix;
			$user = model('User')->getUserByUsername($tryUsername);
			if(empty($user)){
				return $tryUsername;
			}
			$suffix = intval($suffix)+1;
		}		
	}

	/**
	 * 认证登录
	 */
	public function loginAuth($userId)
	{
		$user = model('User')->getUserById($userId);
		if(empty($user)){
			return false;
		}
		$userinfo = model('Userinfo')->getUserinfoById($userId);
		if(empty($userinfo)){

		}
		return Session::set('user',array(
    		'id' => $user['ad_id'],
    		'username' => $user['ad_username'],
    	));
	}
}