<?php
namespace app\mobile\controller;

class Index extends Base
{
    // 首页页面路由
    public function index()
    {
        return $this->fetch();
    }

    // 首页数据
    public function ajax_home_data()
    {
    	$majorModel = model('Major');
    	$schoolModel = model('School');
    	$majorList = $majorModel->getMajorList();
    	$newMajor = [];
    	foreach ($majorList as $v) {
    		$thumb = $majorModel->getThumbByMajorId($v['ma_id']);
    		$school = $schoolModel->getSchoolById($v['ma_school']);
    		$newSchool = array(
    			'id' => $school['sc_id'],
    			'name' => $school['sc_name'],
    		);
    		$thumb = '/'.$thumb['mh_path'];
    		$newMajor[] = array(
    			'id'    => $v['ma_id'],
    			'name'  => $v['ma_name'],
    			'thumb' => $thumb,
    			'tuition' => $v['ma_tuition'],
    			'introduction' => $v['ma_introduction'],
    			'createTime' => $v['ma_insert_at'],
    			'school' => $newSchool,
    		);
    	}
    	$result = array(
    		'majorList' => $newMajor
    	);
        return json([
        	'code' => 200,
        	'result' => $result
        ]);
    }
}
