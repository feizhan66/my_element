## all() 方法返回集合表示的底层数组

```angular2html
collect([1,2,3])->all()

// [1,2,3]
```

## avg() 方法返回给定值的 平均值
```angular2html
$average = collect([['foo'=>10],['foo'=>10],['foo'=>20],['foo'=>40]])->avg('foo');
// 20

$average = collect([1,1,2,4])->avg();
// 2
```

## chunk() 将集合拆成多个指定大小的集合

```angular2html
$collection = collect([1,2,3,4,5,6,7]);
$chunks = $collection->chunk(4);
$chunks->toArray();
// [[1,2,3,4],[5,6,7]]

// 作用：例如适合栅格布局
```

## collapse() 将多个数组的集合合并成一个数组的集合
```angular2html
$collection = collect([[1,2,3],[4,5,6],[7,8,9]]);
$collapsed = $collection->collapse()
$collapsed->all();
// [1,2,3,4,5,6,7,8,9]
```

## combine() 将一个集合的值作为【键】，再将另一个数组或者集合的值作为【值】合并成一个集合
```angular2html
$collection = collect(['name','age']);
$combined = $collection->combine(['George',20]);
$combined->all();
// ['name'=>'George','age'=>29]
```
## concat() 将给定的 array 或集合值附加到集合的末尾
```angular2html
$collection = collect(['John Doe']);
$concatenated = $collection->concat(['Jane Doe'])->concat(['name'=>'Johnny Doe']);
// ['John Doe','Jane Doe','Johnny Doe']
```

## contains() 判断集合是否包含给定的项目
```angular2html
$collection = collect(['name'=>'Desk','price'=>100]);

$collection->contains('Desk');
// true
$collection->contains('New York');
// false
```
你也可以用 contains 方法匹配一对键/值，即判断给定的配对是否存在于集合中：
```angular2html
$collection = collect([
    ['product'=>'Desk','price'=>200],
    ['product'=>'Chair','price'=>100]
]);
$collection->contains('product','Bookcase');
// false 

```
最后，你也可以传递一个回调到 contains 方法来执行自己的真实测试：
```angular2html
$collection = collect([1, 2, 3, 4, 5]);

$collection->contains(function ($value, $key) {
    return $value > 5;
});

// false
```

## count() 返回该集合内的项目总数
```angular2html
$collection = collect([1,2,3,4]);
$collection->count();
// 4
```
## crossJoin() 给定数组或集合之间交叉集合的值，返回具有所有可能排列的笛卡尔乘积：
```angular2html
$collection = collect([1,2]);
$matrix = $collection->crossJoin(['a','b']);
$matrix->all();
/*
[
    [1,'a'],
    [1,'b'],
    [2,'a'],
    [2,'b'],
]
*/

$collection = collect([1,2]);
$matrix = $collection->crossJoin(['a','b'],['I','II']);
$matrix->all();
/*
    [
        [1, 'a', 'I'],
        [1, 'a', 'II'],
        [1, 'b', 'I'],
        [1, 'b', 'II'],
        [2, 'a', 'I'],
        [2, 'a', 'II'],
        [2, 'b', 'I'],
        [2, 'b', 'II'],
    ]
*/
```

## dd() 转储集合的项目并结束脚本的执行：
```angular2html
$collection = collect(['John Doe', 'Jane Doe']);

$collection->dd();

/*
    Collection {
        #items: array:2 [
            0 => "John Doe"
            1 => "Jane Doe"
        ]
    }
*/
```
如果您不想停止执行脚本，请改用 dump 方法。

## diff() 方法将集合与其它集合或纯 PHP 数组进行值的比较，然后返回原集合中存在而给定集合中不存在的值：
```angular2html
$collection = collect([1, 2, 3, 4, 5]);

$diff = $collection->diff([2, 4, 6, 8]);

$diff->all();

// [1, 3, 5]
```
## diffAssoc()  该方法与另外一个集合或基于它的键和值的 PHP 数组进行比较。这个方法会返回原集合不存在于给定集合中的键值对 ：
```angular2html
$collection = collect([
    'color' => 'orange',
    'type' => 'fruit',
    'remain' => 6
]);

$diff = $collection->diffAssoc([
    'color' => 'yellow',
    'type' => 'fruit',
    'remain' => 3,
    'used' => 6
]);

$diff->all();

// ['color' => 'orange', 'remain' => 6]
```
## diffKeys() 方法与另外一个集合或 PHP 数组的「键」进行比较，然后返回原集合中存在而给定的集合中不存在「键」所对应的键值对：
```angular2html
$collection = collect([
    'one' => 10,
    'two' => 20,
    'three' => 30,
    'four' => 40,
    'five' => 50,
]);

$diff = $collection->diffKeys([
    'two' => 2,
    'four' => 4,
    'six' => 6,
    'eight' => 8,
]);

$diff->all();

// ['one' => 10, 'three' => 30, 'five' => 50]
```

