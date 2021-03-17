什么是Vue.nextTick()

也就是操作DOM要在这个东西里面
```vue
self.$nextTick(function () {
                document.cc_form.submit();
              });
```


官方文档解释如下：

在下次 DOM 更新循环结束之后执行延迟回调。在修改数据之后立即使用这个方法，获取更新后的 DOM。

什么时候需要用的Vue.nextTick()


你在Vue生命周期的created()钩子函数进行的DOM操作一定要放在Vue.nextTick()的回调函数中。原因是什么呢，原因是在created()钩子函数执行的时候DOM 其实并未进行任何渲染，而此时进行DOM操作无异于徒劳，所以此处一定要将DOM操作的js代码放进Vue.nextTick()的回调函数中。与之对应的就是mounted钩子函数，因为该钩子函数执行时所有的DOM挂载和渲染都已完成，此时在该钩子函数中进行任何DOM操作都不会有问题 。

在数据变化后要执行的某个操作，而这个操作需要使用随数据改变而改变的DOM结构的时候，这个操作都应该放进Vue.nextTick()的回调函数中。

例子：
更新表单数据之后表单直接提交跳转

```vue
<form name="cc_form" :action="form.action" :method="form.method">
                    <input type="hidden" :name="form.token"/>
                    <public-label :LabelContent="rfwLabelAmount">
                        <public-input v-model="form.amount" :PublicInput="rfwLabelInput"/>
                    </public-label>
                    <p class="bill-title">Your must use your own VISA/Master card
                        or your transaction may not be processed.</p>
                    <p class="bill-title" style="font-size: 13px;">You will be directed to our VISA/Master Gateway: <a
                            href="https://live.adyen.com">live.adyen.com</a></p>
                    <div class="take-btn-group">
                        <public-btn @click="submit" :btnValue="inputBtnParameters"/>
                    </div>
                </form>
```
```vue
ccDeposit(this.form.amount).then(function (r) {
            const res = r.data;
            Indicator.close();
            if (res.code === 200) {
              self.form.method = res.data.method;
              self.form.token = res.data.token;
              self.form.action = res.data.url;
              self.$nextTick(function () {
                document.cc_form.submit();
              });
            } else {
              Message.warning(res.msg);
            }
          }, function (e) {
            Message.warning(e);
            Indicator.close();
          })
```

































