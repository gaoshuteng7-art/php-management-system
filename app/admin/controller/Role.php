<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Role as RoleModel;
use app\admin\model\Power as PowerModel;
use think\Exception;
use think\db\exception\PDOException;


class Role extends Common
{   
    public function initialize()
    {
        parent::initialize();
        $this->model = new RoleModel();
    }
    public function addData(){
        //查询所有权限
        $powerList = PowerModel::select()->toArray();
        return ['powerList'=>$powerList];
    }
}