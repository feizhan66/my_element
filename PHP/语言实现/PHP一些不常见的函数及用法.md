# 退出(包含意外退出)时使用

```php
# 例如：日志的保存需要在退出(包含意外退出)的时候保存
# 开启日志的时候就注册这个函数，运行到最后自动保存日志
register_shutdown_function(function() {
   Logger::save();
});
```

# 判断方法是否存在

```php
$one = User::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => ['id' => $appId],
        ]);
        if (!method_exists($one, 'toArray')) {
            //查表记录不存在时，$one为布尔值false，也就不存在toArray方法
            return [];
        }
        return $one->toArray();
```
