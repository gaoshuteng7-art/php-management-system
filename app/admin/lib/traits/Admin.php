<?php
namespace app\admin\lib\traits;

trait Admin{
    public function index()
    {  
        $title = $this->request->get('title/s','');
        $where = [];
        if($title){
            $where[] = ['title','like',"%{$title}%"];
        }
        $dataList = $this->model->withJoin($this->withJoinTable)->where($where)->select()->toArray();
        return view('index',['dataList'=>$dataList]);
    }
    public function add()
    {  
        $id = $this->request->param('id');
        if($id){
            $row = $this->model->find($id);
        }
        $data = $this->request->post();
        if(!empty($data)){
            $result = false;
            try{
                if(isset($data['id']) && intval($data['id']) > 0 && $row){
                    $result = $row->save($data);
                }else{
                    unset($data['id']);
                    $result = $this->model->save($data);
                }
            }catch(Exception|PDOException $e){
                $this->error($e->getMessage());
            }
            if($result){
                $this->success('操作成功');
            }
            $this->error('操作失败');
        }
        $d = array_merge($this->addData(),['row' => $row ?? []]);
        return view('add',$d);
    }
    public function addData(){
        return [];
    }
    public function del(){
        $ids = $this->request->post('ids/a',[]);
        if(empty($ids)){
            $this->error('参数错误');
        }
        $result = $this->model->where('id','in',$ids)->delete();
        if($result){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }
}



?>