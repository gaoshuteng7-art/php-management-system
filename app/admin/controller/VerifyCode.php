<?php
namespace app\admin\controller;

use think\facade\Session;

class VerifyCode
{
    public function index()
    {
        $characters = '2345678abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
        $code = '';
        for($i = 0; $i < 4; $i++){
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        Session::set('captcha', [
            'key' => password_hash(mb_strtolower($code, 'UTF-8'), PASSWORD_BCRYPT),
        ]);

        $width = 130;
        $height = 46;
        $image = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($image, 243, 251, 254);
        imagefill($image, 0, 0, $background);

        for($i = 0; $i < 6; $i++){
            $noiseColor = imagecolorallocate($image, random_int(140, 220), random_int(140, 220), random_int(140, 220));
            imageline($image, random_int(0, $width), random_int(0, $height), random_int(0, $width), random_int(0, $height), $noiseColor);
        }

        foreach(str_split($code) as $index => $character){
            $color = imagecolorallocate($image, random_int(10, 120), random_int(10, 120), random_int(10, 120));
            imagestring($image, 5, 16 + $index * 28, random_int(13, 18), $character, $color);
        }

        ob_start();
        imagepng($image);
        $content = ob_get_clean();
        imagedestroy($image);

        return response($content, 200, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
        ])->contentType('image/png');
    }
}
