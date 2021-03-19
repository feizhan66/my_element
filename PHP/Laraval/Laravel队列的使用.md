# Laravel 队列的使用

## 简介
Laravel支持多种形式的队列，例如 Beanstalk，Amazon SQS， Redis，甚至其他基于关系型数据库的队列.队列的目的是将耗时的任务延时处理，比如发送邮件，从而大幅度缩短Web请求和相应的时间。

## 队列配置

- 配置文件
```angular2html
// 路径
config/queue.php

// 在 connections 中配置

// 例子：配置Redis
'redis' => [
    'driver' => 'redis',
    'connection' => 'default',
    'queue' => 'default',
    'retry_after' => 90,
],
```
要注意的是， queue 配置文件中每个连接的配置示例中都包含一个 queue 属性。这是默认队列，任务被发给指定连接的时候会被分发到这个队列中。换句话说，如果你分发任务的时候没有显式定义队列，那么它就会被放到连接配置中 queue 属性所定义的队列中：
```angular2html
// 这个任务将被分发到默认队列...
dispatch(new Job);

// 这个任务将被发送到「emails」队列...
dispatch((new Job)->onQueue('emails'));
```
有些应用可能不需要把任务发到不同的队列，而只发到一个简单的队列中就行了。但是把任务推到不同的队列仍然是非常有用的，因为 Laravel 队列处理器允许你定义队列的优先级，所以你能给不同的队列划分不同的优先级或者区分不同任务的不同处理方式了。比如说，如果你把任务推到 high 队列中，你就能让队列处理器优先处理这些任务了：
```angular2html
php artisan queue:work --queue=high,default
```
## 驱动的必要设置

### 数据库
要使用 database 这个队列驱动的话， 你需要创建一个数据表来存储任务，你可以用 queue:table 这个 Artisan 命令来创建这个数据表的迁移。 当迁移创建好以后，就可以用 migrate 这条命令来创建数据表：
```angular2html
php artisan queue:table

php artisan migrate
```

### Redis
为了使用 redis 队列驱动， 你需要在你的配置文件 config/database.php 中配置Redis的数据库连接

如果你的 Redis 队列连接使用的是 Redis 集群， 你的队列名称必须包含 key hash tag 。 这是为了确保所有的 redis 键对于一个给定的队列都置于同一哈希中：
```angular2html
'redis' => [
    'driver' => 'redis',
    'connection' => 'default',
    'queue' => '{default}',
    'retry_after' => 90,
],
```
注意：使用Redis首先要确保的是Redis功能正常

## 创建任务列

### 生成任务类
在你的应用程序中，队列的任务类都默认放在 app/Jobs 目录下，如果这个目录不存在，那当你运行 make:job artisan 命令时目录就会被自动创建。 你可以用以下的 Artisan 命令来生成一个新的队列任务：
```angular2html
php artisan make:job SendReminderEmail
```
生成的类实现了 Illuminate\Contracts\Queue\ShouldQueue 接口，这意味着这个任务将会被推送到队列中，而不是同步执行。

### 任务类结构
任务类的结构很简单，一般来说只会包含一个让队列用来调用此任务的 handle 方法。我们来看一个示例的任务类，这个示例里，假设我们管理着一个播客发布服务，在发布之前需要处理上传播客文件：
```angular2html
<?php

namespace App\Jobs;

use App\Podcast;
use App\AudioProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPodcast implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * 创建一个新的任务实例。
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;
    }

    /**
     * 运行任务。
     *
     * @param  AudioProcessor  $processor
     * @return void
     */
    public function handle(AudioProcessor $processor)
    {
        // Process uploaded podcast...
    }
}
```
注意，在这个例子中，我们在任务类的构造器中直接传递了一个 Eloquent 模型。因为我们在任务类里引用了 SerializesModels 这个
，使得 Eloquent 模型在处理任务时可以被优雅地序列化和反序列化。如果你的队列任务类在构造器中接收了一个 Eloquent 模型，那么只有可识别出该模型的属性会被序列化到队列里。当任务被实际运行时，队列系统便会自动从数据库中重新取回完整的模型。这整个过程对你的应用程序来说是完全透明的，这样可以避免在序列化完整的 Eloquent 模式实例时所带来的一些问题。

在队列处理任务时，会调用 handle 方法，而这里我们也可以通过 handle 方法的参数类型提示，让 Laravel 的 服务容器 自动注入依赖对象。

```angular2html
{note} 像图片内容这种二进制数据， 在放入队列任务之前必须使用 base64_encode 方法转换一下。 否则，当这项任务放置到队列中时，可能无法正确序列化为 JSON。
```

### 分发任务
你写好任务类后，就能通过 dispatch 辅助函数来分发它了。唯一需要传递给 dispatch 的参数是这个任务类的实例：
```angular2html
<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPodcast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PodcastController extends Controller
{
    /**
     * 保存播客。
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // 创建播客...

        dispatch(new ProcessPodcast($podcast));
    }
}
```

### 延迟分发
如果你想延迟执行一个队列中的任务，你可以用任务实例的 delay 方法。 这个方法是 Illuminate\Bus\Queueable trait 提供的，而这个 trait 在所有自动生成的任务类中都是默认加载了的。对于延迟任务我们可以举个例子，比如指定一个被分发10分钟后才执行的任务：
```angular2html
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\ProcessPodcast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PodcastController extends Controller
{
    /**
     * 保存一个新的播客。
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // 创建播客...

        $job = (new ProcessPodcast($podcast))
                    ->delay(Carbon::now()->addMinutes(10));

        dispatch($job);
    }
}
```


## 启动进程
php artisan queue:work --sleep=3