<?php
namespace app\mobile\model;
use think\Db;

class College
{
	/**
	 * @param $schoolId  int 学校id
	 * @param $condition int 查询的where条件
	 * @param $limit     int 获取的行数
	 * @param $offset    int 偏移量
	 */
	public function getCollegeListBySchoolId($schoolId,$condition=[],$limit,$offset)
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
			->order('co_insert_at desc')->select();
		return $result;
	}
}