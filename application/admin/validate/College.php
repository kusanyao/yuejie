<?php
namespace app\admin\validate;

use think\Validate;

class College extends Validate
{
    protected $rule = [
    	'co_school' => 'require|number',
	    'co_name'   => 'require|length:4,25',
	    'co_year'   => 'require|number|length:4',
		'co_introduction' => 'require|length:4,25',
		'co_addr_pid'    => 'require',
		'co_addr_cid'    => 'require',
		'co_addr_aid'    => 'require',
		'co_addr_ful'    => 'require',
		'co_addr_street' => 'require',
		'co_person'     => 'require',
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

}