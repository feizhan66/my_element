一、查看CPU使用率

1. top 命令
```
[root@sss ~]# top
   top - 16:54:38 up 7 days,  5:13,  3 users,  load average: 0.00, 0.01, 0.05
   Tasks:  77 total,   2 running,  75 sleeping,   0 stopped,   0 zombie
   %Cpu(s):  0.7 us,  0.3 sy,  0.0 ni, 99.0 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st
   KiB Mem :  1882232 total,   813020 free,   330164 used,   739048 buff/cache
   KiB Swap:        0 total,        0 free,        0 used.  1386608 avail Mem

PID USER      PR  NI    VIRT    RES    SHR S %CPU %MEM     TIME+ COMMAND
17215 root       0 -20  127504  12176   9560 S  0.7  0.6  21:46.45 AliYunDun
2770 root      20   0  573932  17232   6088 S  0.3  0.9   1:11.38 tuned
1 root      20   0   43548   3844   2588 S  0.0  0.2   0:06.54 systemd
2 root      20   0       0      0      0 S  0.0  0.0   0:00.00 kthreadd
3 root      20   0       0      0      0 S  0.0  0.0   0:08.75 ksoftirqd/0
5 root       0 -20       0      0      0 S  0.0  0.0   0:00.00 kworker/0:0H
```

top命令可以看到总体的系统运行状态和cpu的使用率 。

%us：表示用户空间程序的cpu使用率（没有通过nice调度）
%sy：表示系统空间的cpu使用率，主要是内核程序。
%ni：表示用户空间且通过nice调度过的程序的cpu使用率。
%id：空闲cpu
%wa：cpu运行时在等待io的时间
%hi：cpu处理硬中断的数量
%si：cpu处理软中断的数量
%st：被虚拟机偷走的cpu
注：99.0 id，表示空闲CPU，即CPU未使用率，100%-99.0%=1%，即系统的cpu使用率为1%。

2. vmstat
详细使用和参数介绍参考网址

3. sar
   sar命令语法和vmstat一样。命令不存在时需要安装sysstat包，这个包很有用。
   1
   命令示例:

例如每1秒采集一次CPU使用率，共采集5次。
```
[root@sss ~]# sar -u 1 5
Linux 3.10.0-957.10.1.el7.x86_64 (izuf633l0ge76tv5mzalpmz)      04/16/2019      _x86_64_        (1 CPU)

04:56:03 PM     CPU     %user     %nice   %system   %iowait    %steal     %idle
04:56:04 PM     all      0.00      0.00      0.00      0.00      0.00    100.00
04:56:05 PM     all      0.00      0.00      0.00      0.00      0.00    100.00
04:56:06 PM     all      0.99      0.00      0.99      0.00      0.00     98.02
04:56:07 PM     all      0.00      0.00      0.00      0.00      0.00    100.00
04:56:08 PM     all      0.00      0.00      0.00      0.00      0.00    100.00
Average:        all      0.20      0.00      0.20      0.00      0.00     99.60
```

和top一样，可以看到所有cpu的使用情况。如果需要查看某颗cpu的使用可以用-P参数。例如指定显示0号cpu 的使用情况。

```
[root@sss ~]# sar -P 0 -u 1 5
Linux 3.10.0-957.10.1.el7.x86_64 (izuf633l0ge76tv5mzalpmz)      04/16/2019      _x86_64_        (1 CPU)

04:39:13 PM     CPU     %user     %nice   %system   %iowait    %steal     %idle
04:39:14 PM       0      0.00      0.00      0.99      0.00      0.00     99.01
04:39:15 PM       0      0.00      0.00      0.00      0.00      0.00    100.00
04:39:16 PM       0      0.00      0.00      0.00      0.00      0.00    100.00
04:39:17 PM       0      0.00      0.00      0.00      0.00      0.00    100.00
04:39:18 PM       0      1.00      0.00      0.00      0.00      0.00     99.00
Average:          0      0.20      0.00      0.20      0.00      0.00     99.60
[root@izuf633l0ge76tv5mzalpmz ~]#
```

进程队列长度和平均负载状态
例如每1秒采集一次，共采集5次。

