一：设置环境变量的三种方法
1.1 临时设置

export PATH=/home/yan/share/usr/local/arm/3.4.1/bin:$PATH

    

1.2 当前用户的全局设置

打开~/.bashrc，添加行：

export PATH=/home/yan/share/usr/local/arm/3.4.1/bin:$PATH

使生效：

source .bashrc

1.3 所有用户的全局设置

$ vim /etc/profile

在里面加入：

export PATH=/home/yan/share/usr/local/arm/3.4.1/bin:$PATH

使生效

source profile

特别注意：这种方法重启后才全局生效！！！

二： 测试当前的环境变量

echo $PATH
或
env


用户登录后加载profile和bashrc的流程如下:

1. /etc/profile
    ->/etc/profile.d/*.sh

2. $HOME/.bash_profile
    ->$HOME/.bashrc
        ->/etc/bashrc



说明:
bash首先执行/etc/profile脚本,/etc/profile脚本先依次执行/etc/profile.d/*.sh
随后bash会执行用户主目录下的.bash_profile脚本,.bash_profile脚本会执行用户主目录下的.bashrc脚本,
而.bashrc脚本会执行/etc/bashrc脚本。
至此,所有的环境变量和初始化设定都已经加载完成.
bash随后调用terminfo和inputrc，完成终端属性和键盘映射的设定.

其中PATH这个变量特殊说明一下:

    如果是超级用户登录,在没有执行/etc/profile之前,PATH已经设定了下面的路径:
    /usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin
    如果是普通用户,PATH在/etc/profile执行之前设定了以下的路径:
    /usr/local/bin:/bin:/usr/bin

这里要注意的是:在用户切换并加载变量,例如su -,这时，如果用户自己切换自己,比如root用户再用su - root切换的话,加载的PATH和上面的不一样.
准确的说，是不总是一样.所以，在/etc/profile脚本中，做了如下的配置:

if [ `id -u` = 0 ]; then
pathmunge /sbin
pathmunge /usr/sbin
pathmunge /usr/local/sbin
fi



如果是超级用户登录,在/etc/profile.d/krb5.sh脚本中,在PATH变量搜索路径的最前面增加/usr/kerberos/sbin:/usr/kerberos/bin
如果是普通用户登录,在/etc/profile.d/krb5.sh脚本中,在PATH变量搜索路径的最前面增加/usr/kerberos/bin

在/etc/profile脚本中,会在PATH变量的最后增加/usr/X11R6/bin目录
在HOME/.bashprofile中,会在PATH变量的最后增加

HOME/bin目录

以root用户为例,最终的PATH会是这样(没有其它自定义的基础上)

/usr/kerberos/sbin:/usr/kerberos/bin:/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/usr/X11R6/bin:/root/bin

    1
    2

以alice用户(普通用户)为例

/usr/kerberos/bin:/usr/bin:/bin:/usr/X11R6/bin:/home/alice/bin

    1

三：脚本解析

###############################################
#strace -o su -e trace=open su - alice
#grep ^open /etc/su|grep -v null|grep "= 3"|nl
###############################################



3.1 打开的文件如下:

1    open("/etc/ld.so.cache", O_RDONLY)      = 3
2    open("/lib/libcrypt.so.1", O_RDONLY)    = 3
3    open("/lib/tls/libc.so.6", O_RDONLY)    = 3
4    open("/usr/lib/locale/locale-archive", O_RDONLY|O_LARGEFILE) = 3
5    open("/etc/nsswitch.conf", O_RDONLY)    = 3
6    open("/etc/ld.so.cache", O_RDONLY)      = 3
7    open("/lib/libnss_files.so.2", O_RDONLY) = 3
8    open("/etc/passwd", O_RDONLY)           = 3
9    open("/etc/shadow", O_RDONLY)           = 3
10    open("/etc/group", O_RDONLY)            = 3
11    open("/etc/ld.so.cache", O_RDONLY)      = 3
12    open("/lib/libtermcap.so.2", O_RDONLY)  = 3
13    open("/lib/libdl.so.2", O_RDONLY)       = 3
14    open("/lib/tls/libc.so.6", O_RDONLY)    = 3
15    open("/dev/tty", O_RDWR|O_NONBLOCK|O_LARGEFILE) = 3
16    open("/etc/mtab", O_RDONLY)             = 3
17    open("/proc/meminfo", O_RDONLY)         = 3
18    open("/etc/nsswitch.conf", O_RDONLY)    = 3
19    open("/etc/ld.so.cache", O_RDONLY)      = 3
20    open("/lib/libnss_files.so.2", O_RDONLY) = 3
21    open("/etc/passwd", O_RDONLY)           = 3
22    open("/etc/profile", O_RDONLY|O_LARGEFILE) = 3
23    open("/etc/profile.d/", O_RDONLY|O_NONBLOCK|O_LARGEFILE|O_DIRECTORY) = 3
24    open("/etc/profile.d/colorls.sh", O_RDONLY|O_LARGEFILE) = 3
25    open(".", O_RDONLY|O_NONBLOCK|O_LARGEFILE|O_DIRECTORY) = 3
26    open("/etc/profile.d/glib2.sh", O_RDONLY|O_LARGEFILE) = 3
27    open("/etc/profile.d/gnome-ssh-askpass.sh", O_RDONLY|O_LARGEFILE) = 3
28    open("/etc/profile.d/krb5.sh", O_RDONLY|O_LARGEFILE) = 3
29    open("/etc/profile.d/lang.sh", O_RDONLY|O_LARGEFILE) = 3
30    open("/etc/sysconfig/i18n", O_RDONLY|O_LARGEFILE) = 3
31    open("/usr/lib/locale/locale-archive", O_RDONLY|O_LARGEFILE) = 3
32    open("/usr/lib/gconv/gconv-modules.cache", O_RDONLY) = 3
33    open("/etc/profile.d/less.sh", O_RDONLY|O_LARGEFILE) = 3
34    open("/etc/profile.d/qt.sh", O_RDONLY|O_LARGEFILE) = 3
35    open("/etc/profile.d/vim.sh", O_RDONLY|O_LARGEFILE) = 3
36    open("/etc/profile.d/which-2.sh", O_RDONLY|O_LARGEFILE) = 3
37    open("/ceno/prod t/imeg/etc/profile", O_RDONLY|O_LARGEFILE) = 3
38    open("/home/alice/.bash_profile", O_RDONLY|O_LARGEFILE) = 3
39    open("/home/alice/.bashrc", O_RDONLY|O_LARGEFILE) = 3
40    open("/etc/bashrc", O_RDONLY|O_LARGEFILE) = 3
41    open("/home/alice/.bash_history", O_RDONLY|O_LARGEFILE) = 3
42    open("/home/alice/.bash_history", O_RDONLY|O_LARGEFILE) = 3
43    open("/etc/termcap", O_RDONLY)          = 3
44    open("/etc/inputrc", O_RDONLY|O_LARGEFILE) = 3
45    open(".", O_RDONLY|O_NONBLOCK|O_LARGEFILE|O_DIRECTORY) = 3
46    open("/home/alice/.bash_logout", O_RDONLY|O_LARGEFILE) = 3
47    open("/home/alice/.bash_history", O_WRONLY|O_APPEND|O_LARGEFILE) = 3
48    open("/home/alice/.bash_history", O_RDONLY|O_LARGEFILE) = 3



3.2 脚本解析说明
3.2.1 第一部分

从1-21行基本是打开动态链接库文件和身份验证的文件.
3.2.2 第二部分

第22行是打开/etc/profile文件,如下:

# /etc/profile

# System wide environment and startup programs, for login setup
# Functions and aliases go in /etc/bashrc

#定义pathmunge函数
#echo $PATH | /bin/egrep -q "(^|:)$1($|:)"是过滤$PATH中的可执行目录,如果egrep到批配项,返回真但取反
#也就是不增加执行目录到$PATH中,选项-q禁止所有的输出到标准输出，不管匹配行。如果选中输入行，以 0 状态退出
#这里由 | (竖线)或者换行符隔开的多个正则表达式会匹配与任何一个正则表达式所匹配的字符串
#一个正则表达式可以被包括在“()”（括弧）中进行分组
pathmunge () {
if ! echo $PATH | /bin/egrep -q "(^|:)$1($|:)" ; then
if [ "$2" = "after" ] ; then
PATH=$PATH:$1
else
PATH=$1:$PATH
fi
fi
}

#如果uid为0的用户,将在$PATH变量上加入/sbin/,/usr/sbin,/usr/local/sbin三个目录-q "(^|:)($|:)"
#因为调用pathmunge函数，没有加入after参数,所以以上三个目录都加在了$PATH变量的最前面
# Path manipulation
if [ `id -u` = 0 ]; then
pathmunge /sbin
pathmunge /usr/sbin
pathmunge /usr/local/sbin
fi



#调用pathmunge函数,在$PATH后面增加/usr/X11R6/bin
pathmunge /usr/X11R6/bin after

unset pathmunge

#ulimit设定-S为软控制,-c为core file文件大小,这里是不做限制
# No core files by default
ulimit -S -c 0 > /dev/null 2>&1

#id -un是打印输出当前的用户名,例如:root
#定义了LOGNAME变量和MAIL变量,会有程序用到这些变量
USER="`id -un`"
LOGNAME=$USER
MAIL="/var/spool/mail/$USER"


#通过/bin/hostname获取主机名
#定义history的记录数为1000
HOSTNAME=`/bin/hostname`
HISTSIZE=1000



#如果没有定义$INPUTRC并且不存在$HOME/.inputrc文件
#定义变量INPUTRC的值为/etc/inputrc
if [ -z "$INPUTRC" -a ! -f "$HOME/.inputrc" ]; then
INPUTRC=/etc/inputrc
fi

export REMOTE_JAVA_DEBUG=on
export PATH USER LOGNAME MAIL HOSTNAME HISTSIZE INPUTRC


#执行/etc/profile.d/下的所有脚本,-r是确认它们可读
for i in /etc/profile.d/*.sh ; do
if [ -r "$i" ]; then
. $i
fi
done

unset i
. /ceno/prod t/imeg/etc/profile

export PS1="\[\e[32;1m\][\u@\h]\[\e[33;1m\]:\[\e[31;1m\]\w>\\$ \[\e[0m\]"



3.2.3 第三部分

从24行到36行是执行/etc/profile.d/下的所有脚本，这个执行过程在/etc/profile中定义.
见前面/etc/profile中的脚本分析.

下面是对/etc/profile.d/下脚本做的简要说明,主要设定了环境变量(例如:PATH),alias等
/etc/profile.d/colorls.sh:对/etc/DIR_COLORS的提取,并用dircolors进行设定,最后定义了一些ls的alias
/etc/profile.d/glib2.sh:设定G_BROKEN_FILENAMES=1
/etc/profile.d/gnome-ssh-askpass.sh:设定SSH_ASKPASS=/usr/libexec/openssh/gnome-ssh-askpass
/etc/profile.d/krb5.sh:增加/usr/kerberos/bin或/usr/kerberos/sbin到PATH变量中
/etc/profile.d/lang.sh:设定语言环境,首先会加载/etc/sysconfig/i18n中的环境变量(LANG,SUPPORTED,SYSFONT)到shell中,
根据以上的变量再定义语言环境支持子集,最后再根据LANG设定终端

/etc/profile.d/less.sh:设定LESSOPEN="|/usr/bin/lesspipe.sh %s",LANGVAR=$LANG
/etc/profile.d/qt.sh:设定QTDIR="/usr/lib/qt-3.1"
/etc/profile.d/vim.sh:设定alias vi=vim
/etc/profile.d/which-2.sh:设定alias which='alias | /usr/bin/which --tty-only --read-alias --show-dot --show-tilde'


3.2.4 第四部分

第37行open(“/ceno/prod t/imeg/etc/profile”, O_RDONLY|O_LARGEFILE) = 3，这里加载了用户自己的环境设定脚本.
3.2.5 第五部分

第38行open(“/home/alice/.bash_profile”, O_RDONLY|O_LARGEFILE) = 3
第39行open(“/home/alice/.bashrc”, O_RDONLY|O_LARGEFILE) = 3
第40行open(“/etc/bashrc”, O_RDONLY|O_LARGEFILE) = 3

第一步:bash打开/home/alice/.bash_profile文件,
第二步:.bash_profile文件再判断有无/home/alice/.bashrc,如果有加载.bashrc文件
第三步:最后通过.bashrc文件加载/etc/bashrc文件
3.2.6 第六部分

在41行open(“/home/alice/.bash_history”, O_RDONLY|O_LARGEFILE) = 3
在42行open(“/home/alice/.bash_history”, O_RDONLY|O_LARGEFILE) = 3
在43行open(“/etc/termcap”, O_RDONLY) = 3
在44行open(“/etc/inputrc”, O_RDONLY|O_LARGEFILE) = 3

第一步打开.bash_history文件准备记录命令
第二步打开termcap文件
terminfo 数据库用于定义终端和打印机的属性及功能，包括各设备（例如，终端和打印机）的行数和列数以及要发送至该设备的文本的属性
第三步打开inputrc
inputrc 文件为特定的情况处理键盘映射，这个文件被 Readline 用作启动文件，Readline 是 Bash 和其它大多数 shell 使用的与输入相关的库
3.2.7 第七部分:

第46行open(“/home/alice/.bash_logout”, O_RDONLY|O_LARGEFILE) = 3
第47行open(“/home/alice/.bash_history”, O_WRONLY|O_APPEND|O_LARGEFILE) = 3
第48行open(“/home/alice/.bash_history”, O_RDONLY|O_LARGEFILE) = 3

这里是用户用logout或exit退出的表现.如果直接关闭掉terminal,则不会执行.bash_logout和写回.bash_history文件
.bash_logout脚本默认是调用clear清一下屏幕