## dump 方法将打印集合的每一项：
```angular2html
$collection = collect(['John Doe', 'Jane Doe']);

$collection->dump();

/*
    Collection {
        #items: array:2 [
            0 => "John Doe"
            1 => "Jane Doe"
        ]
    }
*/
```
如果你想打印集合后并停止执行脚本，请改用 dd 方法代替。

## each() 方法将迭代集合中的内容并将其传递到回调函数中：
```angular2html
$collection = $collection->each(function ($item, $key) {
    //
});
```
如果你想要中断对内容的迭代，那就从回调中返回 false：
```angular2html
$collection = $collection->each(function ($item, $key) {
    if (/* some condition */) {
        return false;
    }
});
```
## eachSpread() 方法迭代集合的项目，将每个嵌套项目值传递给给定的回调：
```angular2html
$collection = collect([['John Doe', 35], ['Jane Doe', 33]]);

$collection->eachSpread(function ($name, $age) {
    //
});
```
您可以通过从回调中返回 false 来停止迭代项目：
```angular2html
$collection->eachSpread(function ($name, $age) {
    return false;
});
```
## every() 方法可用于验证集合中每一个元素都通过给定的真实测试：
```angular2html
collect([1, 2, 3, 4])->every(function ($value, $key) {
    return $value > 2;
});

// false
```
## except 方法返回集合中除了指定键以外的所有项目
```angular2html
$collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);

$filtered = $collection->except(['price', 'discount']);

$filtered->all();

// ['product_id' => 1]
```
与 except 相反的方法，请查看 only 方法。

## filter() 方法使用给定的回调函数过滤集合的内容，只留下那些通过给定真实测试的内容：
```angular2html
$collection = collect([1, 2, 3, 4]);

$filtered = $collection->filter(function ($value, $key) {
    return $value > 2;
});

$filtered->all();

// [3, 4]
```
如果没有提供回调函数，集合中所有返回 false 的元素都会被移除：
```angular2html
$collection = collect([1, 2, 3, null, false, '', 0, []]);

$collection->filter()->all();

// [1, 2, 3]
```
与 filter 相反的方法，可以查看 reject 方法。

## first() 方法返回集合中通过给定真实测试的第一个元素：
```angular2html
collect([1, 2, 3, 4])->first(function ($value, $key) {
    return $value > 2;
});

// 3
```
你也可以不传入参数使用 first 方法以获取集合中第一个元素。如果集合是空的，则会返回 null：
```angular2html
collect([1, 2, 3, 4])->first();

// 1
```

## firstWhere() 方法用给定的键/值对返回集合中的第一个元素：
```angular2html
$collection = collect([
    ['name' => 'Regena', 'age' => 12],
    ['name' => 'Linda', 'age' => 14],
    ['name' => 'Diego', 'age' => 23],
    ['name' => 'Linda', 'age' => 84],
]);

$collection->firstWhere('name', 'Linda');

// ['name' => 'Linda', 'age' => 14]
```
你也可以用操作符调用 firstWhere 方法：
```angular2html
$collection->firstWhere('age', '>=', 18);

// ['name' => 'Diego', 'age' => 23]
```
## flatMap() 方法遍历集合并将其中的每个值传递到给定的回调。可以通过回调修改每个值的内容再返回出来，从而形成一个新的被修改过内容的集合。然后你就可以用 all() 打印修改后的数组：
```angular2html
$collection = collect([
    ['name' => 'Sally'],
    ['school' => 'Arkansas'],
    ['age' => 28]
]);

$flattened = $collection->flatMap(function ($values) {
    return array_map('strtoupper', $values);
});

$flattened->all();

// ['name' => 'SALLY', 'school' => 'ARKANSAS', 'age' => '28'];
```
## flatten() 方法将多维集合转为一维的
```angular2html
$collection = collect(['name' => 'taylor', 'languages' => ['php', 'javascript']]);

$flattened = $collection->flatten();

$flattened->all();

// ['taylor', 'php', 'javascript'];
```
你还可以选择性地传入「深度」参数：
```angular2html
$collection = collect([
    'Apple' => [
        ['name' => 'iPhone 6S', 'brand' => 'Apple'],
    ],
    'Samsung' => [
        ['name' => 'Galaxy S7', 'brand' => 'Samsung']
    ],
]);

$products = $collection->flatten(1);

$products->values()->all();

/*
    [
        ['name' => 'iPhone 6S', 'brand' => 'Apple'],
        ['name' => 'Galaxy S7', 'brand' => 'Samsung'],
    ]
*/
```




