<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Power as PowerModel;
use app\admin\lib\tree;

class Power extends Common
{
    public $model;

    public function initialize()
    {
        parent::initialize();
        $this->model = new PowerModel();
    }
    public function index()
    {  
        $title = $this->request->get('title/s','');
        $where = [];
        if($title){
            $where[] = ['title','like',"%{$title}%"];
        }
        $powerList = $this->model->where($where)->order('weigh','desc')->select()->toArray();

        $tree = new tree($powerList);
        $arr = $tree->get_tree();
        return view('index',['powerList'=>$arr]);
    }

    public function addData(){
        // 查询所有权限
        $powerList = $this->model->select()->toArray();
        $tree = new tree($powerList);
        $arr = $tree->get_tree();
        return ['powerList'=>$arr];
    }
    public function sort(){
        $d = $this->request->post('data');
        $result = $this->model->saveAll($d);
        if($result){
            return json(['code'=>0,'msg'=>'操作成功']);
        }else{
            return json(['code'=>1,'msg'=>'操作失败']);
        }
    }
}
