<?php
namespace app\admin\controller;

use app\admin\controller\Api;
use app\admin\model\Admin as AdminModel;
use app\admin\model\Power as PowerModel;
use think\facade\Db;

class Common extends Api{
    // 不需要登录的方法
    protected $noNeedLogin = [];

    // 当前登录用户的信息/模型
    protected $Admin;

    // 当前操作模型
    protected $model;

    // 关联模型
    protected $withJoinTable = [];

    // 混入 traits
    use \app\admin\lib\traits\Admin;
    // 控制器初始化方法
    public function initialize(){
        parent::initialize();
        
        // 判断用户是否登陆
        $action = $this->request->action();
        if(!in_array($action,$this->noNeedLogin)){
            $islogin = session('?admin.id');
            if(!$islogin){ 
                throw new \think\exception\HttpResponseException( redirect('/admin/login/index') );
            }
            $this->Admin = AdminModel::find(session('admin.id'));
            if(!$this->Admin){
                throw new \think\exception\HttpResponseException( redirect('/admin/login/loginOut') );
            }
            if($this->Admin->status == 0){
                throw new \think\exception\HttpResponseException( redirect('/admin/login/loginOut') );
            }
            $this->checkPower();
        }
    }

    protected function checkPower()
    {
        $controller = strtolower($this->request->controller());
        $action = strtolower($this->request->action());
        if($controller === 'index' || ($controller === 'admin' && $action === 'info')){
            return;
        }

        $powerIds = Db::name('role')->where('id', $this->Admin->role_id)->value('power_ids');
        if(!$powerIds){
            $this->error('没有操作权限', null, 403, ['response_code' => 403]);
        }

        $urls = PowerModel::whereIn('id', $powerIds)->where('url', '<>', '')->column('url');
        foreach($urls as $url){
            $segments = array_values(array_filter(explode('/', trim($url, '/'))));
            if(isset($segments[1]) && strtolower($segments[1]) === $controller){
                return;
            }
        }

        $this->error('没有操作权限', null, 403, ['response_code' => 403]);
    }
}

?>
