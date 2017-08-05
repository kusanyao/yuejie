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
	 * 学校
	 */
	public function ajax_school()
	{
		$id = input('param.id/d');
		if($id <= 0){
			return json(['code' => 104,'error' => '参数错误']);
		}
		$school = model('School')->getSchoolById($id);
		if(empty($school)){
			return json(['code' => 404,'error' => '找不到该学校信息']);
		}
		$thumb = model('School')->getThumbArrBySchoolId($id);
		$thumbResult = [];
		foreach ($thumb as $v) {
			$thumbResult[] = '/uploads/'.$v['st_path'];
		}
		return json([
        	'code'   => 200,
        	'result' => array(
        		'id'    => $school['sc_id'],
        		'name'  => $school['sc_name'],
        		'thumb' => $thumbResult
        	)
        ]);
	}

	/**
	 * 学校页面
	 */
	public function ajax_list()
	{
		$tuitionArr = array(
			1 => [],// 不限
			2 => ['ma_tuition'=>['<',8000]],// 8千以下
			3 => ['ma_tuition'=>['between',[8000,15000]]],// 8千-1.5万
			4 => ['ma_tuition'=>['>',15000]],// 1.5万以上
		);
		$planArr = array(
			1 => [],// 不限
			2 => ['ma_plan'=>'全日制'],// 全日制
			3 => ['ma_plan'=>'在职'],// 在职
		);
		$natureArr = array(
			1 => [],// 不限
			2 => ['sc_nature'=>'985'],// 985
			3 => ['sc_nature'=>'211'],// 211
			4 => ['sc_nature'=>'111计划'],// 111计划
		);
		$tuition = input('param.tuition/d');
		$plan    = input('param.plan/d');
		$nature  = input('param.nature/d');
		if(!in_array($tuition, array_keys($tuitionArr) )){
			return json(['code' => 104,'error' => '请选择正确的学费区间']);
		}
		if(!in_array($plan, array_keys($planArr))){
			return json(['code' => 104,'error' => '请选择正确的类型']);
		}
		if(!in_array($nature, array_keys($natureArr))){
			return json(['code' => 104,'error' => '请选择正确的性质']);
		}
		$condition = array_merge($tuitionArr[$tuition],$planArr[$plan],$natureArr[$nature]);
		$result      = [];
        $schoolModel = model('School','logic');
        $schoolList = $schoolModel->getSchoolList($condition,$this->getLimit(),$this->getOffset());
        return json([
        	'code'   => 200,
        	'result' => $schoolList
        ]);
	}
}