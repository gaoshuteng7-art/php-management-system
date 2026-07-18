<?php
namespace app\api\model;

use think\Model;
use app\api\model\Area;
use app\api\model\Bumen;
use app\api\model\User;

class Task extends Model
{
    protected $append = [
        'area',
        'people'
    ];
    public function setAreaIdsAttr($value){
        return implode(',',$value);
    }
    public function setPeopleIdsAttr($value){
        return implode(',',$value);
    }
    public function getAreaAttr($value,$data){
        $area = Area::where('id','in',$data['areaIds'])->column('title');
        return $area;
    }
    public function getPeopleAttr($value,$data){
        $user = User::where('id','in',$data['peopleIds'])->column('name');
        return $user;
    }
}

?>