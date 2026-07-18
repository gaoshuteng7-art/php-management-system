<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\App;
use think\exception\ValidateException;
use think\Validate;
use think\facade\Request;


/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;
    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;
        // 控制器初始化
        $this->initialize(); 
    }
    public function initialize(){ 
        // 全局变量过滤
        $this->request->filter(['strip_tags','htmlspecialchars','trim']);
        // ip 过滤
        // 设置时区
        // 限制用户访问设备

        // Request::filter(['strip_tags','htmlspecialchars','trim']);
    }

}
