<?php
namespace app\admin\controller;
use think\Db;
use think\Session;

class Member extends Base
{
    public function login()
    {
    	if(request()->isGet()){
        	return view();
        }
        $username = input('param.username/s');
        $password = input('param.password/s');
        if(empty($username) || empty($password)){
        	return json(array(
				'code'  => 206,
				'error' => '请输入正确的用户名和密码'
			));
        }

        $admin = Db::name('admin')->where('ad_username',$username)->find();
        if(empty($admin) || $admin['ad_password'] != $password){
        	return json(array(
				'code'  => 404,
				'error' => '用户名或者密码错误'
			));
        }else{
        	Session::set('admin',array(
        		'id' => $admin['ad_id'],
        		'username' => $admin['ad_username'],
        	));

        	return json(array(
				'code'  => 200,
				'result' => 'ok'
			));
        }
    }
}
