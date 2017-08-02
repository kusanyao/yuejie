<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Area extends Base
{
	
	public function items()
	{
		$pid = input('param.pid/d');
		$items = model('Area')->getItemsByPid($pid);
		return json(array(
			'code'   => 200,
			'result' => $items
		));
	}
}