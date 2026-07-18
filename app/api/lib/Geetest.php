<?php
namespace app\api\lib;

class Geetest{
    // 1.初始化极验参数信息
    protected $captcha_id;
    protected $captcha_key;
    protected $api_server;

    public function __construct(){
        $this->captcha_id = (string) env('geetest.captcha_id', '');
        $this->captcha_key = (string) env('geetest.captcha_key', '');
        $this->api_server = rtrim((string) env('geetest.api_server', 'https://gcaptcha4.geetest.com'), '/');
    }
    
    // 2.获取用户验证后前端传过来的验证流水号参数
    public function verify($lot_number,$captcha_output,$pass_token,$gen_time){
        if($this->captcha_id === '' || $this->captcha_key === ''){
            return ['result' => 'fail', 'reason' => 'geetest is not configured'];
        }
        if(!$lot_number || !$captcha_output || !$pass_token || !$gen_time){
            return ['result' => 'fail', 'reason' => 'missing geetest parameters'];
        }
        // 3.生成签名
        $sign_token = hash_hmac('sha256', $lot_number, $this->captcha_key);
        // 4.上传校验参数到极验二次验证接口, 校验用户验证状态
        $query = array(
            "lot_number" => $lot_number,
            "captcha_output" => $captcha_output,
            "pass_token" => $pass_token,
            "gen_time" => $gen_time,
            "sign_token" => $sign_token
        );
        $url = sprintf($this->api_server . "/validate" . "?captcha_id=%s", $this->captcha_id);
        $res = json_decode($this->post_request($url,$query), true);
        return is_array($res) ? $res : ['result' => 'fail', 'reason' => 'invalid geetest response'];
    }
    public function post_request($url, $postdata) {
        $data = http_build_query($postdata);

        $options    = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'content' => $data,
                'timeout' => 5
            )
        );
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        $responseHeader = $http_response_header[0] ?? '';
        preg_match('/\s(\d{3})\s/', $responseHeader, $matches);
        $responsecode = isset($matches[1]) ? intval($matches[1]) : 0;
        if($responsecode != 200){
            $result = array(
                "result" => "fail",
                "reason" => "request geetest api fail"
            );
            return json_encode($result);
        }else{
            return $result;
        }
    }
    private function https_post($url,$data,$ssl = false){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        if($ssl) {
            curl_setopt ( $ch,CURLOPT_SSLCERT,$this->sslcert_path);
            curl_setopt ( $ch,CURLOPT_SSLKEY,$this->sslkey_path);
        }
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt ( $ch, CURLOPT_HTTPHEADER, array(
        //     'Accept: application/json',
        //     'Content-Type:application/x-www-form-urlencoded'
        // ) );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Errno: '.curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
