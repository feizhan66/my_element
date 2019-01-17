在methods中定义websocket函数 
方法一：
```vue
 websocket () {
     let ws = new WebSocket('ws://localhost:8080')
     ws.onopen = () => {
        // Web Socket 已连接上，使用 send() 方法发送数据
          ws.send('Holle')
          console.log('数据发送中...')
      }
      ws.onmessage = evt => {
        // console.log('数据已接收...')
      }
      ws.onclose = function () {
        // 关闭 websocket
        console.log('连接已关闭...')
      }
      // 路由跳转时结束websocket链接
      this.$router.afterEach(function () {
        ws.close()
      })
    }

```
方法二：

```vue
methods: {
    websocket () {
         let ws = new WebSocket('ws://localhost:8080')
         ws.onopen = () => {
            // Web Socket 已连接上，使用 send() 方法发送数据
              ws.send('Holle')
              console.log('数据发送中...')
          }
          ws.onmessage = evt => {
            // console.log('数据已接收...')
          }
          ws.onclose = function () {
            // 关闭 websocket
            console.log('连接已关闭...')
          }
           // 组件销毁时调用，中断websocket链接
          this.over = () => {
            ws.close()
          }
    }
},  
beforeDestroy () {
    this.over()
}

```
