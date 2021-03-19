php判断请求类型，可以通过 $_SERVER 相关的参数来实现，

这个很在对某些请求代码复用里面很常用。具体代码如下：、

```angular2html

/**
 *@todo: 判断是否为post
 */  
if(!function_exists('is_post')){
	function is_post()
	{
	   return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='POST';	
	}
}

/**
 *@todo: 判断是否为get
 */ 
if(!function_exists('is_get')){
	function is_get()
	{
	   return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='GET'; 	
	}
}

/**
 *@todo: 判断是否为ajax
 */ 
if(!function_exists('is_ajax')){
	function is_ajax()
	{
	    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'])=='XMLHTTPREQUEST';	
	}
}

/**
 *@todo: 判断是否为命令行模式
 */ 
if(!function_exists('is_cli')){
	function is_cli()
	{
            return (PHP_SAPI === 'cli' OR defined('STDIN'));  
	}
}


```