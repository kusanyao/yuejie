<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Upload extends Base
{
	// 定义允许上传的类型
	private $allow_type = array(
		'school_thumb',
		'college_thumb',
		'major_thumb',
	);

	public function __construct()
	{
		parent::__construct();
	}

	public function file()
	{
		$fileType = input('param.type/s');
		$businessData = input('param.business_data/s');
		if(!in_array($fileType, $this->allow_type)){
			return json(array(
                'code'  => 404,
                'error' => 'not find the type'
            ));
		}
		// 移动文件到项目目录
	    $file = request()->file('upload_file');
	    $realFileDir = ROOT_PATH . 'public' . DS . 'uploads' . DS .$fileType;
	    $info = $file->move($realFileDir);
	    if(!$info){
	        return json(array(
                'code'  => 500,
                'error' => $file->getError()
            ));
	    }

	    // 保存文件数据表
        $saveName = $info->getSaveName();
        $realFileName = $realFileDir . DS . $saveName;
        $objectId = $this->save($fileType,$saveName);
        if(!$objectId){
        	@unlink($realFileName);
        	return json(array(
                'code'  => 501,
                'error' => 'file server error'
            ));
        }

        // 处理对应的业务
        $fulpath = $fileType.DS.$saveName;
        $res = $this->businessProcess($fileType,$objectId,$fulpath,$businessData);
        if(!$res){
        	return json(array(
                'code'  => 503,
                'error' => 'business process file error'
            ));
        }

        model('Object','logic')->takeoverCallback($objectId);

        // 返回结果给前端
        return json(array(
            'code'  => 200,
            'result' => array(
            	'id'  => $objectId,
            	'url' => '/uploads/'.$fulpath,
            )
        ));
	}

	/**
	 * 保存文件对象到数据表
	 */
	private function save($fileType,$path)
	{
		$data = array(
			'ob_type'   => $fileType,
			'ob_source' => 2,
			'ob_author' => $this->member['id'],
			'ob_path'   => $path,
		);
		return Db::name('object')->insertGetId($data);
	}

	/**
	 * 处理对应的业务
	 */
	private function businessProcess($fileType,$objectId,$fulpath,$businessData)
	{
		switch ($fileType) {
			case 'major_thumb':
				$result = model('Major','logic')->uploadCallback($objectId,$fulpath,$businessData);
				break;
			case 'college_thumb':
				$result = model('College','logic')->uploadCallback($objectId,$fulpath,$businessData);
				break;
			case 'school_thumb':
				$result = model('School','logic')->uploadCallback($objectId,$fulpath,$businessData);
				break;
			default:
				$result = false;
				break;
		}
		return $result;
	}
}