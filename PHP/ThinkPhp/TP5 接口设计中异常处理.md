PHP提供 Exception 类来处理异常
```php
new Exception('错误信息(默认为空)','错误代码(默认0)','异常链中前一个异常')
```
然后可以通过
```php
e -> getMessage() 获取异常信息
e -> getCode() 获取异常错误码
```
处理异常
```php
try {
            //可能抛出异常代码
            throw new Exception("Error Processing Request", 1);    
        } catch (Exception $e) {
            // 1. 记录日志
            // 2. 处理异常，程序继续进行 / 继续向上抛出异常 / 终止程序，打印异常错误
        }
```
在ThinkPHP中，框架自带异常处理类，返回错误信息以HTML页面形式展示，如果程序出现错误开发人员没有主动捕捉异常，则会被框架捕捉，然后抛出HTML

当在接口设计中时，由于无法得知客户端类型，所以HTML的形式客户端可能无法解析，此时便需要重写异常类，以json的形式返回错误信息给客户端

异常分类：

自定义异常：通常是由客户端传递参数错误导致，此类异常不需要记录日志，但需要返回错误原因

服务器异常：代码错误导致异常，此类异常需要记录日志，但不需要返回错误原因
服务器异常错误一般由PHP或者框架抛出，自定义异常需要手动捕捉，然后抛出

实现：

在Application/common目录下新建 exception 目录，此目录为异常类库目录

Application/common/exception/ExceptionHandler （重写后的异常处理类

```php
<?php
namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\facade\Request;
use think\Log;

class ExceptionHandler extends Handle {

    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e) {
        if ($e instanceof BaseException) {
            //如果是自定义异常，则控制http状态码，不需要记录日志
            //因为这些通常是因为客户端传递参数错误或者是用户请求造成的异常
            //不应当记录日志

            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            // 如果是服务器未处理的异常，将http状态码设置为500，并记录日志
            if (config('app_debug')) {
                // 调试状态下需要显示TP默认的异常页面，因为TP的默认页面
                // 很容易看出问题
                return parent::render($e);
            }

            $this->code = 500;
            $this->msg = 'sorry，we make a mistake. (^o^)Y';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request = $request->url(),
        ];
        return json($result, $this->code);
    }

    /*
             * 将异常写入日志
    */
    private function recordErrorLog(Exception $e) {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(), 'error');
    }

}
```
这个类会判断异常来源，并作出相应处理

创建处理类后，需要修改对应配置文件，让这个类成为框架默认异常处理类

在application/config/app.php
```php
 // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle' => '\app\common\exception\ExceptionHandler',
```
Application/common/exception/BaseException （自定义异常类基类，基础PHP自带异常类Exception）
```php
<?php
namespace app\common\exception;
use think\Exception;

/**
 * Class BaseException
 * 自定义异常类的基类
 */
class BaseException extends Exception {
    public $code = 400;
    public $msg = 'invalid parameters';
    public $errorCode = 999;

    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($params = []) {
        if (!is_array($params)) {
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}
```
自定义异常类

Application/common/exception/UserException （自定义异常，这里举例User模块的异常）
```php
<?php

namespace app\common\exception;

class UserException extends BaseException {
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}
```
抛出自定义异常
```php
try {
            //todo...
            throw new \app\common\exception\UserException();

        } catch (Exception $e) {

        }
```
此时异常展示不再是TP自带的HTML页，而是
```php
{
    "msg": "用户不存在",
    "error_code": 60000,
    "request_url": "/wx_shop/public/index.php/admin/banner/list"
}
```

























