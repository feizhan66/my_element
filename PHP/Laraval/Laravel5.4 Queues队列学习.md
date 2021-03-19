# Laravel5.4 Queues队列学习

## 简介
Laravel提供了开箱即用的队列服务，队列允许您延迟处理耗时的任务，例如发送电子邮件，直到稍后的时间。推迟这些耗时的任务会大大加速您的应用程序的Web请求。

## 配置
文档链接
https://laravel-china.org/docs/laravel/5.4/queues/1256


## 生成队列表

```
php artisan queue:table

php artisan migrate
```

## 生成Job类

这里我们给发送邮件操作添加队列操作

```
php artisan make:job SendReminderEmail
```
SendReminderEmail.php
```
<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected  $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 打印调试
        \Log::info('send remind email to' . $this->user->email);
    }
}
```

我们以 User Model为例，先在构造器方法中注入User 类，然后在UsersController.php 中使用dispatch 加入到队列中，dispatch(new SendReminderEmail($user));

添加到队列后，我们需要在handle() 方法中处理具体的业务逻辑，如给具体的用户对象发送邮件，最后执行队列命令，即可发送邮件。

```
// 这是重点！，不启动将不会执行
php artisan queue:work
```













