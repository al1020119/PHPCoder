+ 1. public中menu里面处理：管理员管理 模块

```bash
<dl id="menu-admin">
	<dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
	<dd>
		<ul>
			<li><a data-href="{:url('admin/add')}" data-title="添加用户" href="javascript:void(0)">添加用户</a></li>
		</ul>
	</dd>
</dl>
```

> data-href="{:url('admin/add')}": 对应位置是admin/add,即当前view中admin里面的add.html

+ 2. 在view里面新建admin，里面在新建add.html,处理add.html中表单

```bash
<form class="form form-horizontal" id="form-admin-add" method="post" action="{:url('admin/add')}">
```

> action="{:url('admin/add')}": 表单提交对应的是admin对应的控制器，里面的add方法
 
+ 3. 在controller里面新建Admin.php(必须大写),里面新增add方法
 
```bash
namespace app\admin\controller;

use think\Controller;
	
class Admin extends Controller
{
    public function add()
    {
        // 是否是POST提交
        if (request()->isPost()) {
            //dump(input('post.'));
            $data = input('post.');
            <!--验证: AdminUser-->
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
			  <!--加密-->
            $data['password'] = md5($data['password'].'_#dev_icocos_php');
            
            $data['status'] = 1;
			  <!--异常-->
            try {
            		<!--模型层数据传递：AdminUser-->
                $id = model('AdminUser')->add($data);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
			  <!--状态判断-->
            if ($id) {
                $this->success('id='.$id.'的用户新增成功');
            } else {
                $this->error('error');
            }
        } else {
            // 非POST
        }
        return $this->fetch(); //显示到view
    }
}
```

+ 4. 其中顶层模块新建common，里面新建两个文件夹
 
	+ 4.1 validate里面AdminUser.php对应全局验证，配置规则就可以

```bash
namespace app\common\validate;
	
use think\Validate;
	
class AdminUser extends Validate {
    protected $rule = [
      'username' => 'require|max:20',
      'password' => 'require|max:20',
    ];
}
```
+ 4.2 common里面AdminUser.php对应模型数据

```bash
namespace app\common\model;
	
use think\Model;
	
class AdminUser extends Model {
    protected $autoWriteTimestamp = true; // 直接默认使用写入(创建)时间
    public function add($data) {
        if (!is_array($data)) {
            exception("数据传输不合法");
        }
        <!--数据库存储-->
        $this->allowField(true)->save($data);
        return $this->id;
    }
}
```
