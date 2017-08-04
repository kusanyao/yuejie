<?php
namespace app\mobile\validate;
use think\Validate;
use think\Session;

class User extends Validate
{
    protected $rule = [
        'us_phone|手机号'    => 'require|number|length:11|checkPhone',
    	'us_username|用户名' => 'require|length:4,25|checkUsername',
	    'us_password|密码'   => 'require|length:6,15',
        'us_wechat'          => 'require|number',
        'us_email|email'     => 'require|email|length:4,25',
    ];

    protected $message  =   [
        'us_phone.require' => '手机号不能为空',
        'us_phone.number'  => '手机号必须全是数字',
        'us_username.min'  => '用户名不能少于4个字符',
        'us_username.max'  => '名称最多不能超过25个字符',
        'us_email'         => '邮箱格式错误',
    ];

    protected $scene = [
        'phone_reg'  => ['us_phone','us_username','us_password'],
        'wechat_reg' => ['us_phone','us_wechat'],
    ];

    protected function checkPhone($value,$rule,$data)
    {
        // 校验手机号是否完成了短信验证
        $res = model('Common','logic')->checkedPhone($value);
        if(!$res){
            return '请先验证手机验证码';
        }
        // 校验手机号是否被占用
        $user = model('user')->getUserByPhone($value);
        if( empty($user) ){
            return true;
        }else{
            return $value.'已经存在';
        }
    }

    // 自定义验证规则
    protected function checkUsername($value,$rule,$data)
    {
        // 校验用户名是否使用了非法字符，并返回告知用户
        if( preg_match_all('/[^a-zA-Z0-9!#$%^&*\.()\x80-\xff]/',$value,$illegal)){
            return '用户名中不能包含“'.implode('，', array_unique($illegal[0]) ).'”字符';
        }
        // 校验用户名是否被占用
    	$user = model('user')->getUserByUsername($value);
    	if( empty($user) || (isset($data['us_id']) &&  $user['us_id'] == $data['us_id']) ){
    		return true;
    	}else{
    		return $value.'已经存在';
    	}
    }

    // 自定义验证规则
    protected function checkEmail($value,$rule,$data)
    {
        $user = model('user')->getUserByEmail($value);
        if( empty($user) || $user['us_id'] == $data['us_id'] ){
            return true;
        }else{
            return $value.'已经存在';
        }
    }   

    protected function checkWechat($value,$rule,$data)
    {
        $wechat = model('wechat')->getWechatById($value);
        if(empty($wechat)){
            return '不存在该微信号';
        }
        $user = model('user')->getUserByWechatId($value);
        if( empty($user) || $user['us_id'] == $data['us_id'] ){
            return true;
        }else{
            return '该微信号已经绑定了其他用户';
        }
    }
}