<?php
namespace app\admin\model;

use think\Model;
use think\facade\Db;
use app\admin\model\admin;

class Role extends Model
{
    protected $type = [
        
    ];
    protected $append = ['powerList'];
    public function setPowerIdsAttr($value){
        return implode(',',$value);
    }
    public function getPowerListAttr($value,$data){
        $arr = Db::name('power')->where('id','in', $data['power_ids'])->column('title');
        return implode(',',$arr);
    }

}

?>