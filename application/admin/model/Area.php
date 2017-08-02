<?php
namespace app\admin\model;
use think\Db;

class Area
{
	public function getItemById($id)
	{
		return Db::name('area')->where('ar_id',$id)->find();
	}

	public function getItemsByPid($pid)
	{
		return Db::name('area')->where('ar_pid',$pid)->select();
	}

	public function getFulByAid($aid)
	{
		$item_a = $this->getItemById($aid);
		$item_c = $this->getItemById($item_a['ar_pid']);
		$item_p = $this->getItemById($tiem_c['ar_pid']);
		return $item_a['ar_name'].' '.$item_c['ar_name'].' '.$item_p['ar_name'];
	}

	public function getFulAraeByAid($aid)
	{
		$item_a = $this->getItemById($aid);
		$item_c = $this->getItemById($item_a['ar_pid']);
		$item_p = $this->getItemById($item_c['ar_pid']);
		return array(
			'item_a' => $item_a,
			'item_c' => $item_c,
			'item_p' => $item_p,
			'ful' => $item_p['ar_name'] . ' ' . $item_c['ar_name'] . ' ' . $item_a['ar_name'],
		);
	}
}