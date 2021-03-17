Laravel中的队列处理
队列介绍
本文章转载于：http://www.w2bc.com/article/116100
为什么要有消息队?这里先对其进行一个简单的介绍,方便还不了解的同学理解.在面向对象里,有一个很简单的概念--消息传递,而消息队列就可以在它上面扩展一下,把它说的更通俗些:从执行的角度去看,消息队列把原
来可直接调用的一个函数(一段程序或一个对象)放到另一个进程中了,所以它们之间的消息传递就从直接传递参数变成了以队列为载体来传递所需参数的一种方式.更加详细的介绍可以参考这篇文章

众所周知,laravel是个优雅的框架,它的队列处理也不例外,可以先看看手册
Laravel 5.2 文档 服务 —— 队列(这篇文章是英文版手册翻译,内容详尽).在基本了解它的使用之后,我们就可以来分析分析相关源代码，学习它的原理了(该篇文章只探讨基于Redis的队列服务).

队列Service
laravel把队列相关的服务全封装在一个Service里面，通过Queue Service Provider 注册到IOC中.在Queue Serivce里提供了多种服务，关于它做了什么请看以下代码中的注释(代码有点多,就不全部贴出来了)

```php
public function register()
{
    // 注册Manager, 而Manager为队列服务的统一入口
    $this->registerManager();
    // 注册队列的各种命令
    $this->registerWorker();
 
    $this->registerListener();
    // 注册任务执行失败后的记录
    $this->registerFailedJobServices();
    // 未知
    $this->registerQueueClosure();
}
```

讲配置文件

在Queue Service注入到IOC后，我们就可以使用队列了。
一个队列服务最基本的就是把任务写入队列,再将其拿出来执行, 很简单.所以队列服务最基本的要素有四点:任务,进队列,出队列,执行.在这里,我们就跟着这四个要素的步伐,看看它们在laravel中是如何实现的.这里，先以官方的示例来分析，有了一个具体概念之后再举一反三，学会它的本质。

任务
队列服务就是围绕着任务进行的.在手册上,通过它的实例SendReminderEmail,我们可以很清楚地知道,laravel可以对一个任务做很多事,比如:可设置重新执行的次数,说明该任务(若失败)可以被执多次(针对的是单个Job);可设置是否可以延迟执行;对该Job设置处理的队列名称,等等.这些功能都是\Illuminate\Bus\Queueable提供的,当然,实例中还有一个\Illuminate\Queue\InteractsWithQueue,而它则是针对Job所用(稍后再说).一个任务建立完成后,就需要使其进入队列了。当然了，除了以上几个特点，还有任务的执行逻辑等等，要全面地了解任务，就需要清楚它的数据结构，其在队列中的数据结构会在进入队列中讲到.

任务进队列
示例中，在定义了任务之后，就将其用Controller中的方法使其进入了队列，那么这一点是如何实现的？

代码在:\Illuminate\Foundation\Bus\DispatchesJobs
```php
protected function dispatch($job)
{
    return app(Dispatcher::class)->dispatch($job);
}
 
/**
 * Dispatch a command to its appropriate handler in the current process.
 *
 * @param  mixed  $job
 * @return mixed
 */
public function dispatchNow($job)
{
    return app(Dispatcher::class)->dispatchNow($job);
}
这段代码的意图得了解app(Dispather::class), 这个则在\Illuminate\Bus\BusServiceProvider中表现的很明确了(为什么是这里就不分析了),app(Dispather::class)就是\Illuminate\Bus\Dispatcher.现在,上面代码中的dispatch与 dispatchNow方法就会逐渐清晰起来.简言之,该Dispatcher类做了两件事,执行该任务或把该任务放入队列,也就是将队列任务分为了两种执行方式,立即执行或以消息队列执行,与队列相关的代码如下:

/**
* 把任务分发到队列中
* @param string $command 任务类
*/
public function dispatchToQueue($command)
{
    $connection = isset($command->connection) ? $command->connection : null;
    // laravel里内置了多种队列服务,这里则解析出来
    $queue = call_user_func($this->queueResolver, $connection);
    
    // 队列服务解析不成功则抛出异常
    if (! $queue instanceof Queue) {
        throw new RuntimeException('Queue resolver did not return a Queue implementation.');
    }
    
    // 在任务类中可自定义queue方法进入队列
    if (method_exists($command, 'queue')) {
        return $command->queue($queue, $command);
    } else {
        // 系统提供的一种进入队列方式
        return $this->pushCommandToQueue($queue, $command);
    }
}
 
/**
* 根据不同的任务属性选择不同的进入队列方式
* 这里所提到的方式在手册中有提到
* @param Queue $queue 队列服务
* @param $command 任务类
*/ 
protected function pushCommandToQueue($queue, $command)
{
    // 该推任务设置了延迟,且设置队列名称
    if (isset($command->queue, $command->delay)) {
        return $queue->laterOn($command->queue, $command->delay, $command);
    }
    //设置队列名称
    if (isset($command->queue)) {
        return $queue->pushOn($command->queue, $command);
    }
    //设置延迟
    if (isset($command->delay)) {
        return $queue->later($command->delay, $command);
    }
    // default 
    return $queue->push($command);
}
到现在为止，Controller已经展示了一种进入队列的方法，很明显它是经过封装提供的接口,虽然很好用,但有些操作是我们所不必须的,比如:是否立即执行,进入队列就需设置不同的任务参数等等,需要更好的为我们所用,就再深入一点，找出它进入队列的关键点（与Redis交互的地方）.上面已经提到call_user_func($this->queueResolver, $connection);会得到一个队列服务,那么$this->queueResolver是什么?在\Illuminate\Bus\BusServiceProvider:23就可以看到:

    // 理解这个回调,则需要了解Illuminate\Contracts\Queue\Factory
    // 在vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1051 可以看到它与Illuminate\Queue\QueueManager的关系了
    $this->app->singleton('Illuminate\Bus\Dispatcher', function ($app) {
        return new Dispatcher($app, function ($connection = null) use ($app) {
            return $app['Illuminate\Contracts\Queue\Factory']->connection($connection);
        });
    });
```

