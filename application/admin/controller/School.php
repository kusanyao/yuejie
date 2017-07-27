<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class School extends Base
{
	/**
	 * 列表
	 */
    public function list()
    {
        $schoolList = model('School')->getSchoolList();
        return $this->fetch('list',array(
            'schoolList' => $schoolList
        ));
    }

    /**
     * 创建
     */
    public function edit()
    {
        $id = input('param.id/d');
        if($id > 0){
            $school = model('School')->getSchoolById($id);
            $city   = model('Citybook')->getItemsByPid($school['sc_addr_pid']);
            $area   = model('Citybook')->getItemsByPid($school['sc_addr_cid']);
        }else{
            $school = $city = $area = [];
        }
        $province = model('Citybook')->getItemsByLevel(1);
    	return view('edit',array(
            'province' => $province,
            'city'     => $city,
            'area'     => $area,
            'school'   => $school,
        ));
    }

    public function ajax_edit()
    {
        $id  = input('param.id/d');
        $aid = input('param.addr_aid/d');
        $fulArea = model('Citybook')->getFulAraeByAid($aid);
        $data = array(
            'sc_id' => $id,
            'sc_name'  => input('param.name/s'),
            'sc_english'  => input('param.english/s'),
            'sc_year'     => input('param.year/s'),
            'sc_nature'   => input('param.nature/s'),
            'sc_person'   => input('param.person/s'),
            'sc_addr_aid' => $fulArea['item_a']['cb_id'],
            'sc_addr_cid' => $fulArea['item_c']['cb_id'],
            'sc_addr_pid' => $fulArea['item_p']['cb_id'],
            'sc_addr_ful' => $fulArea['ful'],
            'sc_addr_street'  => input('param.addr_street/s'),
            'sc_person_tel'   => input('param.person_tel/s'),
            'sc_introduction' => input('param.introduction/s'),
            'sc_sort'  => input('param.sort/d'),
            'sc_start' => strtotime(input('param.start/s')),
            'sc_end'   => strtotime(input('param.end/s')),
            'sc_state' => input('param.state/d'),
        );
        $result = $this->validate($data,'School.create');
        if(true !== $result){
            return json(array(
                'code'  => 206,
                'error' => $result
            ));
        }
        if($id > 0){
            $result = model('School')->mdfSchoolById($id,$data);
        }else{
            $data['sc_create'] = time();
            $result = Db::name('school')->insertGetId($data);
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
