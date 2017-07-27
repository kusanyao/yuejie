<?php
namespace app\index\controller;
use think\Session;

class Base extends \think\Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->member = Session::get('member');
	}
}
