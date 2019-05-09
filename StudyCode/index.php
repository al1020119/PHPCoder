<?php
    
    #输出
    echo "1. string";
    echo '2. iCocos';
    $name = "3. PHP iCocos";
    var_dump($name);
    
    # 注释
    // 1.
    #  2.
    /* 3. */  
    
    # PHP
    // 超文本预处理器：服务器端开源脚本语言。 
    // 所有软件(PHP,Mysql,Apache/Nginx)形成了服务器,
    // Apache/Nginx提供了网址访问能力，里面还有一个PHP解析器
    // Mysql读取数据库

    # PHP输出的是html
    echo '<b>4. iCocos B</b>';

    # 变量
    $a0 = "5. var name";
    echo $a0;
    var_dump($a0); // 类型(值/长度/大小/类型) .."原始字符串"

    # 数据类型：四种标量(整型，浮点，布尔，字符串)，复合类型(数组，对象，资源)，null，可调用
    $a1 = 1;
    $a2 = 1.5;
    $a3 = true;
    $a4 = 'string$a1';
    $a41 = "string1$a1";

    $a5 = [1,2,3];
    $a51 = array(1,2,3);
    $a6 = new stdClass;
    # $a7 = 资源 
    
    $a8 = null;
    # $9 = 可调用

    # 单引号和双引号
    echo "</br>";
    echo $a4;
    echo "</br>";
    echo $a41; // 双引号里面有变量会之别变量

    # 获取类型: var_dump
    // $a1 + $a4 = 1; // 自动转换，转换不成功就是0，(int)强制转换
    // $a1 + '1' = 2; // 自动转换，转换成功了
    
    /* 
    <?php ?> 和 <script language="php"> </script>
    
    // 1.  <?php echo 'if you want to serve XHTML or XML documents, do it like this'; ?>

    <script language='php'></script>这种写方在php7.0后已经不解析了。
    // 2.  <script language="php">
    //         echo 'some editors (like FrontPage) don\'t
    //               like processing instructions';
    //     </script>

    短标记和 ASP 风格标记
    
    短标记（上例 3）仅在通过 php.ini 配置文件中的指令 short_open_tag 打开后才可用，或者在 PHP 编译时加入了 --enable-short-tags 选项
    // 3.  <? echo 'this is the simplest, an SGML processing instruction'; ?>
    //     <?= expression ?> This is a shortcut for "<? echo expression ?>"
    
    ASP 风格标记（上例 4）仅在通过 php.ini 配置文件中的指令 asp_tags 打开后才可用。
    // 4.  <% echo 'You may optionally use ASP-style tags'; %>
    //     <%= $variable; # This is a shortcut for "<% echo . . ." %>
    */

    // 在 PHP 5.2 和之前的版本中，解释器不允许一个文件的全部内容就是一个开始标记 <?php。自 PHP 5.3 起则允许此种文件，但要开始标记后有一个或更多白空格符。

    // 自 PHP 5.4 起，短格式的 echo 标记 <?= 总会被识别并且合法，而不管 short_open_tag 的设置是什么。

    // PHP-GTK 是 PHP 的一个扩展,可以编写跨平台的应用程序

    //  PHP 4 不支持 OOP 所有的标准, PHP 5 弥补了 PHP 4 的这一弱点，引入了完全的对象模型。

    // CGI：通用网关接口（Common Gateway Interface）是一个Web服务器主机提供信息服务的标准接口。通过CGI接口，Web服务器就能够获取客户端提交的信息，转交给服务器端的CGI程序进行处理，最后返回结果给客户端。

    // 组成CGI通信系统的是两部分：一部分是html页面，就是在用户端浏览器上显示的页面。另一部分则是运行在服务器上的Cgi程序。


?>