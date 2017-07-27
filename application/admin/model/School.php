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

	public function getSchoolByName($name)
	{
		$result = Db::name('school')->where(array(
			'sc_name' => $name
		))->find();
		return $result;
	}

	public function getSchoolList()
	{
		$result = Db::name('school')->order('sc_create desc')->select();
		$collegeModel = model('College');
		foreach ($result as &$v) {
			$v['collegeCount'] = $collegeModel->getCollegeCountBySchoolId($v['sc_id']);
		}
		return $result;
	}

	public function mdfSchoolById($id,$data)
	{
		$result = Db::name('school')->where('sc_id',$id)->update($data);
		return $result;
	}
}