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
        $schoolList = model('College')->getCollegeListBySchoolId($schoolId);
        return $this->fetch('list',array(
            'schoolId'   => $schoolId,
            'schoolList' => $schoolList
        ));
    }

    /**
     * 创建
     */
    public function edit()
    {
        $schoolId = input('param.school/d');
        $school   = model('School')->getSchoolById($schoolId);
        $province = model('Citybook')->getItemsByLevel(1);
    	if(request()->isGet()){
    		return view('edit',array(
                'province' => $province,
                'school' => $school,
            ));
    	}
        $aid = input('param.addr_aid/d');
        $fulArea = model('Citybook')->getFulAraeByAid($aid);
        $data = array(
            'co_school'   => $schoolId,
            'co_name'     => input('param.name/s'),
            'co_year'     => input('param.year/d'),
            'co_person'     => input('param.person/s'),
            'co_person_tel' => input('param.person_tel/d'),
            'co_addr_aid' => $fulArea['item_a']['cb_id'],
            'co_addr_cid' => $fulArea['item_c']['cb_id'],
            'co_addr_pid' => $fulArea['item_p']['cb_id'],
            'co_addr_ful' => $fulArea['ful'],
            'co_addr_street'   => input('param.addr_street/s'),
            'co_person_tel'    => input('param.person_tel/s'),
            'co_introduction'  => input('param.introduction/s'),
            'co_sort'  => input('param.sort/d'),
            'co_start' => input('param.start/d'),
            'co_end'   => input('param.end/d'),
            'co_state' => input('param.state/d'),
        );	

        $result = $this->validate($data,'College.create');
        if(true !== $result){
            return json(array(
                'code'  => 206,
                'error' => $result
            ));
        }
        $id = Db::name('college')->insertGetId($data);
        if($id > 0){
            redirect('/');
        }
    }

    public function college_list()
    {
        return view();
    }
}
