# 查看已安装的Linux发行版本

```bash
wsl -l --all -v
```

# 导出分发版为tar文件到d盘

```bash
wsl --export Ubuntu-20.04 d:\wsl-ubuntu20.04.tar
```

# 注销当前分发版

```bash
wsl --unregister Ubuntu-20.04
```

# 重新导入并安装WSL在D盘

```bash
wsl --import Ubuntu-20.04 d:\wsl-ubuntu20.04 d:\wsl-ubuntu20.04.tar --version 2
```

# 设置默认登录用户为安装时用户名

```bash
ubuntu2004 config --default-user USERNAME
```

# 删除wsl-ubuntu20.04.tar

```bash
del d:\wsl-ubuntu20.04.tar
```
