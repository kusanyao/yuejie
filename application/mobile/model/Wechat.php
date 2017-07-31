<?php
namespace app\mobile\model;
use think\Db;

class Wechat
{
	/**
	 * 根据id账户信息
	 */
	public function getWechatById($id)
	{
		$result = Db::name('wechat')->where(array(
			'we_id' => $id
		))->find();
		return $result;
	}

	/**
	 * 根据id账户信息
	 */
	public function getWechatByUnionid($unionid)
	{
		$result = Db::name('wechat')->where(array(
			'we_unionid' => $unionid
		))->find();
		return $result;
	}

	/**
	 * 根据id账户信息
	 */
	public function getWechatByOpenid($openid,$type)
	{
		switch ($type) {
			case 'wap':
				$result = Db::name('wechat')->where(array(
					'we_wap_openid' => $openid
				))->find();
				break;
			
			default:
				$result = [];
				break;
		}
		return $result;
	}

	public function getTokenByOpenid($openid)
	{
		return Db::name('wechat_token')->where(array(
			'wt_openid' => $openid,
		))->find();
	}

	public function saveWechat($data)
	{
		$wechat = $this->getWechatByUnionid($data['unionid']);
		if(empty($wechat)){
			return Db::name('wechat')->insert(array(
				'we_unionid'    => $data['unionid'],
				'we_wap_openid' => $data['openid'],
				'we_nickname'   => $data['nickname'],
				'we_headimgurl' => $data['headimgurl'],
				'we_sex'        => $data['sex'],
				'we_province'   => $data['province'],
				'we_city'       => $data['city'],
				'we_country'    => $data['country'],
				'we_privilege'  => json_encode($data['privilege']),
			));
		}else{
			return Db::name('wechat')->where('we_unionid',$data['unionid'])->update(array(
				'we_wap_openid' => $data['openid'],
				'we_nickname'   => $data['nickname'],
				'we_headimgurl' => $data['headimgurl'],
				'we_sex'        => $data['sex'],
				'we_province'   => $data['province'],
				'we_city'       => $data['city'],
				'we_country'    => $data['country'],
				'we_privilege'  => json_encode($data['privilege']),
			));
		}
		$wechat = $this->getWechatByUnionid($data['unionid']);
		return $wechat['we_id'];
	}

	/**
	 * 保存token数据
	 */
	public function saveToken($data)
	{
		$token = $this->getTokenByOpenid($data['openid']);
		if(empty($token)){
			return Db::name('wechat_token')->insert(array(
				'wt_access_token'  => $data['access_token'],
				'wt_expires_in'    => $data['expires_in'],
				'wt_refresh_token' => $data['refresh_token'],
				'wt_openid'        => $data['openid'],
				// 'wt_unionid'       => $data['unionid'],
				'wt_refresh_time'  => time()
			));
		}else{
			return Db::name('wechat_token')->where('wt_openid',$data['openid'])->update(array(
				'wt_access_token' => $data['access_token'],
				'wt_expires_in'   => $data['expires_in'],
				'wt_scope'        => $data['scope'],
				'wt_refresh_time' => time()
			));
		}
	}
}