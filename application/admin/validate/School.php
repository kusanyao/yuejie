<?php
namespace app\admin\validate;

use think\Validate;

class School extends Validate
{
    protected $rule = [
    	'sc_id'   => 'number',
	    'sc_name' => 'require|length:4,25|checkName',
		'sc_english' => 'require|length:4,25|checkEnglish',
		'sc_introduction' => 'require|length:0,500',
		'sc_nature' => 'require|length:2,6',
		'sc_addr_pid' => 'require',
		'sc_addr_cid' => 'require',
		'sc_addr_aid' => 'require',
		'sc_addr_ful' => 'require',
		'sc_addr_street' => 'require',
		'sc_person' => 'require',
		'sc_person_tel' => 'require|number',
		'sc_sort' => 'number',
		'sc_start' => 'number',
		'sc_end' => 'number',
		'sc_state' => 'number',
    ];

    protected $message  =   [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不能超过25个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',    
    ];

    protected $scene = [
        'create' => [],
        'edit'   => ['name','age'],
    ];

    // 自定义验证规则
    protected function checkName($value,$rule,$data)
    {
    	$school = model('School')->getSchoolByName($value);
    	if( empty($school) || $school['sc_id'] == $data['sc_id'] ){
    		return true;
    	}else{
    		return $value.'已经存在';
    	}
    }

    // 自定义验证规则
    protected function checkEnglish($value,$rule,$data)
    {
        $school = model('School')->getSchoolByEnglish($value);
        if( empty($school) || $school['sc_id'] == $data['sc_id'] ){
            return true;
        }else{
            return $value.'已经存在';
        }
    }
}