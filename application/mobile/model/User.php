<?php
namespace app\mobile\model;
use think\Db;

class User
{
	/**
	 * 根据id账户信息
	 */
	public function getUserById($id)
	{
		$result = Db::name('user')->where(array(
			'us_id' => $id
		))->find();
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

}