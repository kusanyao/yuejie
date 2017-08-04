<?php
namespace app\mobile\logic;
use think\Session;
use think\Db;
use think\Validate;

class User
{
	/**
	 * 手机号注册
	 */
	public function register($data,$userinfo=[])
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
		if(Validate::is($account,'email')){
			$user = model('User')->getUserByEmail($account);
		}elseif(is_numeric($account) && strlen($account) == 11){
			$user = model('User')->getUserByPhone($account);
		}else{
			$user = model('User')->getUserByUsername($account);
		}
		if(empty($user) || $user['us_password'] != md5($password)){
			return false;
		}
		model('user')->recordLoginLog($user['us_id'],$account,1);
		return $this->loginAuth($user['us_id']);
	}

	/**
	 * 获取一个可用的用户名
	 */
	public function getAllowUsername($username)
	{
		if( preg_match_all('/[^a-zA-Z0-9!#$%^&*\.()\x80-\xff]/',$username,$illegal)){
            $username = str_replace($illegal[0],'',$username);
        }
        $suffix = '';
        $username = $username ? $username : 'yuejie-';
		while (1) {
			$tryUsername = $username.$suffix;
			$user = model('User')->getUserByUsername($tryUsername);
			if(empty($user)){
				return $tryUsername;
			}
			if($suffix == ''){
				$lastUser = model('User')->getLastUser();
				$suffix = $lastUser['us_id'];
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
		$res = Session::set('user',array(
    		'id'       => $user['us_id'],
    		'username' => $user['us_username'],
    	));
		return true;
	}
}