<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class School extends Base
{
	/**
	 * 学校页面
	 */
	public function screen()
	{
		return view('screen');
	}

	/**
	 * 学校页面
	 */
	public function index()
	{
		$id = input('param.id/d');
		return view('index');
	}

	/**
	 * 学校页面
	 */
	public function ajax_list()
	{
		$tuitionArr = array(
			1,// 不限
			2,// 8千以下
			3,// 8千-1.5万
			4,// 1.5万以上
		);
		$planArr = array(
			1,// 不限
			2,// 全日制
			3,// 在职
		);
		$tuition = input('param.tuition/d');
		if(!in_array($tuition, $tuitionArr)){
			return json(['code' => 200,'error' => '请选择正确的学费区间']);
		}
		$plan = input('param.plan/d');
		if(!in_array($plan, $planArr)){
			return json(['code' => 200,'error' => '请选择正确的类型']);
		}
		$result      = [];
        $schoolModel = model('School','logic');
        $schoolList = $schoolModel->getSchoolList([],$this->getLimit(),$this->getOffset());
        return json([
        	'code'   => 200,
        	'result' => $schoolList
        ]);
	}
}