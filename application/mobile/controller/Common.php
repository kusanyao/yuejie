<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class User extends Base
{
	/**
	 * 发送验证码
	 */
	public function ajax_send_code()
    {
    	$phone = input('param.phone/s');
    	
    }

    /**
     * 验证手机验证码
     */
    public function ajax_check_code()
    {
    	$phone = input('param.name/s');
    }

    /**
     * 图片验证码
     */
    public function ajax_get_code()
    {

    }
}