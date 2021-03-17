# 在 Laravel 中使用 MongoDB

Finish!

## 安装 Laravel-MongoDB

### 推荐组件

注意：

- 在laravel5.4中(其他版本尚未测试)，直接composer加载组件会报错，应该选相应的版本3.2
```
// 直接加载
composer require jenssegers/mongodb
// 指定版本号加载
composer require jenssegers/mongodb 3.2
// 可以考虑这个
composer require jenssegers/mongodb v3.3.0-alpha
```

### 注册服务

位置：config/app.php => providers
```
// 添加上
Jenssegers\Mongodb\MongodbServiceProvider::class,
```

### 添加Facades

位置：config/app.php => aliases
```
// 添加上
'Mongo'     => Jenssegers\Mongodb\MongodbServiceProvider::class,
```

### 修改数据库配置文件 
位置：config/database.php
```
// 添加 MongoDB 的数据库的信息:
'mongodb' => [    
        'driver'   => 'mongodb',    
        'host'     => 'localhost',    
        'port'     => 27017,    
        'database' => 'mydb',    
        'username' => '',    
        'password' => '',
],

'default' => env('DB_CONNECTION', 'mysql'),

改成:

'default' => env('DB_CONNECTION', 'mongodb'),
```

## 使用篇(使用方法与Laravel的数据库使用无异)

详细的使用文档：
https://packagist.org/packages/jenssegers/mongodb

查询构造器
```
class MongoController extends Controller{
    pubulic function index(){
        DB::collection('users')               //选择使用users集合
              ->insert([                          //插入数据
                      'name'  =>  'tom', 
                      'age'     =>   18
                  ]);
    }

    $res = DB::collection('users')->all();  //查询所有数据
    dd($res);                                            //打印数据
}
```
```
use DB;   //引用数据库

class MongoController extends Controller{
    pubulic function index(){
        DB::connection('mongodb')       //选择使用mongodb
              ->collection('users')           //选择使用users集合
              ->insert([                          //插入数据
                      'name'  =>  'tom', 
                      'age'     =>   18
                  ]);
    }

    $res = DB::connection('mongodb')->collection('users')->all();   //查询所有数据
    dd($res);                                            //打印数据
}
```

## Eloquent 模型


在 config/app.php 配置文件中配置 MongoDB 的 Eloquent 类的别名
```
'Moloquent' => 'Jenssegers\Mongodb\Eloquent\Model',
```

新建一个 User.php 的 Model 类

```
<?php
    namespace App;
    use Moloquent;
    use DB;

    class Users extends Moloquent{    
        protected $connection = 'mongodb';  //库名    
        protected $collection = 'users';     //文档名    
        protected $primaryKey = '_id';    //设置id    
        protected $fillable = ['id', 'name', 'phone'];  //设置字段白名单
    }
```

在 UserController.php 控制器中这样使用

```
<?php
namespace App\Http\Controllers;
    use App\Users;    //引入Users模型

    class MongoController extends Controller{
        public function index(){
        Users::create([                      //插入数据
            'id'     =>1,
            'name'   =>'tom',
            'phone'  =>110]);
        }

        dd(Users::all());          //查询并打印数据
```














