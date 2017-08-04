<?php
namespace app\mobile\model;
use think\Db;
use think\Request;

class User
{
	/**
	 * 根据id账户信息
	 */
	public function getUserById($id)
	{

		$result = Db::name('user')
			->where('us_id',$id)->find();
		return $result;
	}

	/**
	 * 根据手机号账户信息
	 */
	public function getUserByPhone($phone)
	{
		$result = Db::name('user')->where(array(
			'us_phone' => $phone
		))->find();
		return $result;
	}

	/**
	 * 根据用户名账户信息
	 */
	public function getUserByUsername($username)
	{
		$result = Db::name('user')->where(array(
			'us_username' => $username
		))->find();
		return $result;
	}

	/**
	 * 根据email查账户信息
	 */
	public function getUserByEmail($email)
	{
		$result = Db::name('user')->where(array(
			'us_email' => $email
		))->find();
		return $result;
	}

	/**
	 * 根据wechatId查账户信息
	 */
	public function getUserByWechatId($wechatId)
	{
		$result = Db::name('user')->where(array(
			'us_wechat' => $wechatId
		))->find();
		return $result;
	}

	/**
	 * 根据wechatId查账户信息
	 */
	public function getLastUser()
	{
		$result = Db::name('user')->order('us_id desc')->find();
		return $result;
	}

	/**
	 * 记录登录日志
	 */
	public function recordLoginLog($uid,$account,$mode)
	{
		return Db::name('login_log')->insert(array(
			'll_uid'        => $uid,
			'll_mode'       => $mode,
			'll_account'    => $account,
			'll_date'       => date('Y-m-d'),
			'll_agent' => Request::instance()->header('User-Agent'),
		));
	}

	/**
	 * 获取登录天数
	 */
	public function getLoginDays($uid)
	{
		return Db::name('login_log')
			->where('ll_uid',$uid)->count('distinct ll_date');
	}
}