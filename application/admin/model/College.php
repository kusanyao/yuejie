<?php
namespace app\admin\model;
use think\Db;

class College
{
	public function getCollegeById($id)
	{
		$result = Db::name('college')->where(array(
			'co_id' => $id,
		))->find();
		return $result;
	}

	public function getCollegeListBySchoolId($schoolId)
	{
		$result = Db::name('college')->select();
		return $result;
	}
}