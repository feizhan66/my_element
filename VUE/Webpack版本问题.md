项目版本配置比CLI高会导致错误

解决办法：重新安装相对应的版本

```vue
// 卸载旧版本
npm uninstall webpack -g
npm uninstall -g webpack-dev-server

// 安装新版本
npm install webpack@3.8.0 --save-dev
npm install webpack-dev-server@2.9.7 --save-dev

```