```
[root@sss ~]# sar -q 1 5
Linux 3.10.0-957.10.1.el7.x86_64 (izuf633l0ge76tv5mzalpmz)      04/16/2019      _x86_64_        (1 CPU)

04:40:14 PM   runq-sz  plist-sz   ldavg-1   ldavg-5  ldavg-15   blocked
04:40:15 PM         0       149      0.00      0.01      0.05         0
04:40:16 PM         0       149      0.00      0.01      0.05         0
04:40:17 PM         0       149      0.00      0.01      0.05         0
04:40:18 PM         1       149      0.00      0.01      0.05         0
04:40:19 PM         1       149      0.00      0.01      0.05         0
Average:            0       149      0.00      0.01      0.05         0
```

输出项：

runq-sz：运行队列的长度（等待运行的进程数）

plist-sz：进程列表中进程（processes）和线程（threads）的数量

ldavg-1：最后1分钟的系统平均负载（System load average）

ldavg-5：过去5分钟的系统平均负载

ldavg-15：过去15分钟的系统平均负载

创建的平均值和上下文切换的次数
例如每1秒收集一次，共收集5次。

```
[root@sss ~]# sar -w 1 5
Linux 3.10.0-957.10.1.el7.x86_64 (izuf633l0ge76tv5mzalpmz)      04/16/2019      _x86_64_        (1 CPU)

04:41:39 PM    proc/s   cswch/s
04:41:40 PM      0.00    274.26
04:41:41 PM      0.00    277.78
04:41:42 PM      0.00    285.00
04:41:43 PM      0.00    280.00
04:41:44 PM      0.00    270.00
Average:         0.00    277.40
```

sar命令也可以获取过去指定日期的性能参数。

```
[root@sss ~]# sar -u -f /var/log/sa/sa08
Linux 3.10.0-693.2.2.el7.x86_64 (localhost.localdomain)         04/08/2019      _x86_64_        (1 CPU)

10:54:35 AM       LINUX RESTART

11:00:02 AM     CPU     %user     %nice   %system   %iowait    %steal     %idle
11:10:01 AM     all     12.93      0.23      2.89      1.54      0.00     82.41
11:20:01 AM     all     46.58      0.00      8.81      0.79      0.00     43.82
11:30:01 AM     all     44.93      0.00      9.68      0.15      0.00     45.24
11:40:02 AM     all      0.25      0.00      0.15      0.00      0.00     99.60
11:50:01 AM     all      0.19      0.00      0.13      0.00      0.00     99.68
12:00:01 PM     all      0.31      0.00      0.19      0.14      0.00     99.37
```

4. mpstat
这个命令也在sysstat包中，语法类似。
cpu使用情况比sar更加详细些，也可以用-P指定某颗cpu 。

例如每1秒收集一次，共5次。

```
[root@sss ~]# mpstat 1 5
Linux 3.10.0-957.10.1.el7.x86_64 (izuf633l0ge76tv5mzalpmz)      04/16/2019      _x86_64_        (1 CPU)

04:58:01 PM  CPU    %usr   %nice    %sys %iowait    %irq   %soft  %steal  %guest  %gnice   %idle
04:58:02 PM  all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
04:58:03 PM  all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
04:58:04 PM  all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
04:58:05 PM  all    1.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00   99.00
04:58:06 PM  all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
Average:     all    0.20    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00   99.80
```

5. iostat
这个命令主要用来查看io使用情况，也可以来查看cpu，个人感觉不常用。
1
示例
```
[root@sss ~]# iostat -c 1 2
Linux 3.10.0-957.10.1.el7.x86_64 (izuf633l0ge76tv5mzalpmz)      04/16/2019      _x86_64_        (1 CPU)

avg-cpu:  %user   %nice %system %iowait  %steal   %idle
0.26    0.00    0.21    0.01    0.00   99.53

avg-cpu:  %user   %nice %system %iowait  %steal   %idle
0.00    0.00    0.00    0.00    0.00  100.00
```

6. dstat
每秒cpu使用率情况获取
```
[root@sss ~]#  dstat -c
----total-cpu-usage----
usr sys idl wai hiq siq
0   0 100   0   0   0
0   1  99   0   0   0
1   0  99   0   0   0
0   0 100   0   0   0
0   0 100   0   0   0
1   1  98   0   0   0
0   0 100   0   0   0
```

最占cpu的进程获取

