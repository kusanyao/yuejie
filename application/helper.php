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
