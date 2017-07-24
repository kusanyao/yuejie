<?php
namespace app\admin\model;
use think\Db;

class Citybook
{
	public function getItemById($id)
	{
		return Db::name('citybook')->where('cb_id',$id)->find();
	}

	public function getItemsByLevel($level=1)
	{
		return Db::name('citybook')->where('cb_level',1)->select();
	}

	public function getItemsByPid($pid)
	{
		return Db::name('citybook')->where('cb_pid',$pid)->select();
	}

	public function getFulByAid($aid)
	{
		$item_a = $this->getItemById($aid);
		$item_c = $this->getItemById($item_a['cb_pid']);
		$item_p = $this->getItemById($tiem_c['cb_pid']);
		return $item_a['cb_area'].' '.$item_c['cb_area'].' '.$item_p['cb_area'];
	}

	public function getFulAraeByAid($aid)
	{
		$item_a = $this->getItemById($aid);
		$item_c = $this->getItemById($item_a['cb_pid']);
		$item_p = $this->getItemById($item_c['cb_pid']);
		return array(
			'item_a' => $item_a,
			'item_c' => $item_c,
			'item_p' => $item_p,
			'ful' => $item_p['cb_area'] . ' ' . $item_c['cb_area'] . ' ' . $item_a['cb_area'],
		);
	}
}