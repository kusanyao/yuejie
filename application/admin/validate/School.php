<?php
namespace app\admin\validate;

use think\Validate;

class School extends Validate
{
    protected $rule = [
	    'sc_name' => 'length:4,25',
		'sc_english' => '',
		'sc_introduction' => '',
		'sc_nature' => '',
		'sc_addr_pid' => 'require',
		'sc_addr_cid' => '',
		'sc_addr_aid' => '',
		'sc_addr_ful' => '',
		'sc_addr_street' => '',
		'sc_person' => '',
		'sc_person_phone' => '',
		'sc_sort' => '',
		'sc_start' => '',
		'sc_end' => '',
		'sc_insert_at' => '',
		'sc_update_at' => '',
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

}