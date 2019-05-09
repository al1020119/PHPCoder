<?php

    # 跨控制器调用: 当前模块
    public function callback_current_model()
    {
        // 调用前台User

        // 方式1：直接实例化->前台
        $model1 = new \app\index\controller\User;
        echo $model1->index();

        // 方法2： use \app\index\controller\User
        $model2 = new User;
        echo $model2->index();

        // 方法3：系统方法
        $model3 = controller("User");
        echo $model3->index();
    }


    # 跨控制器调用: 不同模块->后台
    public function callback_cothers_model()
    {
        // 调用前台User

        // 方式1：直接实例化
        $model1 = new \app\admin\controller\Index;
        echo $model1->index();

        // 方法2： use \app\index\controller\User
        $model2 = new AdminIndex;
        echo $model2->index();

        // 方法3：系统方法
        $model3 = controller("admin/Index");
        echo $model3->index();
    }


    # 调动当前模块当前控制器中的方法
    public function callback_current_method()
    {
        $this->test();
        self::test();
        Index::test();
        action('test');
    }

    # 调动当前模块其他控制器中的方法
    public function callback_others_method()
    {
        $model1 = new \app\index\controller\User;
        echo $model1->test();

        echo action('User/test');
    }

    # 调动其他模块其他控制器中的方法
    public function callback_others_model_method()
    {
        // 方式1：直接实例化
        $model1 = new \app\admin\controller\Index;
        echo $model1->test();

        echo action('admin/index/test');
    }

?>