QueueManager
在laravel中，Service对外的统一接口都是其Manager，其中与所需服务交互的基本上是通过__call 方法提供，这种方式有两个优点，一，提供统一的接口，二，分层明确(将实际的处理由__call转发,与配置相关的则由manager自己解决).

现在为了使任务进入队列的过程更清晰,一步一步找到了QueueManager,这个类设置了很多事件接口,和其他连接相关方法.其中connection方法就展示了一个队列服务是如何解析出来的了.
其实这段解析的代码唯一的难点中于:
```php
protected function getConnector($driver)
{
    if (isset($this->connectors[$driver])) {
        return call_user_func($this->connectors[$driver]);
    }
 
    throw new InvalidArgumentException("No connector for [$driver]");
} 
```

为什么这么一段简单的代码就能解析队列服务?查看QueueServiceProvider就一目了然了.其中就注册了很多队列服务.redis的队列服务处理则是\Illuminate\Queue\RedisQueue.

QueueManager的功能现在很清晰了.1,解析队列服务 2,转发(__call)处理到相应的队列服务中 3,提供队列相关接口 .既然QueueManager有这么多队列相关的功能,那么我们完全可以把它作为一个队列处理的入口(直接获取队列服务再进行操作是并不是明智的选择),巧的是laravel也是这么做的.所以现在有两种方式进入队列,1,使用\Illuminate\Foundation\Bus\DispatchesJobs间接与队列服务通信 2,使用QueueManager间接与队列服务通信.当然这些方法都是在\Illuminate\Queue\RedisQueue(队列服务的接口)上扩展的.所以掌握该类,就能明白队列的各种行为了.

RedisQueue
队列服务在lavavel中提供了多种,这里只对以Redis队列服务进行分析学习.所以有关队列的处理都集中在\Illuminate\Queue\RedisQueue.上面也说到了,有两种方式进入队列, 分别使用,看它们产生的任务数据结构有什么区别?(数据结构便于分析,在后面会提到)

在Controller使用 $this->dispatch((new SendReminderEmail()));即以任务类进入
```php
{
"job": "Illuminate\\Queue\\CallQueuedHandler@call",
"data": {
"command": "O:26:\"App\\Jobs\\SendReminderEmail\":4:{s:5:\"queue\";s:5:\"email\";s:10:\"connection\";N;s:5:\"delay          \";N;s:6:\"\u0000*\u0000job\";N;}"
},
 "id": "7u00jImd8CAns0fQO8jedqkQmnbQsfsr",
"attempts": 1
}
```

直接使用 Queue::push(SendReminderEmail::class , ['email'=>'123456789@qq.com'],'email');
```php
{
"job": "App\\Jobs\\SendReminderEmail",
"data": {
"email": "123456789@qq.com"
},
"id": "I0OeBIQjJjisQrZ7STX3zexrBLF7Uilx",
"attempts": 1
}
```

