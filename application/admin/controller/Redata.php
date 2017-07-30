<?php
namespace app\admin\controller;
use think\Db;
use think\Validate;

class Redata extends Base
{
	/**
	 * 列表
	 */
    public function RebuildAreaData()
    {
        ini_set('max_execution_time', '0');
        $offset = 0;
        $id = 0;
        while (1) {
            $areaArr = Db::name('area')->order('ch_pid desc,ch_id asc')->limit(100,$offset)->select();
            $offset++;
            if(empty($areaArr)){
                break;
            }
            foreach ($areaArr as $v) {
                $id ++;
                if($id == 1){
                    continue;
                }
                $res = Db::name('area')->where('ch_id',$v['ch_id'])->update(array(
                    'ch_id' => $id
                ));
                if(!$res){
                    print_r($v);
                }
                $res = Db::name('area')->where('ch_pid',$v['ch_id'])->update(array(
                    'ch_pid' => $id
                ));
                if(!$res){
                    print_r($v);
                }
            }
        }
        echo 'end';      
    }
}