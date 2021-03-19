
# JS数组遍历：


1，普通for循环，经常用的数组遍历
```
var arr = [1,2,0,3,9];
 for ( var i = 0; i <arr.length; i++){
    console.log(arr[i]);
}
```

2，优化版for循环:使用变量，将长度缓存起来，避免重复获取长度，数组很大时优化效果明显
```
for(var j = 0,len = arr.length; j < len; j++){
    console.log(arr[j]);
}
```

3，forEach，ES5推出的,数组自带的循环，主要功能是遍历数组，实际性能比for还弱
```
arr.forEach(function(value,i){
　　console.log('forEach遍历:'+i+'--'+value);
})
```

forEach这种方法也有一个小缺陷：你不能使用break语句中断循环，也不能使用return语句返回到外层函数。

4,map遍历，map即是 “映射”的意思 用法与 forEach 相似
```
arr.map(function(value,index){
    console.log('map遍历:'+index+'--'+value);
});
```

map遍历支持使用return语句，支持return返回值
```
var temp=arr.map(function(val,index){
  console.log(val);
  return val*val
})
console.log(temp);
```

forEach、map都是ECMA5新增数组的方法，所以ie9以下的浏览器还不支持

5，for-of遍历 是ES6新增功能
```
for( let i of arr){
    console.log(i);
}
```

for-of这个方法避开了for-in循环的所有缺陷
与forEach()不同的是，它可以正确响应break、continue和return语句
for-of循环不仅支持数组，还支持大多数类数组对象，例如DOM NodeList对象。

for-of循环也支持字符串遍历


# JS对象遍历：

for-in遍历

for-in是为遍历对象而设计的，不适用于遍历数组。

遍历数组的缺点：数组的下标index值是数字，for-in遍历的index值"0","1","2"等是字符串

```
for (var index in arr){
    console.log(arr[index]);
    console.log(index);
}
```
