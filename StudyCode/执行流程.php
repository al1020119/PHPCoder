<?php
    #--------------------- 执行流程 --------------------- 
    /**
    1， 入口文件： ~/public/index.php
        // 定义应用目录常量
        define('APP_PATH', __DIR__ . '/../application/');
        // 加载框架引导文件
        require __DIR__ . '/../thinkphp/start.php';
    2，加载框架引导文件：~/thinkphp/start.php
        // 1. 加载基础文件
        require __DIR__ . '/base.php';
        // 2. 执行应用
        App::run()->send();
    3，加载基础文件
        定义常量，文件后缀，环境常量
        加载环境变量配置文件
        载入Loader类：~/thinkphp/library/think/Loader.php(自动加载类)
        // 注册自动加载
        \think\Loader::register();
        // 注册错误和异常处理机制： ~/thinkphp/library/think/Error.php
        \think\Error::register();
        // 加载惯例配置文件:~/thinkphp/convention.php
        \think\Config::set(include THINK_PATH . 'convention' . EXT);
    4，加载运行应用：~/thinkphp/library/think/App.php
        App::run()->send(); 
        run方法：public static function run(Request $request = null)
        1, 加载$config = self::initCommon();
            // 加载命名空间: Loader::addNamespace($config['root_namespace']);
            // 初始化应用： config = self::init(); 加载各种配置文件
            // 应用调试模式:self::$debug = Env::get('app_debug', Config::get('app_debug'));
            // 加载额外文件:$config['extra_file_list']
            // 设置系统时区: date_default_timezone_set($config['default_timezone']);
            // 监听 app_init： Hook::listen('app_init');
        2,加载当前控制器中的init方法
            // 加载各种配置文件
            // 加载公告文件
            // 加载语言包
        3, 设置时区
        4, 加载当前控制的路由检测
        5, 调用控制器中的exec方法：根据用户请求进行分发处理
        6, 根据不同的请求类型，加载对应文件module方法
            // 获取控制器名
            // $controller = strip_tags($result[1] ?: $config['default_controller']);
            // $controller = $convert ? strtolower($controller) : $controller;
            // 设置当前请求的控制器、操作
            // $request->controller(Loader::parseName($controller, 1))->action($actionName);

        模块/控制器绑定，入口自动绑定，默认语言，系统语言包，监听 app_dispatch，URL 路由检测，记录路由和请求信息，监听 app_begin，请求缓存检查，清空类的实例化，输出数据到客户端，监听 app_end

    5，相应输出

        // 输出数据到客户端
        if ($data instanceof Response) {
            $response = $data;
        } elseif (!is_null($data)) {
            // 默认自动识别响应输出类型
            $type = $request->isAjax() ?
            Config::get('default_ajax_return') :
            Config::get('default_return_type');

            $response = Response::create($data, $type);
        } else {
            $response = Response::create();
        }
    */
    #--------------------- 执行流程 --------------------- 	
?>
