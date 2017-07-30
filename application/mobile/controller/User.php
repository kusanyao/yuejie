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
        $value = "asdf@@@@";
        
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
        $result = model('User.register')->register($data);
        return json(array(
            'code'  => 200,
            'error' => $result
        ));
    }

    /**
     * 
     */
    public function ajax_login()
    {
    	if($this->user){
            return json(array(
                'code'  => 204,
                'error' => ''
            ));
        }
        if(isWechat()){
            return json(array(
                'code'  => 206,
                'error' => ''
            ));
        }
        $account  = input('param.account/s');
        $password = input('param.password/s');
        if(empty($account) || empty($password)){
            return json(array(
                'code'  => 206,
                'error' => ''
            ));
        }
        $result = model('User','logic')->login($account,$password);
        return json(array(
            'code'  => 200,
            'error' => ''
        ));
    }

}