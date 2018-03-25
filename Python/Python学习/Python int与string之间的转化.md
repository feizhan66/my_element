# Python int与string之间的转化

- string-->int

``` 
1、10进制string转化为int

　　int('12')

2、16进制string转化为int

　　int('12', 16)
```


- int-->string
```

1、int转化为10进制string

　　str(18)

2、int转化为16进制string

　　hex(18)

```
- 考虑，为什么没有16进制int转化为string，可以这么认为不管什么进制，python在内部表示都是10进制，先转化为10进制在进行。如16进制int转化为string，str(0x12)，首先变为str(18)，再到'18'。那么我想结果为'12'，怎么办？这其实就是10进制int转化为string，即hex(0x12)。








