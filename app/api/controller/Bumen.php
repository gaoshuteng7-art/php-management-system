<?php
namespace app\api\controller;
use app\api\model\Bumen as BumenModel;
class Bumen extends Common{
    public function index(){
        $data = BumenModel::select();
        return json(['code'=>0,'msg'=>'success','data'=>$data]);
    }
}

?>
