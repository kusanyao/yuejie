<?php
namespace app\admin\logic;
use think\Db;

class College
{
	/**
	 * 添加专业
	 */
	public function addCollege($collegeData,$collegeThumbObj)
	{
		if(empty($collegeData) || empty($collegeThumObj)){
			return false;
		}
		$collegeId = Db::name('college')->insertGetId($collegeData);
		$res = $this->addCollegeThumb($collegeId,$collegeThumbObj);
		return $collegeId;
	}

	/**
	 * 添加专业的缩略图
	 */
	public function addCollegeThumb($collegeId,$collegeThumbObj)
	{
		$result = false;
		if(empty($collegeId) || empty($collegeThumbObj)){
			return false;
		}
		$objModel = model('Object');
		if(is_array($collegeThumbObj)){
			foreach ($collegeThumbObj as $v) {
				$objectId = intval($v);
				if($objectId <= 0){
					return false;
				}
				$obj = $objModel->getObjectById($objectId);
				if(empty($obj)){
					return false;
				}
				$data[] = array(
					'ch_college'  => $collegeId,
					'ch_object' => $obj['ob_id'],
					'ch_path'   => $obj['ob_type'] . DS .$obj['ob_path'],
				);
				$result = Db::name('college_thumb')->insertAll($data);
			}
		}elseif(is_numeric($collegeThumbObj)) {
			$objectId = intval($collegeThumbObj);
			$obj = $objModel->getObjectById($objectId);
			if(empty($obj)){
				return false;
			}
			$data = array(
				'ch_college'  => $collegeId,
				'ch_object' => $obj['ob_id'],
				'ch_path'   => $obj['ob_type'] . DS .$obj['ob_path'],
			);
			$result = Db::name('college_thumb')->insertGetId($data);
		}
		$result && model('Object','logic')->takeoverCallback($collegeThumbObj,1);
		return $result;
	}

	/**
	 * 
	 */
	public function getCollegeListBySchoolId($schoolId)
	{
		$collegeModel = model('College');
		$majorModel   = model('Major');

		$collegeList  = $collegeModel->getCollegeListBySchoolId($schoolId);
		if(empty($collegeList)){
			return [];
		}
		
		foreach ($collegeList as &$v) {
			$v['majorCount'] = $majorModel->getMajorCountByCollegeId($v['co_id']);
			$thumb = $collegeModel->getThumbByCollegeId($v['co_id']);
			$v['thumb'] = $thumb['ch_path'];
		}
		return $collegeList;
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
			'ch_college' => intval($businessData),
			'ch_object' => $objectId,
			'ch_path'   => $fulpath,
		);
		return Db::name('college_thumb')->insertGetId($data);
	}
}