<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class User extends Base
{
    public function __construct()
    {
        parent::__construct();
    }



	public function register()
	{
        if($this->user){
            return redirect('/');
        }
        if(isWechat()){
            return redirect('/wechat/login');
        }
        return view('register');
	}

    public function login()
    {
        if($this->user){
            return redirect('/');
        }
        if(isWechat()){
            return redirect('/wechat/login');
        }

        return view('login');
    }

    /**
     * 注册请求
     */
    public function ajax_register()
    {        
        $data = array(
            'us_phone'    => input('param.phone/s'),
            'us_username' => input('param.username/s'),
            'us_password' => input('param.password/s'),
        );

        $result = $this->validate($data,'User.phone_reg');
        if(true !== $result){
            return json(array(
                'code'  => 104,
                'error' => $result
            ));
        }
        $result = model('User','logic')->register($data);
        return json(array(
            'code'   => 200,
            'result' => 'OK'
        ));
    }

    /**
     * 登录请求
     */
    public function ajax_login()
    {
    	if($this->user){
            return json(array(
                'code'  => 201,
                'error' => '您已经登录了'
            ));
        }
        if(isWechat()){
            return json(array(
                'code'  => 206,
                'error' => '请先通过微信登录'
            ));
        }
        $account  = input('param.account/s');
        $password = input('param.password/s');
        if(empty($account) || empty($password)){
            return json(array(
                'code'  => 206,
                'error' => '帐号或密码为空'
            ));
        }
        $result = model('User','logic')->login($account,$password);
        if($result){
            return json(array(
                'code'  => 200,
                'result' => 'ok'
            ));
        }
        return json(array(
            'code'  => 206,
            'result' => '用户名或者密码错误'
        ));
    }

    /**
     * 获取当前登录的用户信息
     */
    public function ajax_userinfo()
    {
        if(!$this->user){
            return json(array(
                'code'  => 201,
                'error' => '您还没有登录呢'
            ));
        }
        $userModel = model('User');
        $user      = $userModel->getUserById($this->user['id']);
        $userinfo  = model('Userinfo')->getUserinfoById($this->user['id']);
        $loginDays = $userModel->getLoginDays($this->user['id']);
        unset($user['us_password']);
        return json(array(
            'code'  => 200,
            'result' => array(
                'user'     => $user,
                'userinfo' => $userinfo,
                'loginDays' => $loginDays
            )
        ));
    }
}