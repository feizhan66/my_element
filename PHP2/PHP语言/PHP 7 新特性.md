# PHP 7 新特性

## 标量类型声明

- PHP 7 中的函数的形参类型声明可以是标量了。在 PHP 5 中只能是类名、接口、array 或者 callable (PHP 5.4，即可以是函数，包括匿名函数)，现在也可以使用 string、int、float和 bool 了。

```php

// 强制模式
function sumOfInts(int ...$ints)
{
    return array_sum($ints);
}

var_dump(sumOfInts(2, '3', 4.1));

以上实例会输出：

int(9)

```
- 需要注意的是上文提到的严格模式的问题在这里同样适用：强制模式（默认，既强制类型转换）下还是会对不符合预期的参数进行强制类型转换，严格模式下则触发 TypeError 的致命错误。


## 返回值类型声明

- PHP 7 增加了对返回类型声明的支持。 类似于参数类型声明，返回类型声明指明了函数返回值的类型。可用的类型与参数声明中可用的类型相同。

```php

<?php

function arraysSum(array ...$arrays): array
{
    return array_map(function(array $array): int {
        return array_sum($array);
    }, $arrays);
}

print_r(arraysSum([1,2,3], [4,5,6], [7,8,9]));

以上实例会输出：

Array
(
    [0] => 6
    [1] => 15
    [2] => 24
)

```

## NULL 合并运算符

- 由于日常使用中存在大量同时使用三元表达式和 isset()的情况，NULL 合并运算符使得变量存在且值不为NULL， 它就会返回自身的值，否则返回它的第二个操作数。

```php

<?php
// 如果 $_GET['user'] 不存在返回 'nobody'，否则返回 $_GET['user'] 的值
$username = $_GET['user'] ?? 'nobody';
// 类似的三元运算符
$username = isset($_GET['user']) ? $_GET['user'] : 'nobody';
?>

```

## 太空船操作符（组合比较符）

- 太空船操作符用于比较两个表达式。当$a大于、等于或小于$b时它分别返回-1、0或1。 

```php

<?php
// 整型
echo 1 <=> 1; // 0
echo 1 <=> 2; // -1
echo 2 <=> 1; // 1

// 浮点型
echo 1.5 <=> 1.5; // 0
echo 1.5 <=> 2.5; // -1
echo 2.5 <=> 1.5; // 1
 
// 字符串
echo "a" <=> "a"; // 0
echo "a" <=> "b"; // -1
echo "b" <=> "a"; // 1
?>

```

## 通过 define() 定义常量数组

```php

<?php
define('ANIMALS', [
    'dog',
    'cat',
    'bird'
]);

echo ANIMALS[1]; // 输出 "cat"
?>

```

## 匿名类
- 现在支持通过new class 来实例化一个匿名类，实例如下：

```php

<?php
interface Logger {
    public function log(string $msg);
}

class Application {
    private $logger;

    public function getLogger(): Logger {
         return $this->logger;
    }

    public function setLogger(Logger $logger) {
         $this->logger = $logger;
    }
}

$app = new Application;
$app->setLogger(new class implements Logger {
    public function log(string $msg) {
        echo $msg;
    }
});

var_dump($app->getLogger());
?>

以上实例会输出：

object(class@anonymous)#2 (0) {
}

```


## Unicode codepoint 转译语法 
- 这接受一个以16进制形式的 Unicode codepoint，并打印出一个双引号或heredoc包围的 UTF-8 编码格式的字符串。 可以接受任何有效的 codepoint，并且开头的 0 是可以省略的。

```php

echo "\u{aa}";
echo "\u{0000aa}";
echo "\u{9999}";

以上实例会输出：

ª
ª (same as before but with optional leading 0's)
香

```

## Closure::call()
- Closure::call() 现在有着更好的性能，简短干练的暂时绑定一个方法到对象上闭包并调用它。


```php

<?php
class A {private $x = 1;}

// Pre PHP 7 代码
$getXCB = function() {return $this->x;};
$getX = $getXCB->bindTo(new A, 'A'); // intermediate closure
echo $getX();

// PHP 7+ 代码
$getX = function() {return $this->x;};
echo $getX->call(new A);

以上实例会输出：
1
1

```

## 为unserialize()提供过滤
- 这个特性旨在提供更安全的方式解包不可靠的数据。它通过白名单的方式来防止潜在的代码注入。 

```php

<?php

// 转换对象为 __PHP_Incomplete_Class 对象
$data = unserialize($foo, ["allowed_classes" => false]);

// 转换对象为 __PHP_Incomplete_Class 对象，除了 MyClass 和 MyClass2
$data = unserialize($foo, ["allowed_classes" => ["MyClass", "MyClass2"]);

// 默认接受所有类
$data = unserialize($foo, ["allowed_classes" => true]);

```

## IntlChar
- 新增加的 IntlChar 类旨在暴露出更多的 ICU 功能。这个类自身定义了许多静态方法用于操作多字符集的 unicode 字符。

```php

<?php
printf('%x', IntlChar::CODEPOINT_MAX);
echo IntlChar::charName('@');
var_dump(IntlChar::ispunct('!'));

以上实例会输出：

10ffff
COMMERCIAL AT
bool(true)

```
- 若要使用此类，请先安装Intl扩展 

## 预期
- 预期是向后兼用并增强之前的 assert() 的方法。 它使得在生产环境中启用断言为零成本，并且提供当断言失败时抛出特定异常的能力。

```php

<?php
ini_set('assert.exception', 1);

class CustomError extends AssertionError {}

assert(false, new CustomError('Some error message'));
?>

以上实例会输出：

Fatal error: Uncaught CustomError: Some error message

```

## use 加强
- 从同一 namespace 导入的类、函数和常量现在可以通过单个 use 语句 一次性导入了。

```php

<?php

//  PHP 7 之前版本用法
use some\namespace\ClassA;
use some\namespace\ClassB;
use some\namespace\ClassC as C;

use function some\namespace\fn_a;
use function some\namespace\fn_b;
use function some\namespace\fn_c;

use const some\namespace\ConstA;
use const some\namespace\ConstB;
use const some\namespace\ConstC;

// PHP 7+ 用法
use some\namespace\{ClassA, ClassB, ClassC as C};
use function some\namespace\{fn_a, fn_b, fn_c};
use const some\namespace\{ConstA, ConstB, ConstC};
?>

```

## Generator 加强
- 增强了Generator的功能，这个可以实现很多先进的特性

```php

<?php
<?php

function gen()
{
    yield 1;
    yield 2;

    yield from gen2();
}

function gen2()
{
    yield 3;
    yield 4;
}

foreach (gen() as $val)
{
    echo $val, PHP_EOL;
}

?>
以上实例会输出：

1
2
3
4

```

## 整除

- 新增了整除函数 intdiv(),使用实例：

```php

<?php
var_dump(intdiv(10, 3));
?>

以上实例会输出：
int(3)

```

[更多特性](http://www.runoob.com/php/php7-new-features.html)