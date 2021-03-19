### CLI模式

CLI模式其实就是命令行运行模式，英文全称Command-Line Interface（命令行接口）

直接运行php命令
```php
php -r "echo 'huang';"
```
运行PHP的文件
```php
php -f './demo.php'
```

```php

PS F:\project\my_element> php -h
Usage: php [options] [-f] <file> [--] [args...]
php [options] -r <code> [--] [args...]
php [options] [-B <begin_code>] -R <code> [-E <end_code>] [--] [args...]
php [options] [-B <begin_code>] -F <file> [-E <end_code>] [--] [args...]
php [options] -S <addr>:<port> [-t docroot] [router]
php [options] -- [args...]
php [options] -a

-a               Run as interactive shell【以交互shell模式运行】
-c <path>|<file> Look for php.ini file in this directory【指定php.ini文件所在的目录】
-n               No configuration (ini) files will be used【指定不适用php.ini文件】
-d foo[=bar]     Define INI entry foo with value 'bar'【定义一个ini实体，key为foo，value为bar】
-e               Generate extended information for debugger/profiler【为调试和分析生成扩展信息】
-f <file>        Parse and execute <file>.【解析和执行文件】
-h               This help【打印帮助信息】
-i               PHP information【显示php的基本信息】
-l               Syntax check only (lint)【进行语法检查lint】
-m               Show compiled in modules【显示编译到内核的模块】
-r <code>        Run PHP <code> without using script tags <?..?>【运行PHP代码】
-B <begin_code>  Run PHP <begin_code> before processing input lines【在处理输入前线执行PHP代码<begin_code>】
-R <code>        Run PHP <code> for every input line【对输入的每一行作为PHP代码运行code】
-F <file>        Parse and execute <file> for every input line【对输入的每一行解析和执行file】
-E <end_code>    Run PHP <end_code> after processing all input lines【在处理所有输入的行之后执行php代码<end_code>】
-H               Hide any passed arguments from external tools.【隐藏任何来自外部工具传递的参数】
-S <addr>:<port> Run with built-in web server.【运行内置的web服务器】
-t <docroot>     Specify document root <docroot> for built-in web server.【指定用于内置web服务器的文档根目录<docroot>】
-s               Output HTML syntax highlighted source.【输出HTML语法高亮的源码】
-v               Version number【输出php的版本号】
-w               Output source with stripped comments and whitespace.【输出去掉注释和空格的源码】
-z <file>        Load Zend extension <file>.【载入zend扩展文件】

args...          Arguments passed to script. Use -- args when first argument
starts with - or script is read from stdin【传递给要运行的脚本的参数。】

--ini            Show configuration file names【显示php的配置文件名】

--rf <name>      Show information about function <name>.【显示关于函数<name>的信息】
--rc <name>      Show information about class <name>.【显示关于类<name>的信息】
--re <name>      Show information about extension <name>.【显示关于扩展<name>的信息】
--rz <name>      Show information about Zend extension <name>.【显示关于zend扩展<name>的信息】
--ri <name>      Show configuration for extension <name>.【新鲜事扩展<name>的配置信息】
```