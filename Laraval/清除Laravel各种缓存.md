# 清除应用程序缓存

运行以下命令以清除Laravel应用程序的应用程序缓存

```bash
php artisan cache:clear
```

# 清除路由缓存

要清除Laravel应用程序的路由缓存，请从shell执行以下命令。

```bash
php artisan route:cache
```

# 清除配置缓存

您可以使用config：cache清除Laravel应用程序的配置缓存。

```bash
php artisan config:cache
```

# 清除已编译的视图文件

此外，还可能需要清除Laravel应用程序的已编译视图文件。要清除已编译的视图文件，则从终端运行以下命令。

```bash
php artisan view:clear
```

# 清除Laravel中的缓存（浏览器）

大多数共享主机提供程序不提供对系统的SSH访问。在这种情况下，可以通过在浏览器中调用URL来清除Laravel缓存。只需将以下代码放在Laravel应用程序的routes / web.php文件中即可。然后在浏览器中访问此URL以清除Laravel应用程序的缓存。

```bash
Route::get('/clear-cache', function() {

    Artisan::call('cache:clear');

    return "Cache is cleared";

});
```
