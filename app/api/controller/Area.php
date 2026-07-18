<?php
namespace app\api\controller;
use app\api\model\Area as AreaModel;
class Area extends Common{
    public function index(){
        $data = AreaModel::select();
        return json(['code'=>0,'msg'=>'success','data'=>$data]);
    }
}

?>
