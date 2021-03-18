PHP 换行符 PHP_EOL

PHP 中换行可以用 PHP_EOL 来替代，以提高代码的源代码级可移植性：
unix系列用 \n
windows系列用 \r\n
mac用 \r

```php
<?php
echo PHP_EOL;
//windows平台相当于    echo "\r\n";
//unix\linux平台相当于    echo "\n";
//mac平台相当于    echo "\r";

```