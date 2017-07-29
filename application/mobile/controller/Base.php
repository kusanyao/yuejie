<?php
namespace app\mobile\controller;
use think\Session;
use think\Request;

class Base extends \think\Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->member = Session::get('user');
		$controller = Request::instance()->controller();
		$action = Request::instance()->action();
		$isLogin = ($controller == 'Member' && $action == 'login');
		if(empty($this->member) && !$isLogin ){
			header("Location: /member/login"); 
		}elseif(!empty($this->member) && $isLogin){
			header("Location: /"); 
		}
	}
}
