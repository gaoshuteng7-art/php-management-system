<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Admin as AdminModel;
use app\admin\model\Role as RoleModel;

class Admin extends Common{
    protected $noNeedLogin = [];
    protected $withJoinTable = ['role'=>['title','power_ids']];
    public function initialize(){
        parent::initialize();
        $this->model = new AdminModel();
    }
    public function info(){
        if($this->request->isPost()){
            $param = $this->request->only(['name', 'tel', 'email'], 'post');
            $result = $this->Admin->save($param);
            if($result){
                return json(['code'=>0,'msg'=>'修改成功']);
            }else{
                return json(['code'=>1,'msg'=>'修改失败']);
            }
        }
        return view('info',['adminInfo'=>$this->Admin]);
    }
    public function addData(){
        //查询所有角色
        $roleList = RoleModel::select()->toArray();
        return ['roleList'=>$roleList];
    }
    
    public function checkUsername(){
        $username = $this->request->post('username');
        $id = $this->request->post('id');
        $where = [];
        if($id){
            $where[] = ['id','<>',$id];
        }
        $where[] = ['username','=',$username];
        $result = $this->model->where($where)->find();
        return $result ? false : true;
    }
}


?>
