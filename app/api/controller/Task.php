<?php
namespace app\api\controller;
use app\api\model\Task as TaskModel;
use think\Validate;

class Task extends Common{
    public function index(){
        // get(page 页码)
        $data = TaskModel::paginate(5);
        return json(['code'=>0,'msg'=>'success','data'=>$data]);
    }
    public function add(){
        $param = request()->only([
            'title', 'task_date', 'beginTime', 'endTime',
            'areaIds', 'bumenId', 'peopleIds'
        ]);
        $validate = Validate::rule([
            'title' => 'require|max:200',
            'task_date' => 'require|date',
            'beginTime' => 'require|dateFormat:H:i',
            'endTime' => 'require|dateFormat:H:i',
            'areaIds' => 'require|array',
            'bumenId' => 'require|integer|gt:0',
            'peopleIds' => 'require|array',
        ]);
        if(!$validate->check($param)){
            return json(['code'=>1,'msg'=>$validate->getError()]);
        }
        if(strtotime($param['endTime']) <= strtotime($param['beginTime'])){
            return json(['code'=>1,'msg'=>'结束时间必须晚于开始时间']);
        }
        try{
            TaskModel::create($param);
        }catch(\Exception $e){
            return json(['code'=>1,'msg'=>$e->getMessage()]);
        }
        return json(['code'=>0,'msg'=>'添加成功']);
    }
}

?>
