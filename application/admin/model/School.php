<?php
namespace app\admin\model;
use think\Db;

class School
{
	public function getSchoolList()
	{
		$result = Db::name('school')->select();
		return $result;
	}
}