加载显示View

index/controller下新建User.php控制
里面写加载方法loadview

	// 系统函数
	return View();
	
	// View方式
	$view = new \think\View;
	return $view->fetch();
	
	// 在控制器方式：需要继承系统控制器类
	$this->fetch();

controller同级目录新建View目录，里面新建user文件夹，里面新建loadview.html

其中
View是前台模块中MVC的View模块，View里面的user文件夹对应controller下的User.php控制器(注意大小写)
View里面的user文件夹中的html名字对应User.php中的loadview方法，注意名字相同

数据输入

return "iCocos"
return json_encode(array("name"=>"name","age"=>"age")/["name"=>"name","age"=>"age"])
return "<h1>H1</h1>"

default_return_type => 'html'/'json'
default_ajax_return => 'json'

控制器初始化
1. 必须继承控制器
2. 只要调用控制器的任务方法都会先找初始化方法
3. 提取控制器公告代码，后台权限把控
public function _initialize() {

}

前置操作
定义方法之前做的事情，把一些公共的设置提取成方法，进行调用，但是必须结合系统控制器
前置方法属性
protected $beforeActionList=[
	"abc",
	// 不让index方法使用def
	"def"=>["except"=>index],
	// 只让index方法使用ghi
	"ghi"=>["only"=>index]
	]; 



页面跳转

thinkphp/library/think/Controller.php

Loader::import('controller/Jump', TRAIT_PATH, EXT);

thinkphp/library/traits/controller/Jump.php

成功跳转

        $this->success("成功",'index/index'); // 默认跳转到上一个页面
        
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的 URL 地址
     * @param mixed  $data   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    protected function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        if (is_null($url) && !is_null(Request::instance()->server('HTTP_REFERER'))) {
            $url = Request::instance()->server('HTTP_REFERER');
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Url::build($url);
        }

        $type = $this->getResponseType();
        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('html' == strtolower($type)) {
            $template = Config::get('template');
            $view = Config::get('view_replace_str');

            $result = ViewTemplate::instance($template, $view)
                ->fetch(Config::get('dispatch_success_tmpl'), $result);
        }

        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }

失败跳转

        $this->success("失败",'index/index'); // 默认跳转到上一个页面
        
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的 URL 地址
     * @param mixed  $data   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = Request::instance()->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Url::build($url);
        }

        $type = $this->getResponseType();
        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('html' == strtolower($type)) {
            $template = Config::get('template');
            $view = Config::get('view_replace_str');

            $result = ViewTemplate::instance($template, $view)
                ->fetch(Config::get('dispatch_error_tmpl'), $result);
        }

        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }
    
修改模板页面
application/config.php中

    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    
/thinkphp/tpl/dispatch_jump.tpl

