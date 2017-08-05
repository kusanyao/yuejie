<?php
namespace app\admin\model;
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

	/**
	 * 根据中文名称查找学校
	 */
	public function getSchoolByName($name)
	{
		$result = Db::name('school')->where(array(
			'sc_name' => $name
		))->find();
		return $result;
	}

	/**
	 * 根据英文名称查找学校
	 */
	public function getSchoolByEnglish($english)
	{
		$result = Db::name('school')->where(array(
			'sc_english' => $english
		))->find();
		return $result;
	}

	/**
	 * 查找学校列表
	 */
	public function getSchoolList($condition=[],$limit=20,$offset=0)
	{
		$where = [];
		$where = array_merge($where,$condition);
		$result = Db::name('school')
			->where($where)
			->order('sc_insert_at desc')
			->limit($offset,$limit)
			->select();
		return $result;
	}

	public function mdfSchoolById($id,$data)
	{
		$result = Db::name('school')->where('sc_id',$id)->update($data);
		return $result;
	}

	/**
	 * 根据专业id查专业的图片
	 */
	public function getThumbArrBySchoolId($schoolId)
	{
		$result = Db::name('school_thumb')->where(array(
			'st_school' => $schoolId,
		))->select();
		return $result;
	}

	/**
	 * 获取单个路径
	 */
	public function getThumbBySchoolId($schoolId)
	{
		$result = Db::name('school_thumb')->where(array(
			'st_school' => $schoolId,
		))->find();
		return $result;
	}

	public function getCount($condition=[])
	{
		return Db::name('school')->where($condition)->count();
	}
}