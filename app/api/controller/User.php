<?php
namespace app\api\controller;
use app\api\model\User as UserModel;
use app\api\controller\Common;
use think\Validate;
class User extends Common{

    protected $noNeedLogin = ['abc'];

    public function index(){
        $data = UserModel::select();
        return json(['code'=>0,'msg'=>'success','data'=>$data]);
    }
    public function upload(){
        $file = request()->file('file');
        if(!$file){
            $this->error('请选择上传文件');
        }
        $validate = Validate::rule([
            'file' => 'fileSize:5242880|fileExt:jpg,jpeg,png,gif,webp|fileMime:image/jpeg,image/png,image/gif,image/webp'
        ]);
        if(!$validate->check(['file'=>$file])){
            $this->error($validate->getError());
        }
        // 上传到本地服务器
        $savename = \think\facade\Filesystem::putFile( 'topic', $file);
        $this->success('上传成功',['url'=>'storage/'.$savename]);
    }
    // 获取当前用户信息
    public function info(){
        $this->success('success',$this->userModel->toArray());
    }
}

?>