{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ padding: 24px 48px; }
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .jump{ padding-top: 10px; }
        .system-message .jump a{ color: #333; }
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
    </style>
</head>
<body>
    <div class="system-message">
        <?php switch ($code) {?>
            <?php case 1:?>
            <h1>:)</h1>
            <img src="/static/imagename.png" alt="" /> // 状态图片
            <p class="success"><?php echo(strip_tags($msg));?></p>
            <?php break;?>
            <?php case 0:?>
            <img src="/static/imagename.png" alt="" /> // 状态图片
            <h1>:(</h1>
            <p class="error"><?php echo(strip_tags($msg));?></p>
            <?php break;?>
        <?php } ?>
        <p class="detail"></p>
        <p class="jump">
            页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
        </p>
    </div>
    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>
</body>
</html>

     * @param mixed  $code   状态码
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的 URL 地址
     * @param mixed  $data   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的 Header 信息

直接在code1和0之间指定对对应的内容可以

或者指定对应的模板页面

    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_success_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_error_jump.tpl',

/thinkphp/tpl/dispatch_success_jump.tpl
/thinkphp/tpl/dispatch_error_jump.tpl

直接写dispatch_success_jump.tpl和dispatch_error_jump.tpl就可以实现自定义模板显示，
具体显示根据需求或者业务进行调整


重定向

重定向(Redirect)就是通过各种方法将各种网络请求重新定个方向转到其它位置（如：网页重定向、域名的重定向、路由选择的变化也是对数据报文经由路径的一种重定向）

状态码：
    301 redirect、302 redirect 
    
 我们在网站建设中，时常会遇到需要网页重定向的情况：
1.网站调整（如改变网页目录结构）；
2.网页被移到一个新地址；
3.网页扩展名改变(如应用需要把.php改成.Html或.shtml)。
这种情况下，如果不做重定向，则用户收藏夹或搜索引擎数据库中旧地址只能让访问客户得到一个404页面错误信息，访问流量白白丧失；再者某些注册了多个域名的网站，也需要通过重定向让访问这些域名的用户自动跳转到主站点等。

我们先来了解一下用户/搜索引擎和网站一开始的交互流程。当用户或搜索引擎向一个网站服务器发出网页浏览请求时，该服务器将：
1.通过域名服务器(DNS)将域名转换为网站的IP地址，然后返回给客户
2.打开一个该IP套接口连接
3.记下通过该套接口的一个HTTP数据流
4.从WEB服务器接收一个响应请求的HTTP数据流。该数据流包含状态码，状态码的值由HTTP协议所决定。这里所说的“HTTP数据流”信息也叫“头信息(Header)”。头信息中包括了日期，服务器类型，通常还会有一条“200 OK”信息。如果一切良好，那么网络服务器就会将“200 OK”信息以及请求页面发送出去。如果网站在这时候已经建立了重定向，那么服务器就会在头信息中包含一个“302 Moved Temporarily”或“301 Moved Permanent”之类的响应信息。搜索引擎会根据服务器头信息中的内容作出决定。


    /**
     * URL 重定向
     * @access protected
     * @param string    $url    跳转的 URL 表达式
     * @param array|int $params 其它 URL 参数
     * @param int       $code   http code
     * @param array     $with   隐式传参
     * @return void
     * @throws HttpResponseException
     */
    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        if (is_integer($params)) {
            $code   = $params;
            $params = [];
        }

        $response = new Redirect($url);
        $response->code($code)->params($params)->with($with);

        throw new HttpResponseException($response);
    }

$this-> redirect('index/index',['name'=>'name', 'id'=>'99'], 301或302)

空操作

作用解决用户恶意输入，报错影响用户体验
public function _empty() {
	$this-> redirect('index/index')
}

空控制器

网站上线每个控制都必须写空操作，不论前台后台，都必须写一个Error.php控制器

controller下新建一个Error.php控制器

	<?php
	namespace app\index\controller;
	
	class Error{
		// index重定向
		public function index() {
			$this->redirect('index/index');
		}
		
		// 空操作
		public function _empty() {
			$this-> redirect('index/index')
		}	
	}
	?>

资料控制

通过命令生成控制
主目录中有一个think可执行文件

#!/usr/bin/env php
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

// 定义项目路径
define('APP_PATH', __DIR__ . '/application/');

// 加载框架引导文件
require __DIR__.'/thinkphp/console.php';

在主目录即application同级目录中操作命令行：php think 

Think Console version 0.1

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -V, --version         Display this console version
  -q, --quiet           Do not output any message
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  build               Build Application Dirs
  clear               Clear runtime file
  help                Displays help for a command
  list                Lists commands
 make
  make:controller     Create a new resource controller class
  make:model          Create a new model class
 migrate
  migrate:breakpoint  Manage breakpoints
  migrate:create      Create a new migration
  migrate:rollback    Rollback the last or to a specific migration
  migrate:run         Migrate the database
  migrate:status      Show migration status
 optimize
  optimize:autoload   Optimizes PSR0 and PSR4 packages to be loaded with classmaps too, good for production.
  optimize:config     Build config and common file cache.
  optimize:route      Build route cache.
  optimize:schema     Build database schema cache.
 queue
  queue:listen        Listen to a given queue
  queue:restart       Restart queue worker daemons after their current job
  queue:subscribe     Subscribe a URL to an push queue
  queue:work          Process the next job on a queue
 seed
  seed:create         Create a new database seeder
  seed:run            Run database seeders
  
创建MVC：

php think make:controller app\index\controller\Conter
php think make:controller app\index\view\conter
php think make:controller app\index\model\conter