<?php
namespace app\admin\model;
use think\Db;

class Major
{
	/**
	 * 根据id查专业
	 */
	public function getMajorById($id)
	{
		$result = Db::name('Major')->where(array(
			'ma_id' => $id,
		))->find();
		return $result;
	}

	public function getMajorByName($collegeId,$name)
	{
		$result = Db::name('Major')->where(array(
			'ma_college' => $collegeId,
			'ma_name'    => $name
		))->find();
		return $result;
	}

	public function getMajorCountByCollegeId($collegeId)
	{
		$result = Db::name('Major')->where(array(
			'ma_college' => $collegeId
		))->count();
		return $result;
	}

	/**
	 * 根据学院id查专业列表
	 */
	public function getMajorListByCollegeId($collegeId)
	{
		$result = Db::name('Major')->where(array(
			'ma_college' => $collegeId,
		))->select();
		return $result;
	}

	/**
	 * 添加专业数据
	 */
	public function add($data)
	{
		
	}
}