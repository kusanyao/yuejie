<?php
namespace app\mobile\model;
use think\Db;

class Userinfo
{
	/**
	 * 根据id查用户详细信息
	 */
	public function getUserinfoById($id)
	{
		return Db::name('Userinfo')->where('ui_id',$id)->find();
	}

	/**
	 * 保存用户详细信息
	 */
	public function saveUserinfo($id,$data)
	{
		$userinfo = $this->getUserinfoById($id);
		if(empty($userinfo)){
			$data['ui_id'] = $id,
			return Db::name('Userinfo')->insert($data);
		}else{
			return Db::name('Userinfo')->where('ui_id',$id)->update($data);
		}
	}
}