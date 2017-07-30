<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class Wechat extends Base
{
	public function login()
	{
		if($this->member || $this->wechat){
            return redirect('/');
        }
		$redirect_uri = input('param.redirect_uri/s');
		$wechatInfo = model('Wechat','logic')->getCode($redirect_uri);
		if($redirect_uri){
			return redirect($redirect_uri);
		}elseif($wechatInfo['redirect_uri']){
			return redirect($wechatInfo['redirect_uri']);
		}else{
			return redirect('/');
		}
	}

	/**
	 * 微信回调地址
	 */
	public function callback()
	{
		$code = input('param.code/s');
		$tokenInfo = model('Wechat','logic')->getTokenByCode($code);
		$userInfo = model('Wechat','logic')->getUserInfo($code);

	}

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
            'ui_avatar' => $wechat['we_headimgurl']
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