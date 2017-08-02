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
		$nowTime = time();
		$result = Db::name('Major')->where(array(
			'ma_id' => $id,
			'ma_state' => 1,
			'ma_start' => ['<',$nowTime],
			'ma_end' => ['>',$nowTime],
		))->find();
		return $result;
	}

	
	public function getMajorList($condition=[])
	{
		$nowTime = time();
		$where = array(
			'ma_state' => 1,
			'ma_start' => ['<',$nowTime],
			'ma_end' => ['>',$nowTime],
		);
		$result = Db::name('major')
			->where($where)
			->order('ma_sort desc')
			->select();
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