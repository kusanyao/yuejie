<?php
namespace app\admin\logic;
use think\Db;

class Object
{
	public function takeoverCallback($object)
	{
		if(is_numeric($object)){
			return Db::name('object')->where('ob_id',intval($object))->update(['ob_state'=>1]);
		}elseif(is_array($object)){
			foreach ($object as &$v) {
				$v = intval($v);
			}
			return Db::name('object')->where('ob_id','in',$object)->update(['ob_state'=>1]);
		}		
	}
}