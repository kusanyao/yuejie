<?php
namespace app\mobile\model;
use think\Db;

class School
{
	/**
	 * 根据id查找学校
	 */
	public function getSchoolById($id)
	{
		$result = Db::name('school')->where(array(
			'sc_id' => $id
		))->find();
		return $result;
	}

	public function getSchoolList()
	{
		$result = Db::name('major')
			->join('school','yj_major.ma_school=yj_school.sc_id')
			->order('ma_sort desc,ma_id asc')
			->find();
		return $result;
	}
}