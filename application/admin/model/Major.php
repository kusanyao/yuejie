<?php
namespace app\mobile\model;
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

	/**
	 * 根据id查专业
	 */
	public function getMajorDealById($id)
	{
		$result = Db::name('major_deal')->where(array(
			'md_id' => $id,
		))->find();
		return $result;
	}

	/**
	 * 根据专业名称查找专业
	 */
	public function getMajorByName($collegeId,$name)
	{
		$result = Db::name('Major')->where(array(
			'ma_college' => $collegeId,
			'ma_name'    => $name
		))->find();
		return $result;
	}

	/**
	 * 根据学院id获取专业数量
	 */
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
	 * 根据专业id查专业的图片
	 */
	public function getThumbArrByMajorId($majorId)
	{
		$result = Db::name('major_thumb')->where(array(
			'mh_major' => $majorId,
		))->select();
		return $result;
	}

	/**
	 * 获取单个路径
	 */
	public function getThumbByMajorId($majorId)
	{
		$result = Db::name('major_thumb')->where(array(
			'mh_major' => $majorId,
		))->find();
		return $result;
	}
}