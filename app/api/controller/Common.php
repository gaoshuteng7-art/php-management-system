<?php
namespace app\api\controller;
use app\api\lib\Geetest;
use app\api\model\User;
use app\api\controller\Api;
use app\api\lib\Token;
use think\App;
class Common extends Api{

    // 不需要校验身份就可以访问的方法
    protected $noNeedLogin = [];
    // 当前登录用户的身份信息
    protected $userModel;

    // 控制器初始化
    public function initialize(){
        parent::initialize();
        
        // 校验身份
        $token = $this->request->header('user-token');
        $action = $this->request->action();
        if(!in_array($action,$this->noNeedLogin)){
            $tokenObj = new Token();
            $tokenInfo = $tokenObj->get($token);
            if(empty($tokenInfo)){
                $this->error('请先登录');
                return;
            }
            $user = User::withJoin('bumen')->find($tokenInfo['uid']);
            if(!$user){
                $this->error('用户不存在');
                return;
            }
            $this->userModel = $user;
        }
    }
}

?>