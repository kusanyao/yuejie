<?php
namespace app\admin\model;
use think\Db;

class Object
{
	/**
	 * 根据id查文件对象
	 */
	public function getObjectById($id)
	{
		$result = Db::name('Object')->where(array(
			'ob_id' => $id,
		))->find();
		return $result;
	}
}