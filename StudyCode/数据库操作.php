<?php
    
    // 查询数据
    public function selectDB()
    {
        // // 1. 原生更新记录
        $result1 = Db::query('delete from t_php_0002 where id=38');
        var_dump($result1);

        // 2. TPS岔村构造器方法
        $result2 = DB::table('t_php_0002')->where('id', 39)->delete();
        var_dump($result2);

        // 3. 去掉表前缀:think_
        $result3 = Db::name('t_php_0002')->where('id', 40)->delete();
        var_dump($result3);

        // 4. 助手Db函数
        $db = db('t_php_0002');
        $result4 = $db->where('id', 41)->delete();
        var_dump($result4);
    }

    // 删除数据
    public function deleteDB()
    {
        // 1. 原生更新记录
        $result1 = Db::query('select * from t_php_0002 where id<>5');
        var_dump($result1);

        // 2. TPS岔村构造器方法
        $result2 = DB::table('t_php_0002')->where('id', 16)->select();
        var_dump($result2);

        // 3. 去掉表前缀:think_
        $result3 = Db::name('t_php_0002')->where('id', 16)->select();
        var_dump($result3);

        // 4. 助手Db函数
        $db = db('t_php_0002');
        $result4 = $db->where('id', 16)->select();
        var_dump($result4);
    }

    // 更新数据
    public function updateDB()
    {
        // 1. 原生更新记录
        $result1 = Db::execute('update t_php_0002 set name = "framework" where id=16');
        var_dump($result1);

        // 2. TPS岔村构造器方法
        DB::table('t_php_0002')->where('id', 16)->update(['name'=>"iCocos XXX"]);

        // 3. 去掉表前缀:think_
        Db::name('t_php_0002')->where('id', 16)->update(['name'=>"iCocos YYY"]);

        // 4. 助手Db函数
        $db = db('t_php_0002');
        $db->where('id', 16)->update(['name'=>"iCocos MMM"]);
    }

    // 插入数据
    public function insertDB()
    {   
        // 1. 原生插入记录
        $result1 = Db::execute('insert into t_php_0002 (name, status) values ("thinkphp002", 12)');
        var_dump($result1);

        // 2. TPS岔村构造器方法
        Db::table('t_php_0002')->insert(['name'=>'PHP0002','status'=>10]);

        // 3. 去掉表前缀:think_
        Db::name('t_php_0002')->insert(['name'=>"iCocos"]); 

        
        $db = db('t_php_0002');


        // 4. 直接插
        $result2 = $db->insert(['name'=>"iCocos four"]);
        var_dump($result2);

        // 5. 插入并获取结果
        $result3 = $db->insertGetId(['name'=>"iCocos four"]);
        var_dump($result3);

        // 插入多条
        $data1 = [
            ['name'=>'x'],
            ['name'=>'Y'],
            ['name'=>'Z']
        ];
        $res = $db->insertAll($data1);
        var_dump($res);
    }
    
?>