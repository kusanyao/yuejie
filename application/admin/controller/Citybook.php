<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Citybook extends Base
{
	
	public function items()
	{
		$pid = input('param.pid/d');
		$items = model('Citybook')->getItemsByPid($pid);
		return json(array(
			'code'   => 200,
			'result' => $items
		));
	}
}