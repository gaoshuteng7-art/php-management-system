<?php
namespace app\admin\controller;
use think\facade\Request;
use app\admin\model\Admin as AdminModel;
use think\facade\Session;
use think\facade\Db;
use app\admin\controller\Api;
class Login extends Api{
    public function __construct(){
        Request::filter(['strip_tags','htmlspecialchars','trim']);
    }
    public function index(){
        if(Session::has('admin.id')){
            return redirect('/admin/index/index');
        }
        return view('index');
    }
    //处理登陆
    public function runLogin(){
        $data = request()->post(['username','password','verify']);
        // 验证参数是否为空
        if(empty($data['username']) || empty($data['password']) || empty($data['verify'])){
            $this->error('参数错误');
        }
        // 验证验证码
        if(!captcha_check($data['verify'])){
            $this->error('验证码错误');
        }
        // 验证用户名密码
        $Admin = AdminModel::where('username',$data['username'])->find();
        if(!$Admin){
            $this->error('用户名不存在');
        }
        // 判断用户是否在限制登陆时间范围内
        if($Admin->login_error_num >= 3 && time() - $Admin->login_time < 60){
            $this->error('登陆错误次数过多，请于'.(($Admin->login_time+60) - time()).'秒后登陆');
        }
        $Admin->login_time = time();
        // 验证密码
        $passwordValid = password_verify($data['password'], $Admin['password'])
            || hash_equals($Admin['password'], md5($data['password']));
        if(!$passwordValid){
            // 更新登陆时间，登陆错误次数
            $Admin->login_error_num = $Admin->login_error_num + 1;
            $Admin->save();
            $this->error('密码错误');
        }
        if(!password_get_info($Admin['password'])['algo']){
            Db::name('admin')->where('id', $Admin->id)->update([
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]);
        }
        if($Admin->status != 1){
            $this->error('用户被禁用');
        }
        // 更新登陆信息
        $Admin->login_error_num = 0;
        $Admin->login_num = $Admin->login_num + 1;
        $Admin->save();

        // 存储用户登陆信息 session
        Session::set('admin.id',$Admin->id);
        Session::set('admin.username',$Admin->username);
        Session::set('admin.name',$Admin->name);
        Session::set('admin.role_id',$Admin->role_id);

        $this->success('登陆成功',['url'=>'/admin/index/index']);
    }
    public function loginOut(){
        Session::delete('admin');
        return redirect('/admin/login/index');
    }
}


?>
