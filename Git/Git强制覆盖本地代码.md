**git强制覆盖**：

```git
git fetch --all
git reset --hard origin/master
git pull
```

git强制覆盖本地命令（单条执行）：

```git
git fetch --all &&
git reset --hard origin/master && git pull
```

第一个是：拉取所有更新，不同步；

第二个是：本地代码同步线上最新版本(会覆盖本地所有与远程仓库上同名的文件)；

第三个是：再更新一次（其实也可以不用，第二步命令做过了其实）
