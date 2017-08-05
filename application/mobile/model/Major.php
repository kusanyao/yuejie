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

	/**
	 * 根据id查专业
	 */
	public function getMajorByIds($ids)
	{
		$nowTime = time();
		$result = Db::name('Major')->where(array(
			'ma_id' => ['in',$ids],
			'ma_state' => 1,
			'ma_start' => ['<',$nowTime],
			'ma_end' => ['>',$nowTime],
		))->select();
		return $result;
	}

	/**
	 * 查专业列表
	 */
	public function getMajorList($condition=[],$limit=20,$offset=0)
	{
		$nowTime = time();
		$where = array(
			'ma_state' => 1,
			'ma_start' => ['<',$nowTime],
			'ma_end' => ['>',$nowTime],
		);
		$where = array_merge($where,$condition);
		$result = Db::name('major')
			->where($where)
			->order('ma_sort desc')
			->limit($limit,$offset)
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