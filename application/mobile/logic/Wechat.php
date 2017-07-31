<?php
namespace app\mobile\logic;
use think\Session;

class Wechat
{
	private $appid  = 'wxa4ecb0681fba754c';
	private $appsecret = '093743fe335eb4371e6001e342d05cbf';

	private $getCodeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';

	private $getTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';

	private $refreshTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN ';

	private $getUserinfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';

	private $getJsTicketUrl = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi';

	private $Sessionkey = 'com.yuejie.m.wechat_return_url';


	public function getCode($return_url)
	{	
		// 判断是否已经拿到了微信用户信息
		Session::set($this->Sessionkey,$return_url);
		$callback = urlencode('http://www.inklego.com/wechat/callback');
		$url = str_replace(['APPID','REDIRECT_URI','SCOPE'], 
			[$this->appid,$callback,'snsapi_userinfo'], $this->getCodeUrl);
		header("location: ".$url);
	}

	/**
	 * 获取token
	 */
	public function getTokenByCode($code)
	{
		$url = str_replace(['APPID','SECRET','CODE'], 
			[$this->appid,$this->appsecret,$code], $this->getTokenUrl);
		$token = $this->httpGet($url);
		if(isset($token['errcode'])){
			return false;
		}
		$wechatInfo['token'] = $token;
		model('Wechat')->saveToken($token);
		return $token;
	}

	/**
	 * 获取微信用户的详细信息
	 */
	public function getUserInfo($token)
	{
		$url = str_replace(['ACCESS_TOKEN','OPENID'], 
			[$token['access_token'],$token['openid']], $this->getUserinfoUrl);
		$userinfo = $this->httpGet($url);
		if(isset($userinfo['errcode'])){
			return false;
		}
		$wechatId = model('Wechat')->saveWechat($userinfo);
		if(!$wechatId){
			return false;
		}
		$userinfo['id'] = $wechatId;
		Session::set('wechat',$userinfo);
		$return_url = Session::get($this->Sessionkey);
		if($return_url){
			header("location: ".$return_url);
		}
		header("location: /");
	}

	/**
	 * 刷新token
	 */
	public function refreshToken()
	{

	}

	private function httpGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($curl, CURLOPT_URL, $url);
		$res = curl_exec($curl);
		curl_close($curl);
		return json_decode($res,true);
	}

	/*
	Array ( 
		[access_token] => zePHMKmdiu9JAe2-aqE08HhlUmx9BCzg0jG0GSikuD5FeUTpMNFxswHml7IthTYp98uF1YofDoYMI02SF8fbplBXwEXhmpYRbKDk02ph_O8 
		[expires_in] => 7200 
		[refresh_token] => 3ZhdkqRMXurrQ_zakMKoZMbpFoKJbgRSj-7TnwhFL_mAQ-C6B_pAFXZMKoGjuDmsidvNjnNbjbcXvsA7Si8NGfO5pHiGDlzp-HBygBPPY8Q 
		[openid] => ownYnw2la4EobC3nulfeMXcfCuNk [scope] => snsapi_userinfo 
		[unionid] => obTbe1UYj3QUMJOWuSsyblNtB5FA
	)
	Array ( 
		[errcode] => 40001 
		[errmsg] => invalid credential, access_token is invalid or not latest, hints: 
		[ req_id: I9OuGA0722s178 ] 
	)
	Array ( 
		[openid] => ownYnw2la4EobC3nulfeMXcfCuNk 
		[nickname] => 这个杀手不怕冷 
		[sex] => 1 
		[language] => zh_CN 
		[city] => 河源 
		[province] => 广东 
		[country] => 中国 
		[headimgurl] => http://wx.qlogo.cn/mmopen/bIB4mOvMJHmZxzKKUSh31mvHeicEh3yq1cxEIbeiagjaqIhuynzQhNekXLRtFNVnv61TTOvOzlNgJcUiaPHSiakMSuen6PMKCDj9/0 
		[privilege] => Array ( ) 
		[unionid] => obTbe1UYj3QUMJOWuSsyblNtB5FA 
	)
	*/
}