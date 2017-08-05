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

	public function getCountBySchoolId($schoolId)
	{
		$result = Db::name('college')->where(array(
			'co_school' => $schoolId,
		))->count();
		return $result;
	}

	public function getCollegeListBySchoolId($schoolId,$condition=[],$offset,$limit)
	{
		$result = Db::name('college')->where(array(
			'co_school' => $schoolId
		))
		->limit($offset,$limit)
		->order('co_insert_at desc')->select();
		return $result;
	}

	public function mdfCollegeById($id,$data)
	{
		$result = Db::name('college')->where('co_id',$id)->update($data);
		return $result;
	}

	/**
	 * 根据专业id查专业的图片
	 */
	public function getThumbArrByCollegeId($CollegeId)
	{
		$result = Db::name('college_thumb')->where(array(
			'ch_college' => $CollegeId,
		))->select();
		return $result;
	}

	/**
	 * 获取单个路径
	 */
	public function getThumbByCollegeId($collegeId)
	{
		$result = Db::name('college_thumb')->where(array(
			'ch_college' => $collegeId,
		))->find();
		return $result;
	}
}