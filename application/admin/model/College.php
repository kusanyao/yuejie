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

	public function getCollegeByName($schoolId,$name)
	{
		$result = Db::name('college')->where(array(
			'co_school' => $schoolId,
			'co_name'   => $name
		))->find();
		return $result;
	}

	public function getCollegeCountBySchoolId($schoolId)
	{
		$result = Db::name('college')->where(array(
			'co_school' => $schoolId,
		))->count();
		return $result;
	}

	public function getCollegeListBySchoolId($schoolId)
	{
		$result = Db::name('college')->where(array(
			'co_school' => $schoolId
		))->select();
		return $result;
	}

	public function mdfCollegeById($id,$data)
	{
		$result = Db::name('college')->where('co_id',$id)->update($data);
		return $result;
	}
}