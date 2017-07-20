<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class School extends Base
{
	/**
	 * 列表
	 */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 创建
     */
    public function create()
    {
        $province = model('Citybook')->getItemsByLevel(1);
    	if(request()->isGet()){
    		return view('create',array(
                'province' => $province,
            ));
    	}
        $aid = input('param.addr_aid/d');
        $cid = 
        $data = array(
            'sc_name'  => input('param.name/s'),
            'sc_english'  => input('param.english/s'),
            'sc_nature'   => input('param.english/s'),
            'sc_person'   => input('param.person/d'),
            'sc_addr_aid' => $aid,
            'sc_addr_street'   => input('param.addr_street/s'),
            'sc_person_tel'    => input('param.person_tel/d'),
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
}
