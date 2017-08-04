<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class Major extends Base
{
    /**
     * 
     */
	public function list()
	{
		return view('list');
	}

	/**
     * 专业详情页面
     */
    public function deal()
    {
        return view('deal');
    }

    /**
     * 对比页面
     */
    public function contrast()
    {
    	return view('contrast');
    }

    /**
     * 获取专业列表
     */
    public function ajax_list()
    {
        $result      = [];
        $majorModel  = model('Major');
        $schoolModel = model('School');

        $majorList = $majorModel->getMajorList([],$this->getLimit(),$this->getOffset());
        foreach ($majorList as $v) {
            $thumb = $majorModel->getThumbByMajorId($v['ma_id']);
            $school = $schoolModel->getSchoolById($v['ma_school']);
            $newSchool = array(
                'id' => $school['sc_id'],
                'name' => $school['sc_name'],
            );
            $thumb = '/'.$thumb['mh_path'];
            $result[] = array(
                'id'    => $v['ma_id'],
                'name'  => $v['ma_name'],
                'thumb' => $thumb,
                'tuition' => $v['ma_tuition'],
                'introduction' => $v['ma_introduction'],
                'createTime' => $v['ma_insert_at'],
                'school' => $newSchool,
            );
        }
        return json([
            'code' => 200,
            'result' => $result
        ]);
    }

    /**
     * 专业详情
     */
    public function ajax_deal()
    {
    	$id = input('param.id/d');
        $major = model('Major')->getMajorById($id);
        $majorDeal = model('Major')->getMajorDealById($id);
        if(empty($major)){
        	return json(['code' => 404,'error'=>'没有找到该专业信息']);
        }
        return json([
        	'code' => 200,
        	'result' => array(
        		'major'     => $major,
        		'majorDeal' => $majorDeal,
        	)
        ]);
    }

    /**
     * 专业对比
     */
    public function ajax_deals()
    {
        if(!$this->user){
            return json(['code' => 206,'error'=>'请先登录']);
        }
    	$ids = $this->getIds();
        if(count($ids) > 5){
            return json(['code' => 306,'error'=>'不同超过5个专业']);
        }
        $majorArr = model('Major')->getMajorByIds($ids);
        if(empty($majorArr)){
        	return json(['code' => 404,'error'=>'没有找到该专业信息']);
        }
        return json([
        	'code' => 200,
        	'result' => $majorArr
        ]);
    }
}