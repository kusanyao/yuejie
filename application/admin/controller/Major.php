<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Major extends Base
{
	/**
	 * 列表
	 */
    public function list()
    {
        $collegeId  = input('param.college/d');
        if($collegeId <= 0){
            redirect('/college/list');
        }
        $majorList = model('Major')->getMajorListByCollegeId($collegeId);
        return $this->fetch('list',array(
            'collegeId' => $collegeId,
            'majorList' => $majorList
        ));
    }

    /**
     * 创建
     */
    public function edit()
    {
        $id = input('param.id/d');
        if($id > 0){
            $major = model('Major')->getMajorById($id);
            $collegeId = $major['ma_college'];
        }else{
            $major = [];
            $collegeId = input('param.college/d');
        }
        
        $college   = model('College')->getCollegeById($collegeId);
    	$school    = model('School')->getSchoolById($college['co_school']);
        return view('edit',array(
            'major'    => $major,
            'college'  => $college,
            'school'   => $school,
        ));
    }

    public function ajax_edit()
    {
        $id = input('param.id/d');
        if($id > 0){
            $major = model('Major')->getMajorById($id);
            $collegeId = $major['ma_college'];
            $schoolId  = $major['ma_school'];
        }else{
            $collegeId = input('param.college/d');
            $college = model('College')->getCollegeById($collegeId);
            $schoolId  = $college['co_school'];
        }
        $data = array(
            'ma_school'  => $schoolId,
            'ma_college' => $collegeId,
            'ma_name'    => input('param.name/s'),
            'ma_introduction' => input('param.introduction/s'),
            'ma_institution'  => input('param.institution/s'),
            'ma_class_time'   => input('param.class_time/s'),
            'ma_start_school' => input('param.start_school/s'),
            'ma_stay'     => input('param.stay/s'),
            'ma_plan'     => input('param.plan/s'),
            'ma_form'     => input('param.form/s'),
            'ma_exam'     => input('param.exam/s'),
            'ma_object'   => input('param.object/s'),
            'ma_channel'  => input('param.channel/s'),
            'ma_tuition'  => input('param.tuition/s'),
            'ma_quantity' => input('param.quantity/s'),
            'ma_start' => input('param.start/d'),
            'sc_start' => strtotime(input('param.start/s')),
            'sc_end'   => strtotime(input('param.end/s')),
            'ma_tag'   => 'number',
            'ma_sort'  => input('param.sort/d'),
        );

        $result = $this->validate($data,'Major.create');
        if(true !== $result){
            return json(array(
                'code'  => 206,
                'error' => $result
            ));
        }
        if($id > 0){
            $res = Db::name('major')->where('ma_id',$id)->update($data);
        }else{
            $data['ma_create'] = time();
            $res = Db::name('major')->insertGetId($data);
        }
        return json(array(
            'code'  => 200,
            'result' => 'ok'
        ));
    }
}
