<?php
namespace app\mobile\controller;

class Index extends Base
{
    public function ajax_list()
    {
    	$schoolId = input('param.school/d');
    	$page = input('param.page/d');
    	$rows = input('param.rows/d');
    	
        return json([
        	'code' => 200,
        	'result' => 
        ]);
    }
}