[root@sss ~]# dstat --top-cpu-most-expensive-
cpu processAliYunDun    0.2
AliYunDun    2.0
mysqld       1.0
AliYunDun    1.0
kworker/0:1H 1.0
AliYunDun    1.0
AliYunDun    1.0
AliYunDun    1.0
```

# 二、查看内存使用率

1. top命令

查看第四行: KiB Mem
内存使用率: used/ total

2. free命令
free命令可以显示Linux系统中空闲的、已用的物理内存及swap内存,及被内核使用的buffer。在Linux系统监控的工具中，free命令是最经常使用的命令之一。

1．命令格式：
free [参数]
1
2．命令功能：
free 命令显示系统使用和空闲的内存情况，包括物理内存、交互区内存(swap)和内核缓冲区内存。共享内存将被忽略
1
3．命令参数：
-b 　以Byte为单位显示内存使用情况。

-k 　以KB为单位显示内存使用情况。

-m 　以MB为单位显示内存使用情况。

-g   以GB为单位显示内存使用情况。

-o 　不显示缓冲区调节列。

-s<间隔秒数> 　持续观察内存使用状况。

-t 　显示内存总和列。

-V 　显示版本信息。

4．使用实例：
实例1：显示内存使用情况

命令示例：

free [-k] # 以 kb  为单位显示内存使用状况
free -g # 以 G 为单位显示内存使用状况
free -m # 以 M 为单位显示内存使用状况
free -t  # 以总和的形式显示内存的使用信息
free -s 1 # 每一秒显示内存使用情况

输出：

```
[root@sss ~]# free
total        used        free      shared  buff/cache   available
Mem:        1882232      331760      811004         592      739468     1384944
Swap:             0           0           0
```

```
[root@sss ~]# free -g
total        used        free      shared  buff/cache   available
Mem:              1           0           0           0           0           1
Swap:             0           0           0
```

```
[root@sss ~]# free -m
total        used        free      shared  buff/cache   available
Mem:           1838         324         791           0         722        1352
Swap:             0           0           0
```

```
[root@sss ~]# free -t
total        used        free      shared  buff/cache   available
Mem:        1882232      331760      811004         592      739468     1384948
Swap:             0           0           0
Total:      1882232      331760      811004
```

```
[root@sss ~]# free -s 1
total        used        free      shared  buff/cache   available
Mem:        1882232      331760      811004         592      739468     1384948
Swap:             0           0           0

          total        used        free      shared  buff/cache   available
Mem:        1882232      331784      810980         592      739468     1384924
Swap:             0           0           0

          total        used        free      shared  buff/cache   available
