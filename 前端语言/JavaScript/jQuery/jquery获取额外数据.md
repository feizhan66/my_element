有时需要放置一些额外数据在标签上
```html
<ul>
    <li data-id="i" data-name="huang">Data</li>
</ul>

JQ获取方式：
$(this).attr('data-id');
或：
$(this).data('id');
```