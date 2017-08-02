<?php
namespace app\admin\validate;

use think\Validate;

class College extends Validate
{
    protected $rule = [
    	'co_school' => 'require|number',
	    'co_name'   => 'require|length:4,25|checkName',
	    'co_year'   => 'require|number|length:4',
		'co_introduction' => 'require|length:4,25',
		'co_addr_pid'    => 'require|number',
		'co_addr_cid'    => 'require|number',
		'co_addr_aid'    => 'require|number',
		'co_addr_ful'    => 'require|length:2,25',
		'co_addr_street' => 'require|length:2,25',
		'co_person'     => 'require|length:2,25',
		'co_person_tel' => 'require|number',
		'co_sort'  => 'number',
		'co_start' => 'number',
		'co_end'   => 'number',
		'sc_state' => 'number',
    ];

    protected $message  =   [
        'co_name.require' => '名称不能为空',
        'co_name.max'     => '名称最多不能超过25个字符',
        'email'        => '邮箱格式错误',    
    ];

    protected $scene = [
        'create' => [],
        'edit'   => ['name','age'],
    ];
    // 自定义验证规则
    protected function checkName($value,$rule,$data)
    {
    	$college = model('College')->getCollegeByName($data['co_school'],$value);
    	if( empty($college) || $college['co_id'] == $data['co_id'] ){
    		return true;
    	}else{
    		return $value.'已经存在';
    	}
    }
}