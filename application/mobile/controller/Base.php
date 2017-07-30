<?php
namespace app\mobile\controller;
use think\Session;
use think\Request;

class Base extends \think\Controller
{
    public function __construct()
	{
		parent::__construct();
	}

	public function __get($method)
	{
		if($method == 'wechat'){
			if(!isset($this->wechat)){
				$this->wechat = Session::get('wechat');
			}
			return $this->wechat;
		}
		if($method == 'user'){
			if(!isset($this->user)){
				$this->user = Session::get('user');
			}
			return $this->user;
		}
	}
}
