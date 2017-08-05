<?php
namespace app\mobile\logic;
use think\Db;

class School
{
	/**
	 * @param $condition array  查询条件
	 * @param $limit     int    行数
	 * @param $offset    int    偏移量
	 * @param $orderby   string 排序
	 */
	public function getSchoolList($condition=[],$limit=20,$offset=0,$orderby='')
	{
		$nowTime = time();
		$where = array(
			'sc_state' => 1,
			'sc_start' => ['<',$nowTime],
			'sc_end'   => ['>',$nowTime],
		);
		$where = array_merge($where,$condition);
		$result = Db::name('school')
			// ->fetchSql()
			->field('sc_id,sc_name')
			->join('major','yj_major.ma_school=yj_school.sc_id','left')
			->where($where)
			->order('sc_sort asc')
			->group('sc_id')
			->select();
		return $result;
	}
}