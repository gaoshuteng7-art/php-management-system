<?php
namespace app\admin\controller;

use app\admin\controller\BaseController;
use think\Response;
use \think\exception\HttpResponseException;

class Api extends BaseController
{
    protected $responseType = 'json';
    public function initialize(){
        parent::initialize();
    }

    // 接口成功
    public function success($msg = '请求成功', $data = null, $code = 1, $header = []){
        $this->result($data, $code, $msg, $header);
    }

    // 接口失败
    public function error($msg = '请求失败', $data = null, $code = 0, $header = []){
        $this->result($data, $code, $msg, $header);
    }
    
    public function result($data, $code, $msg, $header){
        $result = [
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data,
            'time'  => time()
        ];
        $responseCode = isset($header['response_code']) ? $header['response_code'] : 200;
        $response = Response::create($result, $this->responseType,$responseCode)->header($header);
        throw new HttpResponseException($response);
    }
}


?>