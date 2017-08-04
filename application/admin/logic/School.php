<?php
namespace app\admin\logic;
use think\Db;

class School
{
	/**
	 * 添加专业
	 */
	public function addSchool($schoolData,$schoolThumbObj)
	{
		if(empty($schoolData) || empty($schoolThumbObj)){
			return false;
		}
		$schoolId = Db::name('school')->insertGetId($schoolData);
		if(!$schoolId){
			return false;
		}
		$res = $this->addSchoolThumb($schoolId,$schoolThumbObj);
		return $schoolId;
	}

	/**
	 * 添加专业的缩略图
	 */
	public function addSchoolThumb($schoolId,$schoolThumbObj)
	{
		$result = false;
		if(empty($schoolId) || empty($schoolThumbObj)){
			return false;
		}
		$objModel = model('Object');
		if(is_array($schoolThumbObj)){
			foreach ($schoolThumbObj as $v) {
				$objectId = intval($v);
				if($objectId <= 0){
					return false;
				}
				$obj = $objModel->getObjectById($objectId);
				if(empty($obj)){
					return false;
				}
				$data[] = array(
					'st_school'  => $schoolId,
					'st_object' => $obj['ob_id'],
					'st_path'   => $obj['ob_type'] . DS .$obj['ob_path'],
				);
				$result = Db::name('school_thumb')->insertAll($data);
			}
		}elseif(is_numeric($schoolThumbObj)) {
			$objectId = intval($schoolThumbObj);
			$obj = $objModel->getObjectById($objectId);
			if(empty($obj)){
				return false;
			}
			$data = array(
				'st_school'  => $schoolId,
				'st_object' => $obj['ob_id'],
				'st_path'   => $obj['ob_type'] . DS .$obj['ob_path'],
			);
			$result = Db::name('school_thumb')->insertGetId($data);
		}
		$result && model('Object','logic')->takeoverCallback($schoolThumbObj,1);
		return $result;
	}

	/**
	 * 
	 */
	public function getSchoolList($condition,$limit=20,$offset=0)
	{
		$collegeModel = model('College');
		$schoolModel   = model('school');

		$schoolList = model('School')->getSchoolList();
		if(empty($schoolList)){
			return [];
		}
		
		foreach ($schoolList as &$v) {
			$v['collegeCount'] = $collegeModel->getCountBySchoolId($v['sc_id']);
			$thumb = $schoolModel->getThumbBySchoolId($v['sc_id']);
			$v['thumb'] = $thumb['st_path'];
		}
		return $schoolList;
	}

	/**
	 * 上传回调方法
	 */
	public function uploadCallback($objectId,$fulpath,$businessData)
	{
		if(empty($businessData)){
			return true;
		}
		if(empty($objectId) || empty($fulpath) ){
			return false;
		}
		$data = array(
			'st_school' => intval($businessData),
			'st_object' => $objectId,
			'st_path'   => $fulpath,
		);
		return Db::name('school_thumb')->insertGetId($data);
	}
}