<?php
namespace app\admin\validate;

use think\Validate;

class Major extends Validate
{
    protected $rule = [
    	'ma_school'  => 'require|number',
	    'ma_college' => 'require|number',
	    'ma_name'    => 'require',
	    'ma_introduction' => 'require|length:4,255',
		'ma_institution'  => 'require|length:2,25',
		'ma_stay'    => 'require',
		'ma_class_time'    => 'require',
		'ma_exam'    => 'require',
		'ma_quantity' => 'require',
		'ma_start_school'     => 'require',
		'ma_object' => 'require|length:4,50',
		'ma_plan'  => 'require|length:2,50',
		'ma_form' => 'require|length:2,50',
		'ma_channel'   => 'require|length:2,50',
		'ma_tuition' => 'require|length:2,50',
		'ma_start' => 'number',
		'ma_end' => 'number',
		'ma_state' => 'number',
		'ma_tag' => 'require|length:2,50',
		'ma_sort' => 'number',
    ];

    protected $message  =   [
        'ma_name.require' => '名称不能为空',
        'ma_name.max'     => '名称最多不能超过25个字符',  
    ];

    protected $scene = [
        'create' => [],
        'edit'   => ['name','age'],
    ];

}