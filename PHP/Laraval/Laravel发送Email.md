# 发送 Email

Finish!

## 文档链接
https://laravel-china.org/docs/laravel/5.4/mail/1253

## 安装插件
```angular2html
composer require guzzlehttp/guzzle
```

## 创建邮件发送类 app/Mail/OrderEmailSend
```angular2html
php artisan make:mail OrderEmailSend
```

## 配置账号 在 .env -- config/mail.php
```angular2html
MAIL_DRIVER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=587
MAIL_USERNAME=995116474@qq.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=995116474@qq.com
MAIL_FROM_NAME=新云
```
## 调用发送
```angular2html
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;

class EmailController extends Controller
{
    public function index(){
        Mail::to("287852692@qq.com")->send(new OrderShipped());
    }
}
```




















