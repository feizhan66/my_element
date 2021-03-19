队列使用： 
http://laravelacademy.org/post/3252.html 
http://laravelacademy.org/post/6922.html

运行队列监听器 
在浏览器中访问http://laravel.app:8000/mail/sendReminderEmail/1，此时任务被推送到Redis队列中，我们还需要在命令行中运行Artisan命令执行队列中的任务。Laravel为此提供了三种Artisan命令：

queue:work 默认只执行一次队列请求, 当请求执行完成后就终止；

queue:listen 监听队列请求，只要运行着，就能一直接受请求，除非手动终止；
 
queue:work –-daemon 同 listen 一样， 只要运行着，就能一直接受请求，不一样的地方是在这个运行模式下，当新的请求到来的时候，不重新加载整个框架，而是直接 fire 动作。能看出来， queue:work –daemon 是最高级的，一般推荐使用这个来处理队列监听。 
注：使用 queue:work –daemon ，当更新代码的时候，需要停止，然后重新启动，这样才能把修改的代码应用上。

遇到的坑
使用queue:listen 不执行Job中 Hande方法。解决办法：使用 queue:work来解决

laravel dispatch不异步执行，同步执行。修改配置文件 QUEUE_DRIVER=sync为redis
