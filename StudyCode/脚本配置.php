<?php
    
### 配置类型和位置

1. 惯例配置：通用全局配置
thinkphp5_1/thinkphp/convention.php

2. 应用配置：App应用，后台配置
thinkphp5_1/application/config.php

3. 拓展配置：对真个配置文件分类管理(分目录)
    thinkphp5_1/application/database.php
    thinkphp5_1/application/extra/自定义配置文件

4. 场景配置：环境切换配置：
thinkphp5_1/application/config.php
// 应用模式状态 
'app_status'             => 'home',  application新建对应home文件，编写配置
'app_status'             => 'office',  application新建对应office文件，编写配置

5. 模块配置：模块特有，对应模块config.php
thinkphp5_1/application/admin

6. 动态配置：临时性配置，执行的时候设置

### 设置动态配置
系统方法：config('name', 'PHP动态配置');
系统类: \think\Config::set('name', 'PHP动态配置');

### 读取配置
系统方法：config('key')   
系统类：\think\Config::get('key')
使用use：use \think\Config     Config::get('key')
数组 config('key') config('key.name') 上同
扩展配置分类：config('key.name')  'key'所有

### 系统相关
系统类：thinkphp5_1/thinkphp/library/think  
系统方法：thinkphp5_1/thinkphp/helper.php

### 配置顺序
配置文件加载顺序：反向加载，合并同名覆盖，不同名保留
动态配置 -> 模块 -> 场景 -> 扩展 -> 应用 -> 管理

### 环境变量配置
新建： thinkphp5_1/.env  // 非php，直接键值对或数组，不支持中文
name=icocos
[database]
type=mysql
root = root
读取：
think\Env::get('name')
think\Env::get('database.type') // 不能直接database.type


?>