上面讲到，构成消息队列需要两个进程，所以上面的进入队列是一个进程，现在的出队列及执行任务则在另一个进程中执行。lavarel提供了两个命令来启动该进程，quque:work ,queue:litsen 当然，再理解了如何完成这些操作后完全可以自己写一个命令，现在看看它是如何出队列和如何执行任务？

任务出队列
在手册中，对于一个任务可以指定多种属性，比如，延迟，失败次数，队列名称等等，当然，所有可执行操作或功能都得依赖数据结构，数据结构的制定也是为了实现相应的行为.所以，RedisQueue的代码对应上面的数据结构来理解就比较容易了。

RedisQueue是所有队列服务（Redis）的基础接口，所以任务出队列的操作也能在这找到。假设现在已经对RedisQueue的代码已经有点熟悉了，不难发现，有一个稍复杂的pop方法（出队列）。那么，问题出现了，出队列是如何实现的？解决了这个问题,任务出队列就可算是完成了.

队列应有的功能
查看php artisan queue:work --help命令的使用方法,整理有关队列所需的功能或服务:

指定队列名称
任务的执行逻辑
任务执行延迟
任务中失败的最大次数
当然还有其他关于该命令的功能,比如:是否以守护进程执行,是否强制执行,限制进程执行的memory,无任务时的等待时间.这些与命令相关的因不同的命令而异,与队列任务无关.这样,在理清队列任务需要的功能后,我们就可以分析它的数据结构,理解代码了.

队列数据结构
数据结构都是依据行为而建立.所以在查看pop方法时,可考虑以上几个点.上面的数据结构中,已经可以看到队列的执行逻辑,所需参数,失败次数,这些一目了然,就不啰嗦了.在整个pop方法中,有这么几个队列,queue:delayed,queue:reserved,queue.本来取出一个任务用lpop就可完成,为什么要多用两个集合(注意,是有序集合不是队列)来完成pop操作呢?因为要实现任务延迟和失败处理.
其执行过程如图:


过程解析:
(1). 取任务,因为要实现延迟的功能,所以在有序集合里的score是过期时间,过期时间的含义则是在此时间之前不执行,也就达到了延迟执行的效果.延迟的含义在这里指的并不是在多少秒后执行,而是在多少秒内不执行.对于过期的任务,就将其rpush到队列中,直到lpop操作将其拿走.
(1).为什么在存在queue:reserved集合并且把lpop的任务zadd进支?因为只要lpop了job就可以将其记录下来,若此时任务还未开始执行进程就非正常终止了,该任务就不会丢失,再次执行时,依据上面的步骤就可以将其取出,防止意外使job丢失.
(2).队列的执行都是依据json中的类来完成,这部分较简单,略.
(3).当任务执行成功时,要手动删除queue:reserved中的任务;当任务执行失败,删除queue:reserved中的任务,再将其记录下来,记录方式是zadd queue:delayed, 并且将该任务的执行次数加一,这个过程RedisQueue已经封装(RedisQueue::release)好了.

这一系列的过程就完成了让队列任务延迟的功能.所以这么复杂的操作都是为了实现延迟的功能,当然,有更好的点子可以考虑自己实现.

执行任务
到此，任务的执行在json数据结构中表现的很明确,整个处理过程也很清晰了.需要注意的是当任务执行成功后要删除任务.对于如何执行出队列,以及如何执行队列任务,可以详细看看queue:work命令(\Illuminate\Queue\Console\WorkCommand::fire), 它是最好的示例;

队列处理命令的自定义
在使用queue:work之后,会发现它并不有处理所有的情况.所以在本文中一直提到过,自写一个处理命令是可行的.当面临queue:work所不能解决的问题时,可以好好考虑下自己编写.在实际开发中,任务的种类繁多,对于不同的任务应该有不同的处理方案.所以,有以下几个问题是经常遇到的:
比如:

调用服务发生错误且由服务提供方造成,需另作记录,而这样的错误不算作job的执行错误
营销短信只能在9:00到20:00之间发送, 所以在该时间段内没有执行的必要
与数据库交互时,数据库连接是有时间限制的,而以守护进程的方式执行则无时间限制,这样就会报错
所以,面临laravel所提供命令的局限性,有自定义处理命令的能力是很有必要的.

小结
之于框架(优秀开源产品),只不过是有着作者个人风格的一些封装,要真正的学会使用它,则需要把这种风格化的表象移除, 看到这层’皮’下到底是什么,这样才能学习到框架的本质.希望这篇文章能给同学们带来一点帮助.

