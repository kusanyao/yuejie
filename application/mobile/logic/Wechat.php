<?php
namespace app\mobile\logic;
use think\Session;

class Wechat
{
	private $appid = '';
	private $appids = '';

	private $getCodeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';

	private $getTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';

	private $refreshTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN ';

	private $getUserinfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';

	private $getJsTicketUrl = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi';

	private $Sessionkey = 'com.yuejie.m.wechat_info';



	public function getCode($return_url)
	{	
		// 判断是否已经拿到了微信用户信息
		$wechatInfo = Session::get($this->Sessionkey);
		if(!empty($wechatInfo)){
			return $wechatInfo;
		}
		$wechatInfo['return_url'] = $return_url;
		Session::set($this->Sessionkey,$wechatInfo);
		$callback = 'http://m.yuejie.com/wechat/callback';
		$url = '';
		return redirect($url);
	}

	/**
	 * 获取token
	 */
	public function getTokenByCode($code)
	{
		// $url = 
		$token = [];
		$wechatInfo = Session::get($this->Sessionkey);
		$wechatInfo['token'] = $token;
		Session::set($this->Sessionkey,$wechatInfo);
		model('Wechat')->saveToken($token);
		return $token;
	}

	/**
	 * 获取微信用户的详细信息
	 */
	public function getUserInfo()
	{
		$userinfo = [];
		$wechatInfo = model('Wechat')->saveWechat($userinfo);
		$wechatInfo_session = Session::get($this->Sessionkey);
		$wechatInfo['wechatInfo'] = $wechatInfo;
		Session::set($this->Sessionkey,$wechatInfo_session);
		return $wechatInfo;
	}

	/**
	 * 刷新token
	 */
	public function refreshToken()
	{

	}
}