Mem:        1882232      331784      810980         592      739468     1384924
Swap:             0           0           0
```

说明–对这些数值的解释：

total:总计物理内存的大小。

used:已使用多大。

free:可用有多少。

Shared:多个进程共享的内存总额。

Buff/cache:磁盘缓存的大小。

第三行是交换分区SWAP的，也就是我们通常所说的虚拟内存。
当可用内存少于额定值的时候，就会进行交换

如何看额定值：
命令：
```
cat /proc/meminfo
```
输出：

```
[root@sss ~]# cat /proc/meminfo
MemTotal:        1882232 kB
MemFree:          811244 kB
MemAvailable:    1385300 kB
Buffers:           81268 kB
Cached:           602500 kB
SwapCached:            0 kB
Active:           601948 kB
Inactive:         379880 kB
Active(anon):     298392 kB
Inactive(anon):      256 kB
Active(file):     303556 kB
Inactive(file):   379624 kB
Unevictable:           0 kB
Mlocked:               0 kB
SwapTotal:             0 kB
SwapFree:              0 kB
Dirty:               320 kB
Writeback:             0 kB
AnonPages:        298052 kB
Mapped:            47236 kB
Shmem:               592 kB
Slab:              55772 kB
SReclaimable:      44076 kB
SUnreclaim:        11696 kB
KernelStack:        2384 kB
PageTables:         5808 kB
NFS_Unstable:          0 kB
Bounce:                0 kB
WritebackTmp:          0 kB
CommitLimit:      941116 kB
Committed_AS:     810896 kB
VmallocTotal:   34359738367 kB
VmallocUsed:       10604 kB
VmallocChunk:   34359719676 kB
HardwareCorrupted:     0 kB
AnonHugePages:    237568 kB
CmaTotal:              0 kB
CmaFree:               0 kB
HugePages_Total:       0
HugePages_Free:        0
HugePages_Rsvd:        0
HugePages_Surp:        0
Hugepagesize:       2048 kB
DirectMap4k:       63360 kB
DirectMap2M:     2033664 kB
DirectMap1G:           0 kB
```
交换将通过三个途径来减少系统中使用的物理页面的个数：

1.减少缓冲与页面cache的大小，

2.将系统V类型的内存页面交换出去，　

3.换出或者丢弃页面。(Application 占用的内存页，也就是物理内存不足）。

事实上，少量地使用swap是不是影响到系统性能的。

那buffers和cached都是缓存，两者有什么区别呢？

为了提高磁盘存取效率, Linux做了一些精心的设计, 除了对dentry进行缓存(用于VFS,加速文件路径名到inode的转换), 还采取了两种主要Cache方式：Buffer Cache和Page Cache。前者针对磁盘块的读写，后者针对文件inode的读写。这些Cache有效缩短了 I/O系统调用(比如read,write,getdents)的时间。

磁盘的操作有逻辑级（文件系统）和物理级（磁盘块），这两种Cache就是分别缓存逻辑和物理级数据的。

Page cache实际上是针对文件系统的，是文件的缓存，在文件层面上的数据会缓存到page cache。文件的逻辑层需要映射到实际的物理磁盘，这种映射关系由文件系统来完成。当page cache的数据需要刷新时，page cache中的数据交给buffer cache，因为Buffer Cache就是缓存磁盘块的。但是这种处理在2.6版本的内核之后就变的很简单了，没有真正意义上的cache操作。

Buffer cache是针对磁盘块的缓存，也就是在没有文件系统的情况下，直接对磁盘进行操作的数据会缓存到buffer cache中，例如，文件系统的元数据都会缓存到buffer cache中。

简单说来，page cache用来缓存文件数据，buffer cache用来缓存磁盘数据。在有文件系统的情况下，对文件操作，那么数据会缓存到page cache，如果直接采用dd等工具对磁盘进行读写，那么数据会缓存到buffer cache。

所以我们看linux,只要不用swap的交换空间,就不用担心自己的内存太少.如果常常swap用很多,可能你就要考虑加物理内存了.这也是linux看内存是否够用的标准.

如果是应用服务器的话，一般只看第二行，+buffers/cache,即对应用程序来说free的内存太少了，也是该考虑优化程序或加内存了。

实例2：以总和的形式显示内存的使用信息
命令：

free -t 
1
输出：
```
[root@sss ~]# free -t
total        used        free      shared  buff/cache   available
Mem:        1882232      331760      811004         592      739468     1384948
Swap:             0           0           0
Total:      1882232      331760      811004
```
实例3：周期性的查询内存使用信息
命令：

free -s 10
1
输出：
```
[root@sss ~]# free -s 10
total        used        free      shared  buff/cache   available
Mem:        1882232      324924      816688         496      740620     1392280
Swap:             0           0           0

          total        used        free      shared  buff/cache   available
Mem:        1882232      324944      816664         496      740624     1392260
Swap:             0           0           0
```
说明：

每10s 执行一次命令
1
三、查看磁盘使用率

1. 输入df命令
   [root@sss ~]# df
   1
   显示详情:

Filesystem	1K-blocks	Used	Available	Use%	Mounted on
/dev/vda1	41151808	3794244	35244132	10%	/
devtmpfs	930644	0	930644	0%	/dev
tmpfs	941116	0	941116	0%	/dev/shm
tmpfs	941116	468	940648	1%	/run
tmpfs	941116	0	941116	0%	/sys/fs/cgroup
tmpfs	188224	0	188224	0%	/run/user/0
说明

磁盘使用率=(Used列数据之和)/(1k-blocks列数据之和)
1
磁盘和内存的区别与联系：

(磁盘--也叫硬盘--或是U盘--或是移动硬盘)

1. 硬盘与内存都是存储器，一个是内部，一个是外部。
2. 硬盘与内存的区别是很大的，这里只谈最主要的三点：
   1）内存是计算机的工作场所，硬盘用来存放暂时不用的信息；
   2）内存是半导体材料制作，硬盘是磁性材料制作；
   3）内存中的信息会随掉电而丢失，硬盘中的信息可以长久保存。
3. 内存与硬盘的联系也非常密切：
   硬盘上的信息永远是暂时不用的，要用请装入内存！
   CPU与硬盘不发生直接的数据交换，CPU只是通过控制信号指挥硬盘工作，硬盘上的信息只有在装入内存后才能被处理。
4. 计算机的启动过程就是一个从硬盘上把最常用信息装入内存的过程。
5. 硬盘则决定你的电脑可以装下多少东西，内存则决定你的电脑开机后一次最多可以运行多少程序（如手机运行内存）。
