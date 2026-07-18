<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Power as PowerModel;
use app\admin\lib\tree;
use think\facade\Db;

class Index extends Common
{
    public function initialize(){
        parent::initialize();
    }
    public function index()
    {  
        //查询菜单
        $role_id = $this->Admin->role_id;
        $power_ids = Db::name('role')->where('id',$role_id)->value('power_ids');
        $powerList = PowerModel::where('status',1)->whereIn('id',$power_ids)->order('weigh','desc')->select()->toArray();
        // $powerList = PowerModel::where('status',1)->where("find_in_set(id,'{$power_ids}')")->order('weigh','desc')->select()->toArray();
        $tree = new tree($powerList);
        $arr = $tree->get_list();
        // 查询登陆信息
        $admin = session('admin');
        return view('index',['adminInfo'=>$admin,'powerList'=>$arr]);
    }
    public function welcome()
    {
        return view('welcome',['adminInfo'=>$this->Admin,'serverInfo'=>$this->request->server()]);
    }
}
