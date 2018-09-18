### 指定解析器
```
#!/bin/bash
```

### 输出
```
echo "这是输出的内容"
```

### 获取当前文件的根路径
```
root=$(cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd)
```

### 切换目录
```
cd "你的目录路径"
```

### 引入资源
```
source "$root/env.sh"
```

### 使用参数
```
a = "黄新云“
echo $a
```

### 条件判断
```
ym=$month
if [[ $ym == "" ]];then
  ym=`date +"%Y-%m"`
fi;
echo $ym
```

### For循环
```
for item in {1,2};do
    echo $item
done
```

### 获取当前的日期
```
dd=`date -d "" '+%Y-%m-%d'`
echo $dd

DATE=$(date +%Y%m%d)
echo $DATE
```

### 获取昨天的日期
```
d=`date -d "yesterday 00:00" '+%Y-%m-%d'`
echo $d
```

### 用ps获取某名称进程数量
```
PRO_NAME=queue:work
NUM=`ps aux | grep ${PRO_NAME} | grep -v grep |wc -l`
echo $NUM
```

### 杀死进程
```
ps -aux|grep ${PRO_NAME}|grep -v grep|cut -c 9-15|xargs kill -9
```

### 杀死僵尸进程
```
NUM_STAT=`ps aux | grep ${PRO_NAME} | grep T | grep -v grep | wc -l`
```



