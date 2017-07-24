<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Upload extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	public function upload()
	{
	    // 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file('image');
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/school');
	    if($info){
	        // 成功上传后 获取上传信息
	        // 输出 jpg
	        echo $info->getExtension();
	        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	        $path = $info->getSaveName();
	        $this->save($path);
	        // 输出 42a79759f284b767dfcb2a0197904287.jpg
	        echo $info->getFilename(); 
	    }else{
	        // 上传失败获取错误信息
	        echo $file->getError();
	    }
	}

	private function save($type,$path)
	{
		$data = array(
			'ob_type'   => 1,
			'ob_source' => 2,
			'ob_author' => 1,
			'ob_path'   => $path,
		);
		$id = Db::name('object')->insertGetId($data);
        if($id > 0){
            redirect('/');
        }
	}
}