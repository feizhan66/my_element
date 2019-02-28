1.数据库建表
```php
php artisan queue:table	//队列任务表
php artisan queue:failed-table//任务执行失败表
php artisan migrate
```

2.创建job类

php artisan make:job ProcessPodcast
3.在job类中，实现逻辑
job主要包括三个函数

构造函数 可选，用来传参
handle（） 必选，实现队列任务逻辑
failed() 可选，当任务失败时执行
4.分发队列任务

ProcessPodcast::dispatch($podcast);
对于队列中很常用的一个场景，延迟任务，在laravel中只需调用delay（）方法
ProcessPodcast::dispatch($podcast)
                ->delay(now()->addMinutes(10));

5.开启队列进程，执行队列任务
php artisan queue:work
这种方式不能关闭teminal，比较不方便。所以一般使用Supervisor。


以上就可以完成一个简单的队列任务。


注意：在env上需要配置QUEUE_DRIVER