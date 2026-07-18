<?php
namespace app\api\controller;

use think\Response;
use think\App;
use think\exception\HttpResponseException;

class Api{
    public $responseType = 'json';
    public $request;

    public function __construct(App $app){
        $this->request = $app->request;
        $this->initialize();
    }

    public function initialize(){
        // 封控ip
        // 设置时区
        // 设置亲求参数过滤

    }

    // 成功
    public function success($msg = '操作成功', $data = null, $code = 1, $type = null, $header = [], $options = []){
        $this->result($msg,$data,$code,$type,$header,$options);
    }

    public function error($msg = '操作失败', $data = null, $code = 0, $type = null, $header = [], $options = []){
        $this->result($msg,$data,$code,$type,$header,$options);
    }

    public function result($msg='',$data=null,$code=0,$type=null,$header=[],$options=[]){
        $result = [
            'code'  => $code,
            'msg'   => $msg,
            'time'  => time(),
            'data'  => $data
        ];
        $type = $type ?: $this->responseType;
        $responseCode = 200;
        if(isset($header['statuscode'])){
            $responseCode = $header['statuscode'];
            unset($header['statuscode']);
        }
        $response = Response::create($result,$type,$responseCode)->header($header)->options($options);
        throw new HttpResponseException($response);
    }
}


?>