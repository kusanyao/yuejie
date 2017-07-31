<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class Common extends Base
{
    private $AccessKeyID = 'LTAIW5r4gVmjja3s';
    private $AccessKeySecret = '8EWhGjO3ePysq1lTfCytBFY8z8YOPW';

	/**
	 * 发送验证码
    stdClass Object ( 
        [Message] => OK 
        [RequestId] => 5406C299-2BE7-4CFF-9C1D-F4147B646660 
        [BizId] => 109095486449^1112167037663 
        [Code] => OK 
    )
    stdClass Object ( 
        [Message] => 签名不合法 
        [RequestId] => 35C17431-A6D1-4D8C-9160-889D65BBE894 
        [Code] => isv.SMS_SIGNATURE_ILLEGAL 
    )
    @param $type register,login,
	 */
	public function ajax_send_code()
    {
    	$phone = input('param.phone/s');
        $type  = input('param.type/s');
    	if(empty($phone) || !is_numeric($phone) || strlen($phone) != 11){
            return json(array(
                'code'  => 206,
                'error' => '错误的手机号',
            ));
        }
        $response = model('Common','logic')->sendPhoneCode($type,$phone);
        if($response->Code == 'OK'){
            return json(array(
                'code'   => 200,
                'result' => 'OK'
            ));
        }else{
            return json(array(
                'code'   => 500,
                'result' => $response->Message
            ));
        }
    }

    /**
     * 验证手机验证码
     */
    public function ajax_check_code()
    {
    	$phone = input('param.phone/s');
        $code  = input('param.code/s');
        if(empty($phone) || !is_numeric($phone) || strlen($phone) != 11){
            return json(array(
                'code'  => 206,
                'error' => '错误的手机号',
            ));
        }
        if(empty($code) || !is_numeric($code) || strlen($code) != 5){
            return json(array(
                'code'  => 206,
                'error' => '错误验证码',
            ));
        }
        $res = model('Common','logic')->checkPhoneCode($phone,$code);
        if($res){
            return json(array(
                'code'  => 200,
                'result' => 'OK',
            ));
        }else{
            return json(array(
                'code'  => 206,
                'error' => '错误验证码',
            ));
        }
    }

    public function ajax_check_img_code()
    {
        $code = input('param.code/s');
        $res  = captcha_check($code);
    }

    /**
     * 图片验证码
     */
    public function ajax_get_code()
    {
        return captcha_src();
    }
}