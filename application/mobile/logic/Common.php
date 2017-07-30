<?php
namespace app\mobile\logic;
use think\Session;

class Common
{
	public function checkPhone($phone)
	{
		$sessionPhone = Session::get('com.yuejie.www.check_phone');
        if($sessionPhone == $phone){
            return true;
        }
        return false;
	}
}