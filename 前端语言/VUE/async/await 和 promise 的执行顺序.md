

```vue
async function
    async1() {
            console.log( 'async1 start')
    await async2()
            console.log( 'async1 end')
}

async function
    async2() {
    console.log( 'async2')
}

console.log( 'script start')

setTimeout( 
    function() {
        console.log( 'setTimeout')
    }, 
0
 )

async1();

new Promise( 
    function( resolve ) {
        console.log( 'promise1')
        resolve();
    } ).then( 
    function() {
        console.log( 
'promise2'
 )
    } )

    console.log( 
'script end'
 )
```

```vue
script start
async1 start
async2
promise1
script end
promise2
async1 end
setTimeout
```

1、async 做一件什么事情？

一句话概括： 带 async 关键字的函数，它使得你的函数的返回值必定是 promise 对象。

也就是，如果async关键字函数返回的不是promise，会自动用 Promise.resolve() 包装。

如果async关键字函数显式地返回promise，那就以你返回的promise为准。

这是一个简单的例子，可以看到 async 关键字函数和普通函数的返回值的区别：

```vue
async function
 fn1(){
    return 123
}

function fn2(){
    return 123
}

console.log(fn1())
console.log(fn2())
```
```vue
Promise{<resolved>: 123}

123
```
所以你看，async 函数也没啥了不起的，以后看到带有 async 关键字的函数也不用慌张，你就想它无非就是把return值包装了一下，其他就跟普通函数一样。

关于async关键字还有那些要注意的？

在语义上要理解，async表示函数内部有异步操作
另外注意，一般 await 关键字要在 async 关键字函数的内部，await 写在外面会报错。

2、await 在等什么？

一句话概括： await等的是右侧「表达式」的结果。

也就是说，右侧如果是函数，那么函数的return值就是「表达式的结果」。

右侧如果是一个 'hello' 或者什么值，那表达式的结果就是 'hello'。

```vue
async 
function async1() {
    console.log( 
'async1 start'
 )
    await async2()
    console.log( 
'async1 end'
 )
}
async function
 async2() {
    console.log( 
'async2'
 )
}
async1()
console.log( 
'script start'
 )
```
这里注意一点，可能大家都知道await会让出线程，阻塞后面的代码，那么上面例子中， async2 和 script start 谁先打印呢？

是从左向右执行，一旦碰到await直接跳出，阻塞 async2() 的执行？

还是从右向左，先执行async2后，发现有await关键字，于是让出线程，阻塞代码呢？

实践的结论是，从右向左的。先打印async2，后打印的 script start。

之所以提一嘴，是因为我经常看到这样的说法，「一旦遇到await就立刻让出线程，阻塞后面的代码」。

这样的说法，会让我误以为，await后面那个函数， async2()也直接被阻塞呢。

3、await 等到之后，做了一件什么事情？

那么右侧表达式的结果，就是await要等的东西。

等到之后，对于await来说，分2个情况：

不是promise对象
是promise对象

如果不是 promise , await会阻塞后面的代码，先执行async外面的同步代码，同步代码执行完，再回到async内部，把这个非promise的东西，作为 await表达式的结果。
如果它等到的是一个 promise 对象，await 也会暂停async后面的代码，先执行async外面的同步代码，等着 Promise 对象 fulfilled，然后把 resolve 的参数作为 await 表达式的运算结果。

# 第2部分：画图一步步看清宏任务、微任务的执行过程

我们以开篇的经典面试题为例，分析这个例子中的宏任务和微任务。

也就是「宏任务」、「微任务」都是队列。

一段代码执行时，会先执行宏任务中的同步代码：

如果执行中遇到 setTimeout 之类宏任务，那么就把这个 setTimeout 内部的函数推入「宏任务的队列」中，下一轮宏任务执行时调用。
如果执行中遇到 promise.then() 之类的微任务，就会推入到「当前宏任务的微任务队列」中，在本轮宏任务的同步代码执行都完成后，依次执行所有的微任务1、2、3。

下面就以面试题为例子，分析这段代码的执行顺序。

每次宏任务和微任务发生变化，我都会画一个图来表示他们的变化。

直接打印同步代码 console.log('script start')

首先是2个函数声明，虽然有async关键字，但不是调用我们就不看。然后首先是打印同步代码 console.log('script start')。

将setTimeout放入宏任务队列

默认 <script></script> 所包裹的代码，其实可以理解为是第一个宏任务，所以这里是宏任务2

调用async1，打印 同步代码 console.log('async1 start')

我们说过看到带有async关键字的函数，不用害怕，它的仅仅是把return值包装成了promise，其他并没有什么不同的地方。所以就很普通的打印 console.log('async1 start')。

分析一下 awaitasync2()

前文提过await，它先计算出右侧的结果，然后看到await后，中断async函数：

先得到await右侧表达式的结果。执行 async2()，打印同步代码 console.log('async2')，并且return Promise.resolve(undefined)。
await后，中断async函数，先执行async外的同步代码。

目前就直接打印 console.log('async2')

被阻塞后，要执行async之外的代码。

执行 newPromise()

Promise构造函数是直接调用的同步代码，所以 console.log('promise1')：

代码运行到 promise.then()

代码运行到promise.then()，发现这个是微任务，所以暂时不打印，只是推入当前宏任务的微任务队列中。

注意：这里只是把promise2推入微任务队列，并没有执行。微任务会在当前宏任务的同步代码执行完毕，才会依次执行：























