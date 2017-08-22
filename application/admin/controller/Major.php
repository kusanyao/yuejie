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
        $limit = $this->getLimit();
        $page  = $this->getPage();
        $offset = $this->getOffset();
        $collegeId  = input('param.college/d');
        if($collegeId <= 0){
            redirect('/college/list');
        }
        $majorList = model('Major','logic')->getMajorListByCollegeId($collegeId,
            [],$limit,$offset);
        $count = model('Major')->getMajorCountByCollegeId($collegeId);
        return $this->fetch('list',array(
            'collegeId' => $collegeId,
            'majorList' => $majorList,
            'pages' =>$this->getPageHtml($page,$count,$limit),
        ));
    }

    /**
     * 创建
     */
    public function edit()
    {
        $id = input('param.id/d');
        if($id > 0){
            $major     = model('Major')->getMajorById($id);
            if(empty($major)){
                return redirect('/');
            }
            $majorThumb = model('Major')->getThumbArrByMajorId($id);
            $collegeId = $major['ma_college'];
        }else{
            $major = $majorThumb = [];
            $collegeId = input('param.college/d');
        }
        
        $college   = model('College')->getCollegeById($collegeId);
    	$school    = model('School')->getSchoolById($college['co_school']);
        return view('edit',array(
            'major'     => $major,
            'college'   => $college,
            'majorThumb' => $majorThumb,
            'school'    => $school,
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
            $majorThumbStr = input('param.major_thumb/s');
            if(empty($majorThumbStr)){
                return json(array(
                    'code'  => 206,
                    'error' => '专业缩略图不能为空'
                ));
            }
            $majorThumbArr = json_decode($majorThumbStr,true);
            if(empty($majorThumbArr)){
                return json(array(
                    'code'  => 207,
                    'error' => '专业缩略图不能为空'
                ));
            }
            if(empty($majorThumbArr)){
                return json(array(
                    'code'  => 207,
                    'error' => '专业缩略图不能为空'
                ));
            }
            $college = model('College')->getCollegeById($collegeId);
            $schoolId  = $college['co_school'];
        }
        $data = array(
            'ma_id'  => $id,
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
            'ma_start' => strtotime(input('param.start/s')),
            'ma_end'   => strtotime(input('param.end/s')),
            'ma_tag'   => input('param.tag/s'),
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
            $res = $id;
        }else{
            $res = model('Major','logic')->addMajor($data,$majorThumbArr);
        }
        return json(array(
            'code'  => 200,
            'result' => array(
                'id' => $res,
            )
        ));
    }

    public function edit_deal()
    {
        $id = input('param.id/d');
        $majorModel = model('Major');
        $major = $majorModel->getMajorById($id);
        if(empty($major)){
            return redirect('/');
        }
        $deal  = $majorModel->getMajorDealById($id);
        $college   = model('College')->getCollegeById($major['ma_college']);
        $school    = model('School')->getSchoolById($major['ma_school']);
        return view('edit_deal',array(
            'school'  => $school,
            'college' => $college,
            'major'   => $major,
            'deal'    => $deal,
        ));
    }

    public function ajax_edit_deal()
    {
        $id = input('param.id/d');
        $content = input('param.content/s');
        if(empty($id) || empty($content)){
            return json(array(
                'code'  => 404,
                'error' => ''
            ));
        }
        $majorModel = model('Major');
        $major = $majorModel->getMajorById($id);
        if(empty($major)){
            return json(array(
                'code'  => 404,
                'error' => ''
            ));
        }
        $deal = $majorModel->getMajorDealById($id);
        if(empty($deal)){
            $data = array(
                'md_id' => $id,
                'md_content' => $content,
            );
            $result = Db::name('major_deal')->insert($data);
        }else{
            $data   = 
            $result = Db::name('major_history')->insert(array(
                'dh_major' => $deal['md_id'],
                'dh_content' => $deal['md_content'],
            ));
            $result = Db::name('major_deal')->where('md_id',$deal['md_id'])
                ->update(array(
                'md_content' => $content,
            ));
        }
        return json(array(
            'code'  => 200,
            'error' => ''
        ));
    }

    public function delThumb()
    {
        $id = input('param.id/d');
        $res = Db::name('majorThumb')->where(['mh_id'=>$id])->update(['mh_delete'=>2]);
        if($res){
            return json(array(
                'code'   => 200,
                'result' => 'OK'
            ));
        }else{
            return json(array(
                'code'   => 500,
                'error' => '删除失败'
            ));
        }
    }
}
