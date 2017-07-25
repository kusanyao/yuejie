<?php
namespace app\admin\model;
use think\Db;

class College
{
	public function getCollegeListBySchoolId($schoolId)
	{
		$result = Db::name('college')->select();
		return $result;
	}
}