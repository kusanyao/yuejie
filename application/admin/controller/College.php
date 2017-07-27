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
        $schoolId = input('param.school/d');
        if($schoolId <= 0){
            redirect('/school/list');
        }
        $collegeList = model('College','logic')->getCollegeListBySchoolId($schoolId);
        return $this->fetch('list',array(
            'schoolId'   => $schoolId,
            'collegeList' => $collegeList
        ));
    }

    /**
     * 创建
     */
    public function edit()
    {
        $id = input('param.id/d');
        if($id > 0){
            $college  = model('College')->getCollegeById($id);
            $schoolId = $college['co_school'];
            $city   = model('Citybook')->getItemsByPid($college['co_addr_pid']);
            $area   = model('Citybook')->getItemsByPid($college['co_addr_cid']);
        }else{
            $college = [];
            $schoolId = input('param.school/d');
        }
        $school   = model('School')->getSchoolById($schoolId);
        $province = model('Citybook')->getItemsByLevel(1);
    	return view('edit',array(
            'province' => $province,
            'city'     => $city,
            'area'     => $area,
            'school'   => $school,
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
        }
        $aid = input('param.addr_aid/d');
        $fulArea = model('Citybook')->getFulAraeByAid($aid);
        $data = array(
            'co_id'   => $id,
            'co_school'   => $schoolId,
            'co_name'     => input('param.name/s'),
            'co_year'     => input('param.year/d'),
            'co_person'     => input('param.person/s'),
            'co_person_tel' => input('param.person_tel/d'),
            'co_addr_aid' => $fulArea['item_a']['cb_id'],
            'co_addr_cid' => $fulArea['item_c']['cb_id'],
            'co_addr_pid' => $fulArea['item_p']['cb_id'],
            'co_addr_ful' => $fulArea['ful'],
            'co_channel_a' => (int)input('param.channel_a/d'),
            'co_channel_b' => (int)input('param.channel_b/d'),
            'co_channel_c' => (int)input('param.channel_c/d'),
            'co_channel_d' => (int)input('param.channel_d/d'),
            'co_addr_street'   => input('param.addr_street/s'),
            'co_person_tel'    => input('param.person_tel/s'),
            'co_introduction'  => input('param.introduction/s'),
            'co_sort'  => input('param.sort/d'),
            'co_start' => strtotime(input('param.start/s')),
            'co_end'   => strtotime(input('param.end/s')),
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
            $data['co_create'] = time();
            $result = Db::name('college')->insertGetId($data);
        }
        if($result){
            return json(array(
                'code'   => 200,
                'result' => $result
            ));
        }else{
            return json(array(
                'code'   => 200,
                'result' => $result
            ));
        }
    }
}
