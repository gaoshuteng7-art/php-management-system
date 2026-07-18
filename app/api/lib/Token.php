<?php
namespace app\api\lib;
use think\facade\Db;
use app\api\controller\Api;

class Token extends Api{
    protected $table = 'token';
    protected $expire = 600;
    protected $handler;
    public function __construct(){
        $this->handler = Db::name($this->table);
    }

    // 生成/设置
    public function set($user_id, $type = 'user-token',  $expire = null){
        $token = bin2hex(random_bytes(32));
        $tokenData = [
            'token'         => $token,
            'type'          => $type,
            'uid'           => $user_id,
            'expired_time'  => time() + ($expire ?: $this->expire),
        ];
        $this->handler->insert($tokenData);

        // 清理过期的token数据(或隔一段时间清理)
        $this->handler->where('expired_time', '<', time())->delete();
        unset($tokenData['uid']);
        return $tokenData;
    }


    // 获取
    public function get($token){
        $data = $this->handler->where('token', $token)->find();
        if(!$data){
            return [];
        }
        // 返回剩余有效时间
        $expire_in = $data['expired_time']  - time();
        // 如果过期了，响应token已过期
        if($expire_in < 0){
            $this->result('token已过期',[],409);
            return [];
        }
        return $data;
    }

}

?>
