```haml
<ul>
  <li>1</li>
  <li>2</li>
  <li>3</li>
  <li>4</li>
  <li>5</li>
</ul>
```

```css
ul li:first-child{
/*选择了第一个li*/
}
ul li:last-child{
/*选择了第二个li*/
}

ul li:nth-child(3){
/*选择了第三个li*/
}
/*或者*/
ul li:nth-of-type(4){
/*选中第四个*/
}
```

```css
/*各行变色效果*/
ul li:nth-child(2n+0){
}

```

```css
li:nth-child(4){}
/*与*/
li:nth-of-type(4){}
区别是：第一个当子几集符合要求才能使用

第二个是选择li类型下的第四个
```

