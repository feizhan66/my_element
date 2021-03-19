首先运行命令检测当前cli环境是否支持:
```php
    curl -Ss http://www.workerman.net/check.php | php
    php -m //查看当前cli环境php模块
```

一、安装 workerman

在项目根目录执行
```php
composer require workerman/workerman
```
二、创建自定义 artisan 命令来启动 workerman 服务

由于 laravel 不能直接在根目录下执行 php 命令，所以需要创建 artisan  命令用于后面 workerman 服务的开启。

1，生成 WorkermanCommand 文件

```php
php artisan make:command WorkermanCommand
```
执行以上命令行会在 app/Console/Commands/ 目录下生成 WorkermanCommand.php 文件。

```php
<?php
    namespace App\Console\Commands;
    use Workerman\Worker;
    use Illuminate\Console\Command;
    class WorkermanCommand extends Command { private $server;
        // -d 是否以debug方式运行
        protected $signature = 'workerman {action} {-d?}';
        protected $description = 'Start a Workerman server.';
        public function __construct() { parent::__construct();
        } /** * Execute the console command. * * @return mixed */
        public function handle() { global $argv;
            $arg = $this->argument('action');
            $argv[1] = $argv[2];
            $argv[2] = isset($argv[3]) ? "-{$argv[3]}" : '';

            switch ($arg) { case 'start':
                    $this->start();
                    break;
                case 'stop':
                    $this->stop();
                    break;
                case 'restart':
                    $this->restart();
                    break;
                case 'reload':
                    $this->reload();
                    break;
            } } private function start() { // 创建一个Worker监听20002端口，不使用任何应用层协议
            $this->server = new Worker("tcp://0.0.0.0:8383");
            // 启动4个进程对外提供服务
            $this->server->count = 4;
            $handler = \App::make('handlers\WorkermanHandler');
             // 连接时回调
            $this->server->onConnect = [$handler, 'onConnect'];
             // 收到客户端信息时回调
            $this->server->onMessage = [$handler, 'onMessage'];
             // 进程启动后的回调
            $this->server->onWorkerStart = [$handler, 'onWorkerStart'];
             // 断开时触发的回调
            $this->server->onClose = [$handler, 'onClose'];
             // 运行worker
            Worker::runAll();
        } private function stop() { $worker = new Worker('tcp://0.0.0.0:8383');
            // 设置此实例收到reload信号后是否reload重启
            $worker->reloadable = false;
            $worker->onWorkerStop = function($worker) { echo "Worker reload...\n";
            };
            // 运行worker
            Worker::runAll();
        } private function restart() { $worker = new Worker('tcp://0.0.0.0:8383');
            // 设置此实例收到reload信号后是否reload重启
            $worker->reloadable = true;
            $worker->onWorkerStart = function($worker) { echo "Worker restart...\n";
            };
            // 运行worker
            Worker::runAll();
        } private function reload() { $worker = new Worker('tcp://0.0.0.0:8383');
            // 设置此实例收到reload信号后是否reload重启
            $worker->reloadable = false;
            $worker->onWorkerStart = function($worker) { echo "Worker reload...\n";
            };
            // 运行worker
            Worker::runAll();
        } }
```
这里使用了 PHP 类方法的回调。（PHP几种回调写法）
这里我们创建了一个自定义命令 workerman [action]   [-d] ，通过此命令即可开启 workerman 服务。
在这个自定义命令还引用了其他的类文件，如：
```php
$handler = \App::make('handlers\WorkermanHandler');
```
所以，需要创建一个 WorkermanHandler.php 的文件来处理对应的操作。


还需要在app/Console/Commands/Kernel.php 中增加
```php
protected $commands = [
    //
    \App\Console\Commands\WorkermanCommand::class

];
```
2，创建 WorkermanHandler.php
创建文件 app/handlers/WorkermanHandler.php
```php
<?php
    namespace handlers;
    use Workerman\Lib\Timer;

    // 心跳间隔10秒
    define('HEARTBEAT_TIME',50);

    class WorkermanHandler { // 处理客户端连接
        public function onConnect($connection) { echo "链接成功";
        } // 处理客户端消息
        public function onMessage($connection, $data) {                //当上来数据获取最后上传数据的时间              $connection->lastMessageTime = time();

            // 向客户端发送hello $data
           $connection->send('Hello, your send message is: ' . $data);
        } // 处理客户端断开
        public function onClose($connection) { echo "connection closed from ip {$connection->getRemoteIp()}\n";
        } public function onWorkerStart($worker) { Timer::add(1, function () use ($worker) { $time_now = time();
                foreach ($worker->connections as $connection) { // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                    if (empty($connection->lastMessageTime)) { $connection->lastMessageTime = $time_now;
                        continue;
                    } // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                    if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) { echo "Client ip {$connection->getRemoteIp()} timeout!!!\n"; $connection->close();
                    } } });
        } }
```
3，修改 composer.json 文件，让 app/handles 文件夹下的类文件自动加载。
```php
"autoload": {
    "classmap": [
        ...
        "app/handles"
    ],
    ...
},
```

至此。workman的命令定义已经完成。

使用：
```php
php artisan workerman start d

```

如果看到以下内容，说明 workerman 服务启动正常：

```php
Workerman[artisan] start in DEBUG mode
----------------------- WORKERMAN -----------------------------
Workerman version:3.5.4          PHP version:7.1.4
------------------------ WORKERS -------------------------------
user          worker        listen                   processes status
root          none          tcp://0.0.0.0:8383   1         [OK] 
----------------------------------------------------------------
Start success.
```

