# PHP实现多继承的效果(tarits)

具体看官方的文档
[传送门](http://php.net/manual/zh/language.oop5.traits.php)

多继承里一个类可以同时继承多个父类，组合多个父类的功能 C++ 里就是使用这种模型来增强集成的灵活性的，但多重继承过于灵活，并且会带来“菱形继承”，故使用起来有不少困难，模型变的复杂起来，现在大多数语言都放弃了多重继承这一模型。 

 但有的场合想用多继承，但PHP又没多继承，于是就发明了这样的一个东西。 
Traits可以理解为一组能被不同的类都能调用到的方法集合，但Traits不是类！不能被实例化。先来例子看下语法

```
<?php
trait myTrait{
    function traitMethod1(){}
    function traitMethod2(){}

}

//然后是调用这个traits,语法为：
class myClass{
    use myTrait;
}

//这样就可以通过use myTraits，调用Traits中的方法了，比如：
$obj = new myClass();
$obj-> traitMethod1 ();
$obj-> traitMethod2 (); 
>
```

## 优先级

从基类继承的成员会被 trait 插入的成员所覆盖。优先顺序是来自当前类的成员覆盖了 trait 的方法，而 trait 则覆盖了被继承的方法。

## 多个 trait

通过逗号分隔，在 use 声明列出多个 trait，可以都插入到一个类中。

## 冲突的解决

如果两个 trait 都插入了一个同名的方法，如果没有明确解决冲突将会产生一个致命错误。

为了解决多个 trait 在同一个类中的命名冲突，需要使用 insteadof 操作符来明确指定使用冲突方法中的哪一个。

以上方式仅允许排除掉其它方法，as 操作符可以 为某个方法引入别名。 注意，as 操作符不会对方法进行重命名，也不会影响其方法。

```
trait A {
    public function smallTalk() {
        echo 'a';
    }
    public function bigTalk() {
        echo 'A';
    }
}

trait B {
    public function smallTalk() {
        echo 'b';
    }
    public function bigTalk() {
        echo 'B';
    }
}

class Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
    }
}

class Aliased_Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        B::bigTalk as talk;
    }
}
```












