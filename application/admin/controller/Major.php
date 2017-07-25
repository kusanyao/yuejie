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
            'sc_name'  => input('param.name/s'),
            'sc_english'  => input('param.english/s'),
            'sc_nature'   => input('param.nature/s'),
            'sc_person'   => input('param.person/s'),
            'sc_addr_aid' => $fulArea['item_a']['cb_id'],
            'sc_addr_cid' => $fulArea['item_c']['cb_id'],
            'sc_addr_pid' => $fulArea['item_p']['cb_id'],
            'sc_addr_ful' => $fulArea['ful'],
            'sc_addr_street'   => input('param.addr_street/s'),
            'sc_person_tel'    => input('param.person_tel/s'),
            'sc_introduction'  => input('param.introduction/s'),
            'sc_sort'  => input('param.sort/d'),
            'sc_start' => input('param.start/d'),
            'sc_end'   => input('param.end/d'),
            'sc_state' => input('param.state/d'),
        );	

        $result = $this->validate($data,'School.create');
        if(true !== $result){
            return json(array(
                'code'  => 206,
                'error' => $result
            ));
        }
        $id = Db::name('school')->insertGetId($data);
        if($id > 0){
            redirect('/');
        }
    }

    public function college_list()
    {
        return view();
    }
}
