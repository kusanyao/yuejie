<?php
namespace app\admin\model;
use think\Db;

class School
{
	public function getSchoolById($id)
	{
		$result = Db::name('school')->where(array(
			'sc_id' => $id
		))->find();
		return $result;
	}

	public function getSchoolList()
	{
		$result = Db::name('school')->select();
		return $result;
	}
}