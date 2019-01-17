```php
<?php
use Workerman\Worker;
require_once './Workerman/Autoloader.php';

// 设置监听协议和监听接口。创建一个Worker监听2346端口，使用websocket协议通讯
$ws_worker = new Worker("websocket://0.0.0.0:2346");

//设置当前Worker实例的名称，方便运行status命令时识别进程。不设置时默认为none。
$ws_worker->name="MyWebsocketWorker";

//设置当前Worker实例所使用的传输层协议，目前只支持3种(tcp、udp、ssl)。不设置默认为tcp。
$ws_worker->transport = 'tcp';

// 启动3个进程对外提供服务
$ws_worker->count = 3;

// 此属性为全局静态属性，表示是否以daemon(守护进程)方式运行。如果启动命令使用了 -d参数，则该属性会自动设置为true。也可以代码中手动设置。
$ws_worker->daemonize = true;

// 设置Worker子进程启动时的回调函数，每个子进程启动时都会执行
$ws_worker->onWorkerStart = function ($ws_worker){
    // 只在id编号为0的进程上设置定时器，其它1、2、3号进程不设置定时器
        if($ws_worker->id === 0)
        {
            Timer::add(1, function(){
                echo "4个worker进程，只在0号进程设置定时器\n";
            });
        }
};

// $connection 此属性中存储了当前进程的所有的客户端连接对象，其中id为connection的id编号 在广播时或者根据连接id获得连接对象非常有用
// 如果得知connection的编号为$id，可以很方便的通过$worker->connections[$id]获得对应的connection对象，从而操作对应的socket连接，例如通过$worker->connections[$id]->send('...') 发送数据。

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data) use($ws_worker)
{
    // $connection 连接对象，即TcpConnection实例，用于操作客户端连接，如发送数据，关闭连接等
    
    // $data 客户端连接上发来的数据，如果Worker指定了协议，则$data是对应协议decode（解码）了的数据
    
    
    // 长连接（一直连着）
    // 向客户端发送hello $data
    $connection->send('hello ' . $data);
    // 短连接（连上就关闭）
//    $connection->close("HTTP/1.1 200 OK\r\nServer: workerman\1.1.4\r\n\r\nhello");
    
    // 连接ID
    //$connection->id
    // 进程ID
    // $ws_worker->id // 0至$ws_worker->count-1
};

// onWorkerReload 设置Worker收到reload信号后执行的回调。

// onConnect 当客户端与Workerman建立连接时(TCP三次握手完成后)触发的回调函数。每个连接只会触发一次onConnect回调。

// onMessage 当客户端通过连接发来数据时(Workerman收到数据时)触发的回调函数

// onClose 当客户端连接与Workerman断开时触发的回调函数。不管连接是如何断开的，只要断开就会触发onClose。每个连接只会触发一次onClose。

// onBufferFull 每个连接都有一个单独的应用层发送缓冲区，如果客户端接收速度小于服务端发送速度，数据会在应用层缓冲区暂存，如果缓冲区满则会触发onBufferFull回调。

// onBufferDrain 每个连接都有一个单独的应用层发送缓冲区，缓冲区大小由TcpConnection::$maxSendBufferSize决定，默认值为1MB，可以手动设置更改大小，更改后会对所有连接生效。

// onError 当客户端的连接上发生错误时触发。

// 运行
Worker::runAll();

// runAll 运行所有Worker实例。 Worker::runAll()执行后将永久阻塞，也就是说位于Worker::runAll()后面的代码将不会被执行。所有Worker实例化应该都在Worker::runAll()前进行。

// stopAll 停止当前进程（子进程）的所有Worker实例并退出。

// listen 用于实例化Worker后执行监听。

```

以debug（调试）方式启动
php start.php start

启动命令（-d是以守护进程启动）
php start.php start -d

停止
php start.php stop

查看状态
php start.php status

重启
php start.php restart

平滑重启
php start.php reload

查看连接状态
php start.php connections