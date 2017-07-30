<?php

/**
 * 判断是否是微信
 */
function isWechat(){
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($user_agent, 'MicroMessenger') === false) {
	    return false;
	}
	return true;
}
function username($username){
	if(empty($username)){
		return '';
	}
	$pattern = '/(\w+) (\d+), (\d+)/i';
	$replacement = '${1}1,$3';
	echo preg_replace($pattern, $replacement, $username);
	//^[a-zA-Z0-9!#$%^&*\.()\u4e00-\u9fa5]{3,15}$
    
}
