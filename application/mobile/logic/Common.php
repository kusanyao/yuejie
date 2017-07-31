<?php
namespace app\mobile\logic;
use think\Session;
use dysmsapi\Dysmsapi;
class Common
{
	/**
	 * 发送验证码
	 */
	public function sendPhoneCode($type,$phone)
	{
		switch ($type) {
            case 'register':
                $tplId = 'SMS_80155102';
                break;
            case 'login':
                $tplId = 'SMS_80155102';
                break;
            default:
                return json(array(
                    'code'  => 404,
                    'error' => '',
                ));
                break;
        }
        $dysmsapi = new Dysmsapi($this->AccessKeyID,$this->AccessKeySecret);
        $code = mt_rand(10000,99999);
        $this->setPhoneCode($phone,$code);
        $response = $dysmsapi->sendSms(
            "枯三尧", // 短信签名
            $tplId,   // 短信模板编号
            $phone,   // 短信接收者
            Array(          // 短信模板中字段的值
                "number" => $code,
            )
        );
        return $response;
	}

	/**
	 * 发送验证码后记录手机号和验证码
	 */
	public function setPhoneCode($phone,$code)
	{
		return Session::set('com_yuejie_www_phone_code_'.$phone,array(
			'code'   => $code,
			'expire_in' => time()+180,
		));
	}

	/**
	 * 判断验证码是否验证通过
	 */
	public function checkPhoneCode($phone,$code)
	{
		$codeArr = Session::get('com_yuejie_www_phone_code_'.$phone);
		if(empty($codeArr) || $codeArr['code'] != $code || $codeArr['expire_in'] < time()){
			return false;
		}
		Session::set('com_yuejie_www_checked_phone',$phone);
		return true;
	}

	/**
	 * 已经验证通过的手机号
	 */
	public function checkedPhone($phone)
	{
		$sessionPhone = Session::get('com_yuejie_www_checked_phone');
        if($sessionPhone == $phone){
            return true;
        }
        return false;
	}
}