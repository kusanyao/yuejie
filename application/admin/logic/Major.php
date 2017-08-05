<?php
namespace app\admin\logic;
use think\Db;

class Major
{
	/**
	 * 添加专业
	 */
	public function addMajor($majorData,$majorThumbObj)
	{
		if(empty($majorData) || empty($majorThumbObj)){
			return false;
		}
		$majorId = Db::name('major')->insertGetId($majorData);
		$res = $this->addMajorThumb($majorId,$majorThumbObj);
		return $majorId;
	}

	/**
	 * 添加专业的缩略图
	 */
	public function addMajorThumbb($majorId,$majorThumbObj)
	{
		$result = false;
		if(empty($majorId) || empty($majorThumbObj)){
			return false;
		}
		$objModel = model('Object');
		if(is_array($majorThumbObj)){
			foreach ($majorThumbObj as $v) {
				$objectId = intval($v);
				if($objectId <= 0){
					return false;
				}
				$obj = $objModel->getObjectById($objectId);
				if(empty($obj)){
					return false;
				}
				$data[] = array(
					'mh_major'  => $majorId,
					'mh_object' => $obj['ob_id'],
					'mh_path'   => $obj['ob_type'] . DS .$obj['ob_path'],
				);
				$result = Db::name('major_thumb')->insertAll($data);
			}
		}elseif(is_numeric($majorThumbObj)) {
			$objectId = intval($majorThumbObj);
			$obj = $objModel->getObjectById($objectId);
			if(empty($obj)){
				return false;
			}
			$data = array(
				'mh_major'  => $majorId,
				'mh_object' => $obj['ob_id'],
				'mh_path'   => $obj['ob_type'] . DS .$obj['ob_path'],
			);
			$result = Db::name('major_thumb')->insertGetId($data);
		}
		$result && model('Object','logic')->takeoverCallback($majorThumbObj,1);
		return $result;
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
			'mh_major'  => $businessData,
			'mh_object' => $objectId,
			'mh_path'   => $fulpath,
		);
		return Db::name('major_thumb')->insertGetId($data);
	}

	/**
	 * 获取列表
	 */
	public function getMajorListByCollegeId($collegeId,$condition=[],$limit=20,$offset=0)
	{
		$majorModel = model('Major');
		$majorList  = $majorModel->getMajorListByCollegeId($collegeId,
			$condition,$limit,$offset);
		foreach ($majorList as &$v) {
			$majorThumb = $majorModel->getThumbByMajorId($v['ma_id']);
			$v['thumb'] = $majorThumb['mh_path'];
		}
		return $majorList;
	}
}