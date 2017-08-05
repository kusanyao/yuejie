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
        $count = model('school')->getCount();
        $limit = $this->getLimit();
        $page  = $this->getPage();
        $offset = $this->getOffset();
        $schoolList = model('School','logic')->getSchoolList([],$limit,$offset);
        return $this->fetch('list',array(
            'schoolList' => $schoolList,
            'count'     => $count,
            'pages'    =>$this->getPageHtml($page,$count,$limit),
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
            $school = model('School')->getSchoolById($id);
            $schoolThumb = model('School')->getThumbArrBySchoolId($id);
            $city   = $areaModel->getItemsByPid($school['sc_addr_pid']);
            $area   = $areaModel->getItemsByPid($school['sc_addr_cid']);
        }else{
            $school = $city = $area = $schoolThumb = [];
        }
        $province = $areaModel->getItemsByPid(1);
    	return view('edit',array(
            'province' => $province,
            'city'     => $city,
            'area'     => $area,
            'school'   => $school,
            'schoolThumb' => $schoolThumb
        ));
    }

    public function ajax_edit()
    {
        $id  = input('param.id/d');
        $aid = input('param.addr_aid/d');
        $fulArea = model('Area')->getFulAraeByAid($aid);
        $data = array(
            'sc_id' => $id,
            'sc_name'  => input('param.name/s'),
            'sc_english'  => input('param.english/s'),
            'sc_year'     => input('param.year/s'),
            'sc_nature'   => input('param.nature/s'),
            'sc_person'   => input('param.person/s'),
            'sc_addr_aid' => $fulArea['item_a']['ar_id'],
            'sc_addr_cid' => $fulArea['item_c']['ar_id'],
            'sc_addr_pid' => $fulArea['item_p']['ar_id'],
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
            $schoolThumbStr = input('param.school_thumb/s');
            if(empty($schoolThumbStr)){
                return json(array(
                    'code'  => 206,
                    'error' => '学校缩略图不能为空'
                ));
            }
            $schoolThumbArr = json_decode($schoolThumbStr,true);
            if(empty($schoolThumbArr)){
                return json(array(
                    'code'  => 207,
                    'error' => '学校缩略图不能为空'
                ));
            }
            if(empty($schoolThumbArr)){
                return json(array(
                    'code'  => 207,
                    'error' => '学校缩略图不能为空'
                ));
            }
            $result = model('School','logic')->addSchool($data,$schoolThumbArr);
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
