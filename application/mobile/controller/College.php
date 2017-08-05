<?php
namespace app\mobile\controller;

class College extends Base
{
    /**
     * 学院页面
     */
    public function index()
    {
        return view('index');
    }

    /**
     * 学院信息
     */
    public function ajax_college()
    {
        $id = input('param.id/d');
        if($id <= 0){
            return json(['code' => 104,'error' => '参数错误']);
        }
        $college = model('College')->getCollegeById($id);
        if(empty($college)){
            return json(['code' => 404,'error' => '找不到该学院信息']);
        }
        $thumb = model('College')->getThumbArrByCollegeId($id);
        $thumbResult = [];
        foreach ($thumb as $v) {
            $thumbResult[] = '/uploads/'.$v['ch_path'];
        }
        return json([
            'code'   => 200,
            'result' => array(
                'id'    => $college['co_id'],
                'name'  => $college['co_name'],
                'thumb' => $thumbResult
            )
        ]);
    }

    /**
     * 学院列表
     */
    public function ajax_list()
    {
    	$schoolId = input('param.school/d');
    	$collegeList = model('College')->getCollegeListBySchoolId($schoolId,[],
            $this->getLimit(),$this->getOffset());
        $result = [];
        foreach ($collegeList as $v) {
            $majorList = model('Major')->getMajorList(['ma_college'=>$v['co_id']],2);
            $majorResult = [];
            foreach ($majorList as $v_major) {
                $majorResult[] = array(
                    'id'      => $v_major['ma_id'],
                    'name'    => $v_major['ma_name'],
                    'tuition' => $v_major['ma_tuition'],
                    'tag'     => explode(',',$v_major['ma_tag']) 
                );
            }
            $result[] = array(
                'id'    => $v['co_id'],
                'name'  => $v['co_name'],
                'major' => $majorResult
            );
        }
        return json([
        	'code' => 200,
        	'result' => $result
        ]);
    }
}