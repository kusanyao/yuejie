<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class Wechat extends Base
{
    /**
     * 微信注册页面
     */
    public function register()
    {
        $redirect_uri = input('param.redirect_uri/s');
        if($this->user){
            if($redirect_uri){
                return redirect($redirect_uri);
            }
            return redirect('/');
        }
        if(!$this->wechat){
            Session::set('wechat_register_redirect_uri',$redirect_uri);
            $redirect_uri = urlencode('/wechat/register');
            return redirect('/wechat/login?redirect_uri='.$redirect_uri);
        }
        return view('register');
    }

	public function login()
	{
        $redirect_uri = input('param.redirect_uri/s');
		if($this->user || $this->wechat){
            if($redirect_uri){
                return redirect($redirect_uri);
            }
            return redirect('/');
        }
		model('Wechat','logic')->getCode($redirect_uri);
	}



	/**
	 * 微信回调地址
	 */
	public function callback()
	{
		$code = input('param.code/s');
		$tokenInfo = model('Wechat','logic')->getTokenByCode($code);
        if($tokenInfo == false){
            die('false');
        }
		$userInfo = model('Wechat','logic')->getUserInfo($tokenInfo);
	}

    /**
     * 微信浏览器注册地址
     */
	public function ajax_register()
    {
        if($this->user){
            return json(array(
                'code'  => 204,
                'error' => ''
            ));
        }
        if(!$this->wechat){
            return json(array(
                'code'  => 206,
                'error' => ''
            ));
        }
        $phone  = input('param.phone/s');
        $userModel = model('User');
        $wechat = model('Wechat')->getWechatById($this->wechat['id']);
        $user = array(
            'us_phone'    => input('param.phone/s'),
            'us_username' => $userModel->getAllowUsername($wechat['we_nickname']),
            'us_wechat'   => $this->wechat['id']
        );
        $userinfo = array(
            'ui_avatar' => $wechat['we_headimgurl'],
            'ui_gender' => $wechat['we_sex'],
        );
        $result = $this->validate($user,'User.wechat_reg');
        if(true !== $result){
            return json(array(
                'code'  => 104,
                'error' => $result
            ));
        }
        $result = $userModel->register($user,$userinfo);
        return json(array(
            'code'  => 200,
            'error' => $result
        ));
    }

    /**
     * 绑定已有的帐号
     */
    public function bind()
    {
    	if($this->user){
            return json(array(
                'code'  => 204,
                'error' => ''
            ));
        }
        if(!$this->wechat){
            return json(array(
                'code'  => 206,
                'error' => ''
            ));
        }
    }
}