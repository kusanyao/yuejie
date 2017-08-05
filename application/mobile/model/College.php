<?php
namespace app\mobile\model;
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
	
	/**
	 * @param $schoolId  int 学校id
	 * @param $condition int 查询的where条件
	 * @param $limit     int 获取的行数
	 * @param $offset    int 偏移量
	 */
	public function getCollegeListBySchoolId($schoolId,$condition=[],$limit=20,$offset=0)
	{
		$nowTime = time();
		$where = array(
			'co_school' => $schoolId,
			'co_state'  => 1,
			'co_start'  => ['<',$nowTime],
			'co_end'    => ['>',$nowTime],
		);
		if(is_array($condition)){
			$where = array_merge($where,$condition);
		}
		$result = Db::name('college')->where($where)
			->order('co_insert_at desc')
			->limit($limit,$offset)
			->select();
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
}