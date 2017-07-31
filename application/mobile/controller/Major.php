<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class Major extends Base
{
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

    public function ajax_deals()
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
}