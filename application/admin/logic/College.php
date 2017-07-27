<?php
namespace app\admin\logic;

class College
{
	/**
	 * 
	 */
	public function getCollegeListBySchoolId($schoolId)
	{
		$collegeList = model('College')->getCollegeListBySchoolId($schoolId);
		if(empty($collegeList)){
			return [];
		}
		$majorModel = model('Major');
		foreach ($collegeList as &$v) {
			$v['majorCount'] = $majorModel->getMajorCountByCollegeId($schoolId);
		}
		return $collegeList;
	}
}