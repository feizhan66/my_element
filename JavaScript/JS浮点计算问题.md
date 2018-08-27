问题
用js进行浮点数计算，结果可能会“超出预期”，大部分计算结果还是对的，但是我们可不想在计算这么严谨的事情上还有意外的惊喜。比如：

0.3 + 0.6 = 0.8999999999999999
0.3 - 0.2 = 0.09999999999999998
0.3 * 1.5 = 0.44999999999999996
0.3 / 0.1 = 2.9999999999999996
看完这几个计算结果，如果你没用过js，你可能会有点崩溃。我只能说，这就是js的魅力所在。

分析
在这之前，你需要知道以下几点：

js中数字类型只有Number；
js的Number是IEEE 754标准的64-bits的双精度数值
网上有很多关于此问题的解释，由于计算机是用二进制来存储和处理数字，不能精确表示浮点数，而js中没有相应的封装类来处理浮点数运算，直接计算会导致运算精度丢失。其实高级语言（c#，java）也存在此问题，只不过它们自己内部做了处理，把这种精度差异给屏蔽掉了。有些小数转换为二进制位数是无穷的（有循环），但是64位中小数最多只有52位，因此对于位数超过的相当于被截取了，导致了精度的丢失。这个地址可以用来浮点数和IEEE 754标准的64-bits的互转（背后是二进制的转换），用这个我们来验证下0.3-0.2。

0.3转换后为0.299999999999999988897769753748
0.2转换后为0.200000000000000011102230246252
0.299999999999999988897769753748-0.200000000000000011102230246252=0.099999999999999977795539507496
这和js直接计算的结果0.09999999999999998想吻合。

分析下来，终于明白并不是js自身发育不良，只是没有及时补充营养，我们只能另想出路了。

解决方法
网上已经存在很多解决方法了，我这里也没有特别的方法，但是网上有很多方法只搞定了一半，仍然存在bug。大部分解决方法的思路是将浮点数计算转换为整数计算，整数计算当然是没有bug的啦。前面说网上部分方法只搞对了一半，对的一半是乘除法，加减法仍然有问题，因为加减法还存在浮点数的直接运算。

附：没有bug的代码。

```angular2html
function add(a, b) {
    var c, d, e;
    try {
        c = a.toString().split(".")[1].length;
    } catch (f) {
        c = 0;
    }
    try {
        d = b.toString().split(".")[1].length;
    } catch (f) {
        d = 0;
    }
    return e = Math.pow(10, Math.max(c, d)), (mul(a, e) + mul(b, e)) / e;
}
function sub(a, b) {
    var c, d, e;
    try {
        c = a.toString().split(".")[1].length;
    } catch (f) {
        c = 0;
    }
    try {
        d = b.toString().split(".")[1].length;
    } catch (f) {
        d = 0;
    }
    return e = Math.pow(10, Math.max(c, d)), (mul(a, e) - mul(b, e)) / e;
}
function mul(a, b) {
    var c = 0,
        d = a.toString(),
        e = b.toString();
    try {
        c += d.split(".")[1].length;
    } catch (f) {}
    try {
        c += e.split(".")[1].length;
    } catch (f) {}
    return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
}
function div(a, b) {
    var c, d, e = 0,
        f = 0;
    try {
        e = a.toString().split(".")[1].length;
    } catch (g) {}
    try {
        f = b.toString().split(".")[1].length;
    } catch (g) {}
    return c = Number(a.toString().replace(".", "")), d = Number(b.toString().replace(".", "")), mul(c / d, Math.pow(10, f - e));
}
```