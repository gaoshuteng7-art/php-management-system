<?php
namespace app\api\controller;
use app\api\lib\Geetest;
use app\api\model\User;
use app\api\controller\Api;
use app\api\lib\Token;
class Ajax extends Api{
    public function login(){
        $param = $this->request->param();
        $form = $param['form'] ?? [];
        $verify = $param['verify'] ?? [];
        if(empty($form['tel']) || empty($form['password'])){
            $this->error('手机号和密码不能为空');
        }
        foreach(['lot_number', 'captcha_output', 'pass_token', 'gen_time'] as $field){
            if(empty($verify[$field])){
                $this->error('验证码参数不完整');
            }
        }

        // 验证验证码
        $gee = new Geetest();
        $verifyRes = $gee->verify($verify['lot_number'],$verify['captcha_output'],$verify['pass_token'],$verify['gen_time']);
        if($verifyRes['result'] != 'success'){
            $this->error('验证码错误');
        }

        $user = User::where('tel',$form['tel'])->findOrEmpty();
        if(!$user){
            $this->error('用户不存在');
        }
        // 比对密码
        if($user['password'] === ''){
            $this->error('账号尚未设置密码，请联系管理员');
        }
        $passwordValid = password_verify($form['password'], $user['password'])
            || hash_equals($user['password'], md5($form['password']));
        if(!$passwordValid){
            $this->error('密码错误');
        }
        if(!password_get_info($user['password'])['algo']){
            $user->password = password_hash($form['password'], PASSWORD_DEFAULT);
            $user->save();
        }
       
        $token = new Token();
        $user = [
            'name'      => $user['name'],
            'tel'       => $user['tel'],
            'headerimg' => $user['headerimg'],
            'token'    => $token->set($user['id'])
        ];
    
        $this->success('登录成功',$user);
    }
    public function checkLogin(){
        $token = $this->request->header('user-token');
        // 1.验证token是否存在
        // 2.验证token是否过期 - 清除已过期token

        $info = Token::where('token',$token)->findOrEmpty();
        if(!$info){
            return json(['code'=>1,'msg'=>'请先登录']);
        }
        if($info['expired_time'] < time()){
            $info->delete();
            return json(['code'=>1,'msg'=>'登录已过期']);
        }
        return json(['code'=>0,'msg'=>'success']);
    }
}

?>
