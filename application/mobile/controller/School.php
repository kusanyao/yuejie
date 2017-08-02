<?php
namespace app\mobile\controller;
use think\Db;
use think\Session;

class Major extends Base
{
	/**
	 * 学校页面
	 */
	public function screen()
	{
		return view('screen');
	}

	/**
	 * 学校页面
	 */
	public function index()
	{
		$id = input('param.id/d');
		return view('index');
	}

	/**
	 * 学校页面
	 */
	public function ajax_list()
	{
		
		return view('index');
	}
}