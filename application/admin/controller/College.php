<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class College extends Base
{
	/**
	 * 列表
	 */
    public function list()
    {

        $limit = $this->getLimit();
        $page  = $this->getPage();
        $offset = $this->getOffset();
        $schoolId = input('param.school/d');
        if($schoolId <= 0){
            redirect('/school/list');
        }
        $count = model('College')->getCountBySchoolId($schoolId);
        $collegeList = model('College','logic')->getCollegeListBySchoolId($schoolId,
            [],$offset,$limit);
        return $this->fetch('list',array(
            'schoolId'   => $schoolId,
            'collegeList' => $collegeList,
            'pages' =>$this->getPageHtml($page,$count,$limit),
        ));
    }

    /**
     * 创建
     */
    public function edit()
    {
        $id = input('param.id/d');
        $areaModel = model('Area');
        if($id > 0){
            $college  = model('College')->getCollegeById($id);
            $collegeThumb = model('College')->getThumbArrByCollegeId($id);
            $schoolId = $college['co_school'];
            $city   = $areaModel->getItemsByPid($college['co_addr_pid']);
            $area   = $areaModel->getItemsByPid($college['co_addr_cid']);
        }else{
            $college = $collegeThumb = $city = $area = [];
            $schoolId = input('param.school/d');
        }
        $school   = model('School')->getSchoolById($schoolId);
        $province = $areaModel->getItemsByPid(1);
    	return view('edit',array(
            'province' => $province,
            'city'     => $city,
            'area'     => $area,
            'school'   => $school,
            'collegeThumb' => $collegeThumb,
            'college'  => $college
        ));
    }

    public function ajax_edit()
    {
        $id = input('param.id/d');
        if($id > 0){
            $college  = model('College')->getCollegeById($id);
            $schoolId = $college['co_school'];
        }else{
            $schoolId = input('param.school/d');
            $collegeThumbStr = input('param.college_thumb/s');
            if(empty($collegeThumbStr)){
                return json(array(
                    'code'  => 206,
                    'error' => '专业缩略图不能为空'
                ));
            }
            $collegeThumbArr = json_decode($collegeThumbStr,true);
            if(empty($collegeThumbArr)){
                return json(array(
                    'code'  => 207,
                    'error' => '专业缩略图不能为空'
                ));
            }
            if(empty($collegeThumbArr)){
                return json(array(
                    'code'  => 207,
                    'error' => '专业缩略图不能为空'
                ));
            }
        }
        $aid = input('param.addr_aid/d');
        $fulArea = model('Area')->getFulAraeByAid($aid);
        $start = strtotime(input('param.start/s'));
        $end   = strtotime(input('param.end/s'));
        if(empty($start) || empty($end)){
            return json(array(
                'code'  => 206,
                'error' => '上架时间错误'
            ));
        }
        $data = array(
            'co_id'   => $id,
            'co_school'   => $schoolId,
            'co_name'     => input('param.name/s'),
            'co_year'     => input('param.year/d'),
            'co_person'     => input('param.person/s'),
            'co_person_tel' => input('param.person_tel/d'),
            'co_addr_aid' => $fulArea['item_a']['ar_id'],
            'co_addr_cid' => $fulArea['item_c']['ar_id'],
            'co_addr_pid' => $fulArea['item_p']['ar_id'],
            'co_addr_ful' => $fulArea['ful'],
            'co_channel_a' => (int)input('param.channel_a/d'),
            'co_channel_b' => (int)input('param.channel_b/d'),
            'co_channel_c' => (int)input('param.channel_c/d'),
            'co_channel_d' => (int)input('param.channel_d/d'),
            'co_addr_street'   => input('param.addr_street/s'),
            'co_person_tel'    => input('param.person_tel/s'),
            'co_introduction'  => input('param.introduction/s'),
            'co_sort'  => input('param.sort/d'),
            'co_start' => $start,
            'co_end'   => $end,
            'co_state' => input('param.state/d'),
        );
        $result = $this->validate($data,'College.create');
        if(true !== $result){
            return json(array(
                'code'  => 206,
                'error' => $result
            ));
        }
        if($id > 0){
            $result = model('College')->mdfCollegeById($id,$data);
        }else{
            $result = model('College','logic')->addCollege($data,$collegeThumbArr);
        }
        if($result){
            return json(array(
                'code'   => 200,
                'result' => $result
            ));
        }else{
            return json(array(
                'code'   => 500,
                'error' => '添加失败'
            ));
        }
    }
}
