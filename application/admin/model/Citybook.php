<?php
namespace app\admin\model;
use think\Db;

class Citybook
{
	
	public function getItemsByLevel($level=1)
	{
		return Db::name('citybook')->where('cb_level',1)->select();
	}

	public function getItemsByPid($pid)
	{
		return Db::name('citybook')->where('cb_pid',$pid)->select();
	}
}