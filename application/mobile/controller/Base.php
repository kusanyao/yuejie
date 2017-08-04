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

	protected function getPage($key='page')
	{
		$page = input('param.'.$key.'/d');
		return ($page > 0 ) ? $page : 1;
	}
	protected function getLimit($key='rows')
	{
		$limit = input('param.'.$key.'/d');
		return ($limit > 0 && $limit <= 50) ? $limit : 20;
	}
	protected function getOffset()
	{
		$limit = $this->getLimit();
		$page  = $this->getPage();
		return ($page - 1) * $limit;
	}
	protected function getIds($key='ids')
	{
		$ids = input('param.'.$key.'/s',[]);
		$idsArr = json_decode($ids,true);
		foreach ($idsArr as &$v) {
			$v = intval($v);
		}
		return $idsArr;